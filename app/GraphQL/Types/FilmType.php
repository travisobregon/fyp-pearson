<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class FilmType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Film',
        'description' => 'A Film'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the Film'
            ],
            'language' => [
                'type' => GraphQL::type('Language'),
                'description' => 'The language_id of the Film'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the Film'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the Film'
            ],
            'release_year' => [
                'type' => Type::int(),
                'description' => 'The release_year of the Film'
            ],
            'rental_duration' => [
                'type' => Type::int(),
                'description' => 'The rental_duration of the Film'
            ],
            'rental_rate' => [
                'type' => Type::float(),
                'description' => 'The rental_rate of the Film'
            ],
            'length' => [
                'type' => Type::int(),
                'description' => 'The length of the Film'
            ],
            'replacement_cost' => [
                'type' => Type::float(),
                'description' => 'The replacement_cost of the Film'
            ],
            'rating' => [
                'type' => Type::string(),
                'description' => 'The rating of the Film'
            ],
            'stars' => [
                'type' => Type::int(),
                'description' => 'The stars of the Film'
            ],
            'special_features' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The special_features of the Film'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The created_at of the Film'
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The updated_at of the Film'
            ],
        ];
    }

    protected function resolveSpecialFeaturesField($root)
    {
        return json_decode($root->special_features);
    }
}