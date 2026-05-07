<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        if (State::count() == 0) {
            $data = [
                ['name' => 'Chhattisgarh', 'code' => 'CG'],
                ['name' => 'Maharashtra', 'code' => 'MH'],
            ];

            foreach ($data as $state) {
                State::create($state);
            }
        }
    }
}
