<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Report;
use App\Entity\User;
use Doctrine\ORM\Query;

interface ReportServiceInterface
{
    public function createReport(string $city, float $avg_temp, string $ip, ?User $user = null): Report;

    public function getUserReports(User $user): array;

    public function getAllReports(): array;
}