<?php
declare(strict_types=1);

namespace App\Api;

use App\Exception\ErrorOpenWeatherMapApiException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class OpenWeatherMapApi extends AbstractApiRequest
{
    protected $url = 'https://api.openweathermap.org/data/2.5/weather?';

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        parent::__construct($httpClient, $apiKey);
    }

    public function checkWeatherForCityByApi(string $city): array
    {
        try {
            $response = $this->httpClient->request('GET', $this->createUrl($city));
        } catch (TransportExceptionInterface $e) {
            throw new ErrorOpenWeatherMapApiException($e->getMessage());
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
        return (float) $this->checkWeatherForCityByApi($city)['main']['temp'];
    }

    protected function createUrl(string $city): string
    {
        return $this->url . 'q=' . $city . '&appid=' . $this->apiKey . '&units=metric';
    }
}