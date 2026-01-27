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
        Schema::create('station_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('addon_id')->constrained('addons')->onDelete('cascade');
            $table->boolean('is_enabled')->default(true);
            $table->timestamp('enabled_at')->nullable();
            $table->timestamps();
            
            $table->unique(['station_id', 'addon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station_addons');
    }
};
