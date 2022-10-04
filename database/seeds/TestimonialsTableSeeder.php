<?php

use Illuminate\Database\Seeder;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TuChance\Models\Testimonial::class, 20)->create();
    }
}
