<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected string $city = 'Perth,AU';

    public function getWeather(): array|null
    {
        return Cache::remember('weather_data', now()->addMinutes(15), function () {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $this->city,
                'appid' => env('WEATHER_API_KEY'),
            ]);

            return $response->ok() ? $response->json() : null;
        });
    }

    public function refreshWeather(): array|null
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $this->city,
            'appid' => env('WEATHER_API_KEY'),
        ]);

        if ($response->ok()) {
            $data = $response->json();
            Cache::put('weather_data', $data, now()->addMinutes(15));
            return $data;
        }

        return null;
    }
}