<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (City::count() == 0) {
            $data = [
                ['state_id' => 1, 'name' => 'Raipur'],
                ['state_id' => 1, 'name' => 'Bhilai'],
                ['state_id' => 2, 'name' => 'Mumbai'],
                ['state_id' => 2, 'name' => 'Pune'],
            ];

            foreach ($data as $city) {
                City::create($city);
            }
        }
    }
}
