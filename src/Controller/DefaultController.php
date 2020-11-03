<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\RequestCityWeatherType;
use App\Services\ReportServiceInterface;
use App\Services\WeatherCheckerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $weatherCheckerService;

    private $reportService;

    public function __construct(
        WeatherCheckerServiceInterface $weatherCheckerService,
        ReportServiceInterface $reportService
    )
    {
        $this->weatherCheckerService = $weatherCheckerService;
        $this->reportService = $reportService;
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
     */
    public function checkCityWeather(Request $request, string $city): Response
    {
        $avg_temp = $this->weatherCheckerService->getAvgTempForCity($city);

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
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function userReports(Request $request): Response
    {
        $reports = $this->reportService->getUserReports($this->getUser());

        return $this->render('default/reports.html.twig', [
            'controller_name' => 'DefaultController',
            'reports' => $reports
        ]);
    }

    /**
     * @Route("/reports/all", name="all_reports")
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function allReports(Request $request): Response
    {
        $reports = $this->reportService->getAllReports();

        return $this->render('default/reports.html.twig', [
            'controller_name' => 'DefaultController',
            'reports' => $reports
        ]);
    }
}
