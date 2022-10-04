<?php

use App\TuChance\Models\City;
use App\TuChance\Models\Country;
use App\TuChance\Models\State;
use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\User::class, function (Faker $faker) {
    static $password;

    if (!isset($password)) {
        $password = bcrypt('secret');
    }

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'is_active'      => $faker->boolean,
        'password'       => $password, // secret
        'remember_token' => str_random(10),
        'country_id'     => Country::inRandomOrder()->pluck('id')->first(),
        'state_id'       => State::inRandomOrder()->pluck('id')->first(),
        'city_id'        => City::inRandomOrder()->pluck('id')->first(),
    ];
});
