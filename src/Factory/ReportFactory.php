<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Report;

class ReportFactory
{
    public function createReport(string $city, float $avg_temp, string $ip): Report
    {
        return new Report($city, $avg_temp, $ip);
    }

    public function createForCheckCityWeather()
    {

    }
}