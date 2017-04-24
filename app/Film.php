<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'special_features' => 'array',
    ];

    /**
     * Get the language associated with the film.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * A film may have multiple ratings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings() {
        return $this->hasMany(Rating::class);
    }
}
