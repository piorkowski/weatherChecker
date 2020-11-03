<?php
declare(strict_types=1);


namespace App\Services\External;


class OpenWeatherMapApi
{
    const BASE_URL = 'api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}';
}