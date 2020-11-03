<?php
declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

class ErrorOpenWeatherMapApiException extends \Exception implements RequestExceptionInterface
{
}