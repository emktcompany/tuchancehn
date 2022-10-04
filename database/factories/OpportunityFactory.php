<?php

use App\TuChance\Models\Bidder;
use App\TuChance\Models\City;
use App\TuChance\Models\Country;
use App\TuChance\Models\State;
use Faker\Generator as Faker;

$factory
    ->define(App\TuChance\Models\Opportunity::class, function (Faker $faker) {
        $name = $faker->text(50);
        $date = \Carbon\Carbon::now()->subDays(rand(1, 30));
        $date_finish = $date->copy()->addDays(rand(1, 60));

        $country_id = Country::inRandomOrder()
            ->pluck('id')
            ->first();
        $state_id = State::where('country_id', $country_id)
            ->inRandomOrder()
            ->pluck('id')
            ->first();
        $city_id = City::where('state_id', $state_id)
            ->inRandomOrder()
            ->pluck('id')
            ->first();
        $bidder_id = Bidder::inRandomOrder()
            ->pluck('id')
            ->first();

        return [
            'name'            => $name,
            'slug'            => str_slug($name),
            'summary'         => $faker->text(),
            'description'     => $faker->text(),
            'requirements'    => $faker->text(),
            'characteristics' => $faker->text(),
            'country_id'      => $country_id,
            'state_id'        => $state_id,
            'city_id'         => $city_id,
            'bidder_id'       => $bidder_id,
            'category_id'     => $faker->numberBetween(1, 10),
            'begin_at'        => $date,
            'finish_at'       => $date_finish,
            'is_active'       => $faker->boolean,
            'allow_apply'     => $faker->boolean
        ];
    });
