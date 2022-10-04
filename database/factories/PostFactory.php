<?php

use Faker\Generator as Faker;

$factory->define(App\TuChance\Models\Post::class, function (Faker $faker) {
    $company = $faker->company;

    return [
        'name'      => $company,
        'slug'      => str_slug($company),
        'summary'   => str_limit($faker->text(), 175, ''),
        'content'   => $faker->text(),
        'is_active' => $faker->boolean,
        'user_id'   => App\TuChance\Models\User::inRandomOrder()
            ->role('admin')
            ->pluck('id')
            ->first(),
    ];
});
