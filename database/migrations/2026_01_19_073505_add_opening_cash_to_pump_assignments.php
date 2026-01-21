<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pump_operator_assignments', function (Blueprint $table) {
            // This adds the column without deleting old data
            $table->decimal('opening_cash', 15, 2)->default(0.00)->after('opening_reading');
        });
    }

    public function down()
    {
        Schema::table('pump_operator_assignments', function (Blueprint $table) {
            $table->dropColumn('opening_cash');
        });
    }
};