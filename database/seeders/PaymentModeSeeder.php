<?php

namespace Database\Seeders;

use App\Models\PaymentMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(PaymentMode::count() == 0){
            $paymentModes = [
                ['name' => 'Cash'],
                ['name' => 'Online'],
                ['name' => 'UPI'],
                ['name' => 'Bank Transfer'],
                ['name' => 'Cheque'],
            ];

            foreach ($paymentModes as $row) {
                PaymentMode::create($row);
            }
        }
    }
}
