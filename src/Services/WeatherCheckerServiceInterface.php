<?php
declare(strict_types=1);


namespace App\Services;


interface WeatherCheckerServiceInterface
{
    public function getAvgTempForCity(string $city): float;
}