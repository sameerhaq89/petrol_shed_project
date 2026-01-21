<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // Operator
            $table->string('shift_number', 50);
            $table->date('shift_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();

            // Cash Reconciliation
            $table->decimal('opening_cash', 10, 2)->default(0);
            $table->decimal('closing_cash', 10, 2)->nullable();
            $table->decimal('expected_cash', 10, 2)->nullable();
            $table->decimal('cash_variance', 10, 2)->nullable();

            // Sales Aggregates
            $table->decimal('cash_sales', 10, 2)->default(0);
            $table->decimal('card_sales', 10, 2)->default(0);
            $table->decimal('upi_sales', 10, 2)->default(0);
            $table->decimal('credit_sales', 10, 2)->default(0);
            $table->decimal('total_sales', 10, 2)->default(0);

            $table->decimal('total_fuel_sold', 10, 2)->default(0);
            $table->integer('total_transactions')->default(0);

            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->text('opening_notes')->nullable();
            $table->text('closing_notes')->nullable();

            $table->foreignId('closed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->unique(['station_id', 'shift_number']);
            $table->unique(['station_id', 'shift_date', 'start_time']); // Prevent duplicate starts
            $table->index(['station_id', 'user_id', 'shift_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
