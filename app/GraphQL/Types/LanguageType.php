<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class LanguageType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Language',
        'description' => 'A Language'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the Language'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the Language'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The created_at of the Language'
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The updated_at of the Language'
            ],
        ];
    }
}