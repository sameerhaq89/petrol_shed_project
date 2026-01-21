<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pump_operator_assignments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('shift_id')->constrained()->onDelete('cascade'); // Links to the main daily shift
        $table->foreignId('user_id')->constrained(); // The Pumper
        $table->foreignId('pump_id')->constrained(); // The Pump they are working on
        
        $table->timestamp('start_time');
        $table->timestamp('end_time')->nullable();
        
        $table->decimal('opening_reading', 15, 2);
        $table->decimal('closing_reading', 15, 2)->nullable();
        
        $table->string('status')->default('active'); // active, completed
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pump_operator_assignments');
    }
};
