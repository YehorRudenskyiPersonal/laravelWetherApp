<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Nuwave\Lighthouse\Support\Contracts\GraphQLType;
use Nuwave\Lighthouse\Support\Facades\GraphQL;

class CityTemperatureType implements GraphQLType
{
    public function name(): string
    {
        return 'CityTemperature';
    }

    public function description(): ?string
    {
        return 'A type representing city temperature';
    }

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the temperature record',
            ],
            'city' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The city name',
            ],
            'temperature' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The temperature value',
            ],
            'full_data' => [
                'type' => Type::string(),
                'description' => 'Full data JSON',
                // Define resolve function if needed
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The timestamp when the temperature record was created',
            ],
        ];
    }
}

