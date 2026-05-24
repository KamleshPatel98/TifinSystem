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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade'); // users table
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            // $table->foreignId('delivery_boy_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('customer_address_id')->constrained('customer_addresses')->OnDelete('cascade');
            $table->decimal('price', 8,2);
            $table->decimal('offer_price', 8,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('paymwnt_status', ['pending', 'paid', 'partial']);
            $table->boolean('is_active')->default(true)->comment('1 = active, 0 = inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
