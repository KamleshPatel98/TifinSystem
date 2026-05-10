<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('owner_aadhar_card_front_photo', 30);
            $table->string('owner_aadhar_card_back_photo', 30);
            $table->string('owner_pan_card_photo', 30)->nullable();
            $table->string('bussiness_name');
            $table->string('logo')->nullable();
            $table->char('phone_number', 10);
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete();
            $table->char('pincode', 6);
            $table->string('address');
            $table->string('latitude', 40)->nullable();
            $table->string('longitude', 40)->nullable();
            $table->enum('approved_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('resignation_request_status', ['pending', 'approved', 'rejected'])->nullable();
            $table->string('resgination_request_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
