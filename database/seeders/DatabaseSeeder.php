<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $Role_Database = Role::where('name', config('permission.default_roles')[0]);
        if ($Role_Database->count() < 1) {
            foreach (config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role,
                ]);
            }
        }
        $Permission_Database = Permission::where('name', config('permission.default_permissions')[0]);
        if ($Role_Database->count() < 1) {
            foreach (config('permission.default_permissions') as $permission) {
                Permission::create([
                    'name' => $permission,
                ]);
            }
        }
    }
}
