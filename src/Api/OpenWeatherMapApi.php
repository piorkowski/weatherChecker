<?php
declare(strict_types=1);

namespace App\Api;

use App\Exception\ErrorOpenWeatherMapApiException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class OpenWeatherMapApi extends AbstractApiRequest
{
    protected $url = 'api.openweathermap.org/data/2.5/weather?';

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        parent::__construct($httpClient, $apiKey);
    }

    public function checkWeatherForCityByApi(string $city): string
    {
        try {
            $response = $this->httpClient->request('GET', $this->createUrl($city));
        } catch (TransportExceptionInterface $e) {
            throw new ErrorOpenWeatherMapApiException($e->getMessage());
        }

        return json_decode($response, true);
    }

    private function createUrl(string $city): string
    {
        return $this->url . 'q=' . $city . '&appid=' . $this->apiKey;
    }
}