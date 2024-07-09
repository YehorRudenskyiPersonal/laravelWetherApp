<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface CityTemperatureRepositoryInterface
{
    public function index(): Collection;

    public function getByDateAndCity(string $date, string $city): Collection;

    public function getByDate(string $date): Collection;

    public function getByCity(string $city): Collection;
}
