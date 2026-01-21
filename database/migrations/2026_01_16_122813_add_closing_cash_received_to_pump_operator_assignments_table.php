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
    Schema::table('pump_operator_assignments', function (Blueprint $table) {
        // Adding the column to store the final cash handover
        $table->decimal('closing_cash_received', 15, 2)->default(0)->after('opening_reading');
    });
}

public function down(): void
{
    Schema::table('pump_operator_assignments', function (Blueprint $table) {
        $table->dropColumn('closing_cash_received');
    });
}
};
