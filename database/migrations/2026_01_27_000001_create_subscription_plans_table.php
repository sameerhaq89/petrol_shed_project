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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Free Trial, Basic, Standard, Premium
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration_days')->default(30); // 7 for trial, 30 for others
            $table->integer('max_addons')->default(0); // 0=trial, 1=basic, 3=standard, -1=premium(unlimited)
            $table->boolean('is_trial')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable(); // Additional features list
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
