<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            // 'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'phone'=>'0989672531',
            'role'=>'admin',
            'lat'=>'1',
            'long'=>'1'
        ]);
    }
}
