<?php

namespace App\Http\Controllers;

use App\Services\CityTemperatureService;
use SoapBox\Formatter\Formatter;

class CityTemperatureSoapController extends Controller
{
    public function __construct(
        protected CityTemperatureService $temperatureService
    ){}

    public function getFullList() 
    {
        $temperatures = $this->temperatureService->getFullList();
        return $this->toXmlResponse($temperatures);
    }

    public function getByDate(string $date)
    {
        $temperatures = $this->temperatureService->getTemperaturesByDate($date);
        return $this->toXmlResponse($temperatures);
    }

    public function getByCity(string $city)
    {
        $temperatures = $this->temperatureService->getTemperaturesByCity($city);
        return $this->toXmlResponse($temperatures);
    }

    public function getByDateAndCity(string $date, string $city)
    {
        $temperatures = $this->temperatureService->getTemperaturesByDateAndCity($date, $city);
        return $this->toXmlResponse($temperatures);
    }

    private function toXmlResponse($temperatures)
    {
        $data = $temperatures->map(function($temp) {
            return [
                'city' => $temp->city,
                'temperature' => $temp->temperature,
                'full_data' => $temp->full_data,
                'created_at' => $temp->created_at->toDateTimeString(),
            ];
        });

        $formatter = Formatter::make($data->toArray(), Formatter::ARR);
        $xml = $formatter->toXml();

        return response($xml, 200, ['Content-Type' => 'text/xml']);
    }
}
