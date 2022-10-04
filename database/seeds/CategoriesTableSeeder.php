<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->import('categories');
    }
}
