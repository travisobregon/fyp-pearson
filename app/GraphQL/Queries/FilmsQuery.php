<?php

namespace App\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Film;

class FilmsQuery extends Query
{
    protected $attributes = [
        'name' => 'films'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Film'));
    }

    public function args()
    {
        return [
            'page' => [
                'name' => 'page',
                'type' => Type::nonNull(Type::int())
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Film::with('language')->orderBy('title', 'asc')->simplePaginate(20, ['*'], 'page', $args['page']);
    }
}