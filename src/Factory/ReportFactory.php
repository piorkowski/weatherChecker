<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Report;
use App\Entity\User;

class ReportFactory implements ReportFactoryInterface
{
    private function createReport(string $city, float $avg_temp, string $ip, User $user = null): Report
    {
        return new Report($city, $avg_temp, $ip, $user);
    }

    public function createAnonymousReport(string $city, float $avg_temp, string $ip): Report
    {
        return $this->createReport($city, $avg_temp, $ip);
    }

    public function createUserReport(string $city, float $avg_temp, string $ip, User $user): Report
    {
        return $this->createReport($city, $avg_temp, $ip, $user);
    }
}