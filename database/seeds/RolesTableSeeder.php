<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRole('admin');
        $this->createRole('bidder');
        $this->createRole('candidate');
    }

    /**
     * Create a role if it doesn't exist
     * @param  string $name
     * @param  array  $permissions
     * @param  string $guard
     * @return void
     */
    public function createRole($name, array $permissions = [], $guard = 'api')
    {
        try {
            $this->command
                ->call('permission:create-role', compact('name', 'guard'));
        } catch (RoleAlreadyExists $e) {
            $this->command->info($e->getMessage());
        }

        Role::findByName($name)->syncPermissions($permissions);
    }
}
