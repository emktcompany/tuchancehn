<?php

use Illuminate\Database\Seeder;

class InterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            "Publicidad",
            "Fontanería",
            "Automotríz",
            "Ventas",
        ];

        foreach ($skills as $name) {
            App\TuChance\Models\Interest::firstOrCreate(compact('name'));
        }
    }
}
