<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shift_variances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            $table->enum('variance_type', ['cash', 'fuel']);
            $table->foreignId('tank_id')->nullable()->constrained('tanks')->onDelete('cascade');

            // Cash Variance
            $table->decimal('expected_amount', 12, 2)->nullable();
            $table->decimal('actual_amount', 12, 2)->nullable();

            // Fuel Variance
            $table->decimal('opening_dip', 12, 2)->nullable();
            $table->decimal('closing_dip', 12, 2)->nullable();
            $table->decimal('purchases', 12, 2)->nullable();
            $table->decimal('physical_movement', 12, 2)->nullable();
            $table->decimal('meter_sales', 12, 2)->nullable();

            // Common
            $table->decimal('variance_amount', 12, 2);
            $table->decimal('variance_percentage', 8, 2);
            $table->enum('status', ['perfect', 'acceptable', 'review', 'critical']);
            $table->text('explanation')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_variances');
    }
};
