<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pumps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('tank_id')->constrained('tanks')->onDelete('restrict');
            $table->string('pump_number', 50);
            $table->string('pump_name', 255)->nullable();
            $table->string('nozzle_number', 50)->nullable();
            $table->string('island_number', 20)->nullable();
            $table->decimal('opening_reading', 12, 2)->default(0);
            $table->decimal('current_reading', 12, 2)->default(0);
            $table->date('installation_date')->nullable();
            $table->date('last_calibration_date')->nullable();
            $table->date('next_calibration_date')->nullable();
            $table->integer('calibration_frequency_days')->default(180);
            $table->string('manufacturer', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->decimal('capacity_per_minute', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance', 'faulty', 'calibration'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['station_id', 'pump_number']);
            $table->index(['station_id', 'tank_id', 'status']);
            $table->index('next_calibration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pumps');
    }
};
