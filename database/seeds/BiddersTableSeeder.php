<?php

use Illuminate\Database\Seeder;

class BiddersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TuChance\Models\Bidder::class, 20)->create([
            'user_id' => function ($bidder) {
                $user = factory(App\TuChance\Models\User::class)
                    ->create([
                        'country_id' => $bidder['country_id'],
                        'state_id' => $bidder['state_id'],
                        'city_id' => $bidder['city_id'],
                    ])
                    ->assignRole('bidder');

                return $user->id;
            }
        ]);
    }
}
