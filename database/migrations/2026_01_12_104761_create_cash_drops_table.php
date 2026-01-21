<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_drops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // The pumper/staff
            $table->decimal('amount', 10, 2);
            $table->timestamp('dropped_at');
            $table->foreignId('received_by')->nullable()->constrained('users'); // Manager
            $table->enum('status', ['pending', 'verified'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_drops');
    }
};
