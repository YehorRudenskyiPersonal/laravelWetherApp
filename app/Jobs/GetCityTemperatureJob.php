<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\CityTemperature;

class GetCityTemperatureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function handle()
    {
        $apiKey = env('OPENWEATHERMAP_API_KEY');
        $city = env('CITY');

        try {
            Log::info('GetCityTemperatureJob starting...');
            $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);
            Log::info('GetCityTemperatureJob checking for response...');
            if ($response->successful()) {
                $data = $response->json();
                $temperature = $data['main']['temp'];

                CityTemperature::create([
                    'city' => $city,
                    'temperature' => $temperature,
                    'full_data' => $data,
                ]);

                Log::info("Temperature fetched successfully for {$city} at " . now());
            } else {
                Log::error("Failed to fetch temperature for {$city}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Error fetching temperature for {$city}: " . $e->getMessage());
        }
    }
}

