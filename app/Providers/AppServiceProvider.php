<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\GetCityTemperatureJob;
use Illuminate\Support\Facades\Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CityTemperatureService::class, function ($app) {
            return new CityTemperatureService();
        });

        $this->app->bind(
            \App\Repositories\CityTemperatureRepositoryInterface::class,
            \App\Repositories\CityTemperatureRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
