<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('tank_id')->constrained('tanks')->onDelete('cascade');
            $table->foreignId('fuel_type_id')->constrained('fuel_types');

            $table->string('supplier_name');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date');

            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 12, 2);

            $table->enum('status', ['pending', 'received', 'cancelled'])->default('pending');
            $table->timestamp('received_at')->nullable();

            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
