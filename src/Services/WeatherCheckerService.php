<?php
declare(strict_types=1);


namespace App\Services;


use App\Api\OpenWeatherMapApi;
use App\Api\WeatherApi;

class WeatherCheckerService implements WeatherCheckerServiceInterface
{
    private $openWeatherMapApi;
    private $weatherApi;

    public function __construct(OpenWeatherMapApi $openWeatherMapApi, WeatherApi $weatherApi)
    {
        $this->openWeatherMapApi = $openWeatherMapApi;
        $this->weatherApi = $weatherApi;
    }

    public function getAvgTempForCity(string $city): float
    {
        $tempFromWeatherApi = $this->weatherApi->getTempForCity($city);
        $tempFromOpenWeatherMapApi = $this->openWeatherMapApi->getTempForCity($city);

        return (float) ($tempFromOpenWeatherMapApi + $tempFromWeatherApi) / 2;
    }


}