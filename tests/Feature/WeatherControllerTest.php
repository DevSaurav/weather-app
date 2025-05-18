<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_mocked_weather_data(): void
    {
        $user = User::factory()->create();

        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'main' => ['temp' => 25],
                'weather' => [['description' => 'clear sky']],
                'name' => 'Perth'
            ], 200)
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/weather');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Weather data retrieved',
                'data' => [
                    'main' => ['temp' => 25],
                    'weather' => [['description' => 'clear sky']],
                    'name' => 'Perth'
                ]
            ]);
    }

    #[Test]
    public function it_handles_failed_weather_api_call(): void
    {
        $user = User::factory()->create();

        Http::fake([
            'api.openweathermap.org/*' => Http::response(null, 500)
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/weather');

        $response->assertStatus(503)
            ->assertJson([
                'success' => false,
                'message' => 'Failed to fetch weather data'
            ]);
    }
}

