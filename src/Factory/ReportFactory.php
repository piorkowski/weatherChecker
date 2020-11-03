<?php
declare(strict_types=1);

namespace Factory;

use App\Entity\Report;

class ReportFactory
{
    public function createReport(): Report
    {
        return new Report();
    }
}