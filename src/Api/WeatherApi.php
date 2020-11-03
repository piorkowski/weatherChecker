<?php
declare(strict_types=1);

namespace App\Api;

use App\Exception\ErrorOpenWeatherMapApiException;
use App\Exception\ErrorWeatherApiException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class WeatherApi extends AbstractApiRequest
{
    protected $url = 'https://api.weatherapi.com/v1/current.json?';

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        parent::__construct($httpClient, $apiKey);
    }

    public function checkWeatherForCityByApi(string $city): string
    {
        try {
            $response = $this->httpClient->request('GET', $this->createUrl($city));
        } catch (TransportExceptionInterface $e) {
            throw new ErrorWeatherApiException($e->getMessage());
        }

        return json_decode($response, true);
    }



    private function createUrlRequest(string $city): string
    {

    }
}