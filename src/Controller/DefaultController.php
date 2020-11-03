<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\RequestCityWeatherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
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
     * @Route("/{city}", name="checkCityWeather")
     * @param string $city
     * @return Response
     */
    public function checkCityWeather(string $city): Response
    {
        return $this->render('default/city_weather.html.twig', [
            'controller_name' => 'DefaultController',
            'city' => $city
        ]);
    }
}
