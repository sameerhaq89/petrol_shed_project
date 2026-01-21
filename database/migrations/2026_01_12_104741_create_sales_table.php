<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('shift_id'); 
            $table->unsignedBigInteger('pump_id');
            $table->foreignId('fuel_type_id')->constrained();
            $table->unsignedBigInteger('customer_id')->nullable();
            
            // Sale Details
            $table->string('sale_number')->unique();
            $table->dateTime('sale_datetime'); // <--- ADDED THIS LINE
            
            $table->decimal('start_reading', 15, 2)->default(0);
            $table->decimal('end_reading', 15, 2)->default(0);
            $table->decimal('quantity', 10, 2);
            $table->decimal('rate', 10, 2);
            $table->decimal('amount', 12, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 12, 2)->default(0);
            
            // Payment & Customer Info
            $table->string('payment_mode')->default('cash'); 
            $table->string('transaction_reference')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->integer('odometer_reading')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            
            // Status & Audit
            $table->string('status')->default('completed');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            
            // Void / Refund Fields
            $table->boolean('is_voided')->default(false);
            $table->unsignedBigInteger('voided_by')->nullable();
            $table->timestamp('voided_at')->nullable();
            $table->text('void_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};