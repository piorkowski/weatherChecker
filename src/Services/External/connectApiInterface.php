<?php
declare(strict_types=1);

namespace App\Services\External;

interface connectApiInterface
{
    public function getResponse(string $url): string;
}