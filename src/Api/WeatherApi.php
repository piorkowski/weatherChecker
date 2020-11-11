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

    public function checkWeatherForCityByApi(string $city): ?array
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

        return null;
    }

    public function getTempForCity(string $city): float
    {
        try {
            $response = $this->checkWeatherForCityByApi(transliterator_transliterate('Any-Latin; Latin-ASCII', $city));
        } catch (ErrorWeatherApiException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        return $response['current']['temp_c'];
    }

    protected function createUrl(string $city): string
    {
        return $this->url . 'key=' . $this->apiKey . '&q=' . $city;
    }
}