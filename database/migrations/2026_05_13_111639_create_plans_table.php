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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade'); 
            $table->string('name', 100);
            $table->string('duration');  //monthly, weakly
            $table->decimal('price', 8,2);
            $table->tinyInteger('total_days');
            $table->string('meal_time'); //breakfast, lunch, dinner
            $table->string('description');
            $table->boolean('is_active')->default(true)->comment('1 = active, 0 = inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
