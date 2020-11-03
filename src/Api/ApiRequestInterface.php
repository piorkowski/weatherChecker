<?php
declare(strict_types=1);


namespace App\Api;


interface ApiRequestInterface
{
    public function checkWeatherForCityByApi(string $city);

    public function getTempForCity(string $city): float;
}