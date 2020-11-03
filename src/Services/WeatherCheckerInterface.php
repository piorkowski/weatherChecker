<?php
declare(strict_types=1);

namespace App\Services;


interface WeatherCheckerInterface
{
    public function checkWeatherForCity(string $city): float;

    public function getTemp(): float;

    public function connect(string $url);
}