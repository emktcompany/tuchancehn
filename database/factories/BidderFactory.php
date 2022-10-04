<?php

use App\TuChance\Models\City;
use App\TuChance\Models\Country;
use App\TuChance\Models\State;
use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Bidder::class, function (Faker $faker) {
    $company = $faker->company;

    return [
        'name'        => $company,
        'slug'        => str_slug($company),
        'phone'       => $faker->phoneNumber,
        'cell_phone'  => $faker->phoneNumber,
        'web'         => $faker->url,
        'is_active'   => $faker->boolean,
        'services'    => $faker->text(),
        'summary'     => $faker->text(),
        'description' => $faker->text(),
        'country_id'  => Country::inRandomOrder()->pluck('id')->first(),
        'state_id'    => State::inRandomOrder()->pluck('id')->first(),
        'city_id'     => City::inRandomOrder()->pluck('id')->first(),
    ];
});
