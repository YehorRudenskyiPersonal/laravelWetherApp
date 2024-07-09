<?php

namespace App\Repositories;

use App\Models\CityTemperature;
use Illuminate\Support\Collection;

class CityTemperatureRepository implements CityTemperatureRepositoryInterface
{
    public function index(): Collection
    {
        return CityTemperature::all();
    }

    public function getByDateAndCity(string $date, string $city): Collection
    {
        return CityTemperature::whereDate('created_at', $date)
                               ->where('city', $city)
                               ->get();
    }

    public function getByDate(string $date): Collection
    {
        return CityTemperature::whereDate('created_at', $date)
                               ->get();
    }

    public function getByCity(string $city): Collection
    {
        return CityTemperature::where('city', $city)
                               ->get();
    }
}

