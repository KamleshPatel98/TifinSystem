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
                ['state_id' => 1, 'name' => 'Raipur', 'pin_code' => '492001'],
                ['state_id' => 1, 'name' => 'Bhilai', 'pin_code' => '490001'],
                ['state_id' => 2, 'name' => 'Mumbai', 'pin_code' => '400001'],
                ['state_id' => 2, 'name' => 'Pune', 'pin_code' => '411001'],
            ];

            foreach ($data as $city) {
                City::create($city);
            }
        }
    }
}
