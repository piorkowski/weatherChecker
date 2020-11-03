<?php
declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

class ErrorWeatherApiException extends \Exception implements RequestExceptionInterface
{
}