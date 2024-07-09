<?php

namespace App\Services;

use App\Repositories\CityTemperatureRepository;
use Illuminate\Support\Facades\Cache;

class CityTemperatureService
{

    public function __construct(
        protected CityTemperatureRepository $temperatureRepository
    ){}

    public function getFullList()
    {
        $cacheKey = "temperatures";
        return Cache::remember($cacheKey, 3600, function () {
            return $this->temperatureRepository->index();
        });
    }

    public function getTemperaturesByDateAndCity(string $date, string $city)
    {
        $cacheKey = "temperatures.{$city}.{$date}";

        return Cache::remember($cacheKey, 3600, function () use ($date, $city) {
            return $this->temperatureRepository->getByDateAndCity($date, $city);
        });
    }

    public function getTemperaturesByDate(string $date)
    {
        $cacheKey = "temperatures.{$date}";

        return Cache::remember($cacheKey, 3600, function () use ($date) {
            return $this->temperatureRepository->getByDate($date);
        });
    }

    public function getTemperaturesByCity(string $city)
    {
        $cacheKey = "temperatures.{$city}";

        return Cache::remember($cacheKey, 3600, function () use ($city) {
            return $this->temperatureRepository->getByCity($city);
        });
    }
}

