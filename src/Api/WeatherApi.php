<?php
declare(strict_types=1);

namespace App\Api;

use App\Exception\ErrorOpenWeatherMapApiException;
use App\Exception\ErrorWeatherApiException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class WeatherApi extends AbstractApiRequest
{
    protected $url = 'https://api.weatherapi.com/v1/current.json?';

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        parent::__construct($httpClient, $apiKey);
    }

    public function checkWeatherForCityByApi(string $city)
    {
        try {
            $response = $this->httpClient->request('GET', $this->createUrl($city));
        } catch (TransportExceptionInterface $e) {
            throw new ErrorWeatherApiException($e->getMessage());
        }

        try {
            return $response->toArray();
        } catch (ClientExceptionInterface $e) {
        } catch (DecodingExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }
    }

    public function getTempForCity(string $city): float
    {
        return (float) $this->checkWeatherForCityByApi($city)['current']['temp_c'];
    }

    protected function createUrl(string $city): string
    {
        return $this->url . 'key=' . $this->apiKey . '&q=' . $city;
    }
}