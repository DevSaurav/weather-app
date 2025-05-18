<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

/**
 * A class to get the weather data
 */
class WeatherController extends BaseController
{
    /**
     * Function to return the current weather
     *
     * @param object, App/Services/WeatherService
     * @return string, success / error
     */
    public function current(WeatherService $weatherService): JsonResponse
    {
        /**
         * @var int weather data
         */
        $data = $weatherService->getWeather();

        if (!$data) {
            return $this->error('Failed to fetch weather data', 503);
        }

        return $this->success($data, 'Weather data retrieved');
    }
}
