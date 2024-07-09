<?php

namespace App\GraphQL\Queries;

use App\Models\CityTemperature;
use GraphQL\Type\Definition\Type;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Facades\GraphQL;

class TemperatureByCityQuery
{
    public function __invoke($rootValue, array $args, GraphQLContext $context): array
    {
        $temperatureData = CityTemperature::where('city', $args['city'])->get()->toArray();

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
            'city' => ['name' => 'city', 'type' => Type::nonNull(Type::string())],
        ];
    }
}

