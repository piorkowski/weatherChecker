<?php
declare(strict_types=1);

namespace App\Services;

class AbstractWeatherChecker implements WeatherCheckerInterface
{
    public function checkWeatherForCity(string $city): float
    {
        return 16.00;
    }

    public function getTemp(): float
    {
        // TODO: Implement getTemp() method.
    }

    public function connect(string $url)
    {
        // TODO: Implement connect() method.
    }

}