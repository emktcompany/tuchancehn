<?php

use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TestimonialsTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(InterestsTableSeeder::class);
        $this->call(CandidatesTableSeeder::class);
        $this->call(BiddersTableSeeder::class);
        $this->call(OpportunitiesTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(PartnersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(TestimonialsTableSeeder::class);
    }
}
