<?php

use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Interest::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
