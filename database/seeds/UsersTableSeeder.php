<?php

use App\TuChance\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrNew([
            'email' => 'gerardo@iw.sv',
        ]);

        $user->name       = 'Gerardo Gómez';
        $user->is_active  = 1;
        $user->country_id = 2;
        $user->state_id   = 10;
        $user->city_id    = 179;
        $user->password   = bcrypt('secret');

        if ($user->isDirty()) {
            $user->save();
        }

        $user->syncRoles(['admin']);
    }
}
