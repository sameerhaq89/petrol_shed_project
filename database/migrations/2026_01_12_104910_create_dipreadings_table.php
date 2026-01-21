<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dip_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('tank_id')->constrained('tanks')->onDelete('cascade');
            $table->date('reading_date');

            $table->decimal('dip_level_cm', 10, 2);
            $table->decimal('volume_liters', 12, 2);
            $table->decimal('temperature', 5, 2)->nullable();

            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dip_readings');
    }
};
