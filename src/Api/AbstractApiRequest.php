<?php
declare(strict_types=1);

namespace App\Api;

use App\Exception\ErrorOpenWeatherMapApiException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractApiRequest implements ApiRequestInterface
{
    protected $apiKey;
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }
}