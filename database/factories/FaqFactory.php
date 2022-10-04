<?php

use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Faq::class, function (Faker $faker) {
    return [
        'question' => "¿{$faker->name}?",
        'answer' => $faker->text,
        'type' => $faker->boolean,
        'is_active' => $faker->boolean,
    ];
});
