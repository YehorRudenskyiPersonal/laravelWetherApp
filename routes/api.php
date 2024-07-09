<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityTemperatureController;
use App\Http\Controllers\CityTemperatureSoapController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.xtoken')->prefix('temperatures')->group(function () {
    Route::get('/info/', [CityTemperatureController::class, 'index']);
});

Route::middleware('auth.xtoken')->prefix('soap')->group(function () {
    Route::get('/temperatures/date/{date}', [CityTemperatureSoapController::class, 'getByDate'])->where('date', '[0-9]{4}-[0-9]{2}-[0-9]{2}');
    Route::get('/temperatures/city/{city}', [CityTemperatureSoapController::class, 'getByCity'])->where('city', '[A-Za-z]+');
    Route::get('/temperatures/info/{date}/{city}', [CityTemperatureSoapController::class, 'getByDateAndCity'])->where([
        'day' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'city' => '[A-Za-z]+'
    ]);
    Route::get('/temperatures/info', [CityTemperatureSoapController::class, 'getFullList']);
});
