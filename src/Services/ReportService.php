<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Report;
use App\Entity\User;
use App\Factory\ReportFactoryInterface;
use App\Repository\ReportRepository;

class ReportService implements ReportServiceInterface
{
    private $reportFactory;
    private $reportRepository;

    public function __construct(
        ReportFactoryInterface $reportFactory,
        ReportRepository $reportRepository
    )
    {
        $this->reportFactory = $reportFactory;
        $this->reportRepository = $reportRepository;
    }

    public function createReport(string $city, float $avg_temp, string $ip, User $user = null): Report
    {
        if ($user === null) {
            $report = $this->reportFactory->createAnonymousReport($city, $avg_temp, $ip);
        } else {
            $report = $this->reportFactory->createUserReport($city, $avg_temp, $ip, $user);
        }

        $this->reportRepository->save($report);

        return $report;
    }

    public function getUserReports(User $user): array
    {
        return $this->reportRepository->findBy(['createdBy' => $user], ['createdAt' => 'ASC']);
    }

    public function getAllReports(): array
    {
        return $this->reportRepository->findAll();
    }


}