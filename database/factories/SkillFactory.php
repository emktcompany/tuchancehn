<?php

use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Skill::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
