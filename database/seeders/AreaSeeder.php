<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Area::count() == 0) {
            $data = [
                ['state_id' => 1, 'city_id' => 1, 'name' => 'Goal Chowk', 'pin_code' => '492001'],
                ['state_id' => 1, 'city_id' => 1, 'name' => 'Telibandha', 'pin_code' => '492001'],
                ['state_id' => 1, 'city_id' => 1, 'name' => 'Pandri', 'pin_code' => '492001'],
            ];

            foreach ($data as $area) {
                Area::create($area);
            }
        }
    }
}
