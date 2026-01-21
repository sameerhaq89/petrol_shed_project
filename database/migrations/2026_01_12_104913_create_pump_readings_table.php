<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pump_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            $table->foreignId('pump_id')->constrained('pumps')->onDelete('restrict');

            $table->decimal('opening_reading', 12, 2);
            $table->decimal('closing_reading', 12, 2)->nullable();

            $table->decimal('total_volume', 10, 2)->nullable();
            $table->decimal('current_price', 10, 2); // Price at time of shift
            $table->decimal('total_amount', 10, 2)->nullable();

            $table->decimal('test_volume', 10, 2)->default(0); // For calibration/testing deduction
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['shift_id', 'pump_id']); // One reading per pump per shift
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pump_readings');
    }
};
