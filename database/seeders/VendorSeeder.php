<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Vendor::count() == 0){
            Vendor::create([
                'user_id'                         => 2,
                'owner_aadhar_card_front_photo'  => 'aadhar_front.jpg',
                'owner_aadhar_card_back_photo'   => 'aadhar_back.jpg',
                'owner_pan_card_photo'           => 'pan_card.jpg',
                'bussiness_name'                 => 'Patel Tiffin Services',
                'logo'                           => 'vendor_logo.png',
                'phone_number'                   => '9876543210',
                'state_id'                       => 1,
                'city_id'                        => 1,
                'area_id'                        => 1,
                'pincode'                        => '492001',
                'address'                        => 'Tikrapara Main Road, Raipur',
                'latitude'                       => '21.2514',
                'longitude'                      => '81.6296',
                'approved_status'                => 'approved',
                'resignation_request_status'     => null,
                'resgination_request_reason'     => null,
            ]);
        }
    }
}
