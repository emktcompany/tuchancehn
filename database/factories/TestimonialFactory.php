<?php

use App\TuChance\Models\Country;
use Faker\Generator as Faker;

$factory
    ->define(App\TuChance\Models\Testimonial::class, function (Faker $faker) {
        return [
            'name'       => implode(' ', [
                "{$faker->name},", $faker->jobTitle, 'at', $faker->company,
            ]),
            'body'       => $faker->text(),
            'is_active'  => $faker->boolean,
        ];
    });
