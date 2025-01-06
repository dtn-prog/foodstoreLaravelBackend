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
        ];

        Permission::create(['name'=>$permissions]);

        Role::create(['name'=>'admin']);

        $user = User::create([
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'phone'=>'0989672531',
        ]);

        $user->assignRole('admin');

    }
}
