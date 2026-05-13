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
                    'password' => Hash::make('password1@'),
                    'role' => 'superadmin',
                    'status' => 'active',
                ],
                [
                    'name' => 'vendor',
                    'mobile' => '1234567892',
                    'email' => 'vendor@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'vendor',
                    'status' => 'active',
                ],
                [
                    'name' => 'delivery boy',
                    'mobile' => '1234567893',
                    'email' => 'delivery_boy@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'delivery_boy',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer',
                    'mobile' => '1234567894',
                    'email' => 'customer@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 1',
                    'mobile' => '1234567881',
                    'email' => 'customer1@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 2',
                    'mobile' => '1234567882',
                    'email' => 'customer2@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 3',
                    'mobile' => '1234567883',
                    'email' => 'customer3@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 4',
                    'mobile' => '1234567884',
                    'email' => 'customer4@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 5',
                    'mobile' => '1234567885',
                    'email' => 'customer5@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 6',
                    'mobile' => '1234567886',
                    'email' => 'customer6@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 7',
                    'mobile' => '1234567887',
                    'email' => 'customer7@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 8',
                    'mobile' => '1234567888',
                    'email' => 'customer8@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 9',
                    'mobile' => '1234567889',
                    'email' => 'customer9@gmail.com',
                    'password' => Hash::make('password1@'),
                    'role' => 'customer',
                    'status' => 'active',
                ],
                [
                    'name' => 'customer 10',
                    'mobile' => '1234567800',
                    'email' => 'customer10@gmail.com',
                    'password' => Hash::make('password1@'),
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
