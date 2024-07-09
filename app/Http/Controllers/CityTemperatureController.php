<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CityTemperatureService;

class CityTemperatureController extends Controller
{
    public function __construct(
        protected CityTemperatureService $temperatureService
    ){}

    public function index(Request $request)
    {
        $request->validate([
            'day' => 'sometimes|date_format:Y-m-d',
            'city' => 'sometimes|string'
        ]);

        $day = $request->get('day');
        $city = $request->get('city');

        try {
            if ($day && $city) {
                $temperatures = $this->temperatureService->getTemperaturesByDateAndCity($day, $city);
            } elseif ($day) {
                $temperatures = $this->temperatureService->getTemperaturesByDate($day);
            } elseif ($city) {
                $temperatures = $this->temperatureService->getTemperaturesByCity($city);
            } else {
                $temperatures = $this->temperatureService->getFullList();
            }
    
            return response()->json($temperatures);
        }catch(Exception $e) {
            return response()->json(['error' => 'Caught exception: ',  $e->getMessage(), "\n"], 400);
        }
    }
}
