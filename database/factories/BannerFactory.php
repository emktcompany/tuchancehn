<?php

use App\TuChance\Models\Country;
use App\TuChance\Models\User;
use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Banner::class, function (Faker $faker) {
    return [
        'name'       => $faker->name,
        'link'       => $faker->url,
        'is_active'  => $faker->boolean,
    ];
});
