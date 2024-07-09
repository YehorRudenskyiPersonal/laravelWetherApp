<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CityTemperature;

class GetCityTemperature extends Command
{
    protected $signature = 'get:temperature {--city= : The city name to fetch temperature for}';
    protected $description = 'Fetches and stores the temperature for the specified city (defaults to env value if not provided).';

    public function handle()
    {
        $apiKey = env('OPENWEATHERMAP_API_KEY');
        $city = $this->option('city') ?: env('CITY');

        if (!$city) {
            $this->error('City name not provided or set in .env file.');
            return;
        }

        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $temperature = $data['main']['temp'];

            CityTemperature::create([
                'city' => $city,
                'temperature' => $temperature,
                'full_data' => $data,
            ]);

            $this->info('Temperature fetched and stored successfully for ' . $city);
        } else {
            $this->error('Failed to fetch temperature for ' . $city);
        }
    }
}
