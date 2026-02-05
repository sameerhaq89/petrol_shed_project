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
        Schema::table('fuel_types', function (Blueprint $table) {
            $table->foreignId('station_id')->nullable()->after('id')->constrained('stations')->onDelete('cascade');
            $table->dropUnique('fuel_types_code_unique'); // Drop the global unique on code
            $table->unique(['station_id', 'code']); // Scope uniqueness to station
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_types', function (Blueprint $table) {
            $table->dropForeign(['station_id']);
            $table->dropUnique(['station_id', 'code']);
            $table->dropColumn('station_id');
            $table->unique('code'); // Restore global unique
        });
    }
};
