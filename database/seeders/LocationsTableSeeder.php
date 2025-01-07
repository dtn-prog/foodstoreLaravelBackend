<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            ['lat' => 20.971834, 'long' => 105.7871277],
            ['lat' => 21.0285, 'long' => 105.8041], // Another example location
            // Add more locations as needed
        ];

        foreach ($locations as $location) {

        }
    }
}
