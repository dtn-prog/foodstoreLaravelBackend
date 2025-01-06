<?php

namespace Database\Seeders;

use App\Models\User;
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
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',

            'view orders',
            'edit orders',
            'delete orders',

            'manage users',
            'blacklist users'
        ];

        // Create each permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create the admin role
        $role = Role::firstOrCreate(['name' => 'admin']);
        Role::create(['name'=>'customer']);

        // Create an admin user
        $user = User::firstOrCreate([
            'name' => 'admin',
            'phone' => '0989672531',
            'blacklisted' => false,
        ], [
            'password' => bcrypt('admin'),
        ]);

        // Assign the role to the user
        $user->assignRole($role);
    }
}
