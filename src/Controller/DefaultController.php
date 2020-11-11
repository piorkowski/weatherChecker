<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\RequestCityWeatherType;
use App\Services\ReportServiceInterface;
use App\Services\WeatherCheckerServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultController extends AbstractController
{
    private $weatherCheckerService;

    private $reportService;

    private $cache;

    public function __construct(
        WeatherCheckerServiceInterface $weatherCheckerService,
        ReportServiceInterface $reportService,
        CacheInterface $cache
    )
    {
        $this->weatherCheckerService = $weatherCheckerService;
        $this->reportService = $reportService;
        $this->cache = $cache;
    }

    /**
     * @Route("/", name="default", methods={"GET|POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(RequestCityWeatherType::class, null, [
            'method' => 'POST',
            'action' => $this->generateUrl('default')
        ]);

        if(($request->getMethod() === 'POST') && $request->get('city')) {
            return $this->redirectToRoute('checkCityWeather', ['city' => $request->get('city')]);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('checkCityWeather', ['city' => $form->get('city')->getData()]);
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/check/{city}", name="checkCityWeather")
     * @param Request $request
     * @param string $city
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function checkCityWeather(Request $request, string $city): Response
    {
        $weatherCheckerService = $this->weatherCheckerService;
        $avg_temp = $this->cache->get(mb_strtolower($city, 'UTF-8'), function (ItemInterface $item) use ($city, $weatherCheckerService) {
            $item->expiresAfter(\DateInterval::createFromDateString('1 hour'));
            $temp = $weatherCheckerService->getAvgTempForCity($city);
            $item->set($temp);
            return $temp;
        });

        $this->reportService->createReport($city, $avg_temp, $request->getClientIp(), $this->getUser());

        return $this->render('default/city_weather.html.twig', [
            'controller_name' => 'DefaultController',
            'city' => $city,
            'avg_temp' => $avg_temp
        ]);
    }

    /**
     * @Route("/reports/user", name="user_reports")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function userReports(Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $this->reportService->getUserReports($this->getUser()),
            $request->query->getInt('page', 1)
        );

        return $this->render('default/reports.html.twig', [
            'controller_name' => 'DefaultController',
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/reports/all", name="all_reports")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function allReports(Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $this->reportService->getAllReports(),
            $request->query->getInt('page', 1)
        );

        return $this->render('default/reports.html.twig', [
            'controller_name' => 'DefaultController',
            'pagination' => $pagination,
        ]);
    }
}
