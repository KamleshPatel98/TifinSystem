<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Plan::count() == 0){
            $plans = [
                [
                    'user_id'     => 2,
                    'name'        => 'Monthly Breakfast Plan',
                    'duration'    => 'monthly',
                    'price'       => 1999.00,
                    'total_days'  => 30,
                    'meal_time'   => 'breakfast',
                    'description' => 'Healthy breakfast meals for 30 days.',
                    'is_active'   => true,
                ],
                [
                    'user_id'     => 2,
                    'name'        => 'Weekly Lunch Plan',
                    'duration'    => 'weekly',
                    'price'       => 700.00,
                    'total_days'  => 7,
                    'meal_time'   => 'lunch',
                    'description' => 'Delicious lunch meals for 7 days.',
                    'is_active'   => true,
                ],
                [
                    'user_id'     => 2,
                    'name'        => 'Monthly Dinner Plan',
                    'duration'    => 'monthly',
                    'price'       => 1500.00,
                    'total_days'  => 30,
                    'meal_time'   => 'dinner',
                    'description' => 'Nutritious dinner meals for 30 days.',
                    'is_active'   => true,
                ],
                [
                    'user_id'     => 2,
                    'name'        => 'Monthly Lunch, Dinner Meal Plan',
                    'duration'    => 'weekly',
                    'price'       => 2800.00,
                    'total_days'  => 30,
                    'meal_time'   => 'lunch,dinner',
                    'description' => 'Complete meal package for one week.',
                    'is_active'   => true,
                ],
            ];

            foreach ($plans as $plan) {
                Plan::create($plan);
            }
        }
    }
}
