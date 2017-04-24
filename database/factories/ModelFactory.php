<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'address_id' => function () {
            return factory('App\Address')->create()->id;
        },
        'store_id' => null,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'is_staff' => $faker->boolean(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Country::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->country,
    ];
});

$factory->define(App\City::class, function (Faker\Generator $faker) {
    return [
        'country_id' => function () {
            return factory('App\Country')->create()->id;
        },
        'name' => $faker->city,
    ];
});

$factory->define(App\Address::class, function (Faker\Generator $faker) {
    return [
        'city_id' => function () {
            return factory('App\City')->create()->id;
        },
        'name' => $faker->streetAddress,
        'district' => $faker->word,
        'postal_code' => $faker->postcode,
        'phone' => $faker->phoneNumber,
    ];
});

$factory->define(App\Store::class, function (Faker\Generator $faker) {
    return [
        'address_id' => function () {
            return factory('App\Address')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
    ];
});

$factory->define(App\Language::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->languageCode,
    ];
});

$factory->define(App\Film::class, function (Faker\Generator $faker) {
    return [
        'language_id' => function () {
            return factory('App\Language')->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'release_year' => $faker->year,
        'rental_duration' => $faker->numberBetween(3, 7),
        'rental_rate' => $faker->randomFloat(2, 0.99, 4.99),
        'length' => $faker->numberBetween(46, 185),
        'replacement_cost' => $faker->randomFloat(2, 9.99, 29.99),
        'rating' => $faker->randomElement(['G','PG','PG-13','R','NC-17']),
        'stars' => $faker->numberBetween(1, 5),
        'special_features' => collect(
            $faker->randomElements(['Trailer', 'Behind the Scenes', 'Deleted Scenes', 'Commentaries'], 2)
        )->toJson(),
    ];
});

$factory->define(App\Suggestion::class, function (Faker\Generator $faker) {
    factory('App\Film', 3)->create();

    $film = \App\Film::first();
    $films = collect([[$film->id => $faker->numberBetween(1, 5)]])->toJson();

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'films' => $films,
    ];
});
