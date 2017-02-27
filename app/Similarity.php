<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Similarity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'other_users',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'other_users' => 'array',
    ];
}
