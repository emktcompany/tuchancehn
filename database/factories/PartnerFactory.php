<?php

use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Partner::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'link'      => $faker->url,
        'is_active' => $faker->boolean,
        'type'      => $faker->boolean,
    ];
});
