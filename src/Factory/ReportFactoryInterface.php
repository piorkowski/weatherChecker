<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Report;
use App\Entity\User;

interface ReportFactoryInterface
{
    public function createAnonymousReport(string $city, float $avg_temp, string $ip): Report;

    public function createUserReport(string $city, float $avg_temp, string $ip, User $user): Report;
}