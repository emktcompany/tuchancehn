<?php

use App\TuChance\Models\City;
use App\TuChance\Models\Country;
use App\TuChance\Models\State;
use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Candidate::class, function (Faker $faker) {
    return [
        'birth'                   => $faker->date(),
        'native_language'         => $faker->sentence(),
        'others_language'         => $faker->sentence(),
        'phone'                   => $faker->phoneNumber,
        'cell_phone'              => $faker->phoneNumber,
        'years_experience'        => $faker->randomNumber(),
        'professional_objective'  => $faker->text(),
        'professional_area'       => $faker->text(),
        'professional_experience' => $faker->text(),
        'training_education'      => $faker->text(),
        'summary'                 => $faker->text(),
        'references'              => $faker->text(),
        'subscription'            => $faker->boolean,
        'interests'               => $faker->text(),
        'gender'                  => $faker->boolean,
        'privacy'                 => $faker->boolean,
        'country_id'              => Country::inRandomOrder()->pluck('id')->first(),
        'state_id'                => State::inRandomOrder()->pluck('id')->first(),
        'city_id'                 => City::inRandomOrder()->pluck('id')->first(),
    ];
});
