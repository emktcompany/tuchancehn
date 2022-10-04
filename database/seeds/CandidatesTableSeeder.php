<?php

use Illuminate\Database\Seeder;

class CandidatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TuChance\Models\Candidate::class, 20)->create([
            'user_id' => function ($candidate) {
                $user = factory(App\TuChance\Models\User::class)
                    ->create([
                        'country_id' => $candidate['country_id'],
                        'state_id' => $candidate['state_id'],
                        'city_id' => $candidate['city_id'],
                    ])
                    ->assignRole('candidate');

                return $user->id;
            }
        ]);
    }
}
