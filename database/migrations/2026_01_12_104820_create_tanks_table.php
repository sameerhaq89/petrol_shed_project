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
        Schema::create('tanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('fuel_type_id')->constrained('fuel_types')->onDelete('restrict');
            $table->string('tank_number', 50);
            $table->string('tank_name', 255);
            $table->decimal('capacity', 10, 2);
            $table->decimal('current_stock', 10, 2)->default(0);
            $table->decimal('reorder_level', 10, 2);
            $table->decimal('minimum_level', 10, 2);
            $table->decimal('maximum_level', 10, 2);
            $table->date('installation_date')->nullable();
            $table->date('last_cleaned_date')->nullable();
            $table->string('manufacturer', 100)->nullable();
            $table->enum('tank_type', ['underground', 'aboveground', 'mobile'])->default('underground');
            $table->string('material', 50)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'maintenance', 'cleaning', 'inactive', 'faulty'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['station_id', 'tank_number']);
            $table->index(['station_id', 'fuel_type_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanks');
    }
};
