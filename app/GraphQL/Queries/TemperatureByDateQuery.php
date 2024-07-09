<?php

namespace App\GraphQL\Queries;

use App\Models\CityTemperature;
use GraphQL\Type\Definition\Type;
use Nuwave\Lighthouse\Support\Facades\GraphQL;

class TemperatureByDateQuery
{
    public function __invoke($rootValue, array $args): array
    {
        $temperatureData = CityTemperature::whereDate('created_at', $args['date'])->get()->toArray();
        
        if ($temperatureData) {
            $result = [];
            foreach($temperatureData as $cityData) {
                $result[] = [
                    'id' => $cityData['id'],
                    'city' => $cityData['city'],
                    'temperature' => $cityData['temperature'],
                    'full_data' => json_encode($cityData['full_data']),
                    'created_at' => $cityData['created_at']
                ];
            }
            return $result;
        }
        return [];
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('CityTemperature'));
    }

    public function args(): array
    {
        return [
            'date' => ['name' => 'date', 'type' => Type::nonNull(Type::string())],
        ];
    }
}
