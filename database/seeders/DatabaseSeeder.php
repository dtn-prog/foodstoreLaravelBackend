<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\Location;
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

            'view cats',
            'create cats',
            'edit cats',
            'delete cats',

            'view orders',
            'edit orders',
            'delete orders',

            'view users',
            'create users',
            'edit users',
            'delete users',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // 'blacklist users'
        ];

        // Create each permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create the admin role
        $role = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'customer']);

        // Create an admin user
        $user = User::firstOrCreate([
            'name' => 'admin',
            'phone' => '0989672531',
            'blacklisted' => false,
        ], [
            'password' => bcrypt('admin'),
        ]);

        // Assign all permissions to the admin role
        $role->givePermissionTo(Permission::all());

        // Assign the role to the user
        $user->assignRole($role);

        Location::create(['lat'=>20.971834, 'long'=>105.7871277]);

        // Create multiple cats
        $cats = ['burger', 'noodle', 'pizza', 'sushi'];

        foreach ($cats as $catName) {
            Cat::firstOrCreate(['name' => $catName]);
        }
    }
}
