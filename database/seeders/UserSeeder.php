<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            $data = [
                [
                    'name' => 'Admin',
                    'mobile' => '1234567891',
                    'email' => 'superadmin@gmail.com',
                    'password' => Hash::make('passsword1@'),
                    'role' => 'superadmin',
                    'status' => 'active',
                ],
                [
                    'name' => 'vendor',
                    'mobile' => '1234567892',
                    'email' => 'vendor@gmail.com',
                    'password' => Hash::make('passsword1@'),
                    'role' => 'vendor',
                    'status' => 'active',
                ],
                [
                    'name' => 'delivery boy',
                    'mobile' => '1234567893',
                    'email' => 'delivery_boy@gmail.com',
                    'password' => Hash::make('passsword1@'),
                    'role' => 'delivery_boy',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer',
                    'mobile' => '1234567894',
                    'email' => 'customer@gmail.com',
                    'password' => Hash::make('passsword1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
            ];
            foreach ($data as $value) {
                User::create($value);
            }
        }
    }
}
