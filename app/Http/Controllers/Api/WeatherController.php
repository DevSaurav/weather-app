<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends BaseController
{
    public function current(WeatherService $weatherService): JsonResponse
    {
        $data = $weatherService->getWeather();

        if (!$data) {
            return $this->error('Failed to fetch weather data', 503);
        }

        return $this->success($data, 'Weather data retrieved');
    }
}
