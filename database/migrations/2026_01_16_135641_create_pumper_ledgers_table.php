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
    Schema::create('pumper_ledgers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // The Pumper
        $table->foreignId('assignment_id')->nullable()->constrained('pump_operator_assignments');
        $table->enum('type', ['shortage', 'payment']); // Debt vs Settlement
        $table->decimal('amount', 15, 2);
        $table->decimal('running_balance', 15, 2); // Total owed after this entry
        $table->string('remarks')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pumper_ledgers');
    }
};
