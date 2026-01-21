<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create the stations table
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('station_code', 50)->unique();
            $table->string('name', 255);
            $table->string('license_number', 100)->unique();
            
            // This assumes the 'users' table already exists
            $table->foreignId('admin_user_id')->nullable()->constrained('users')->onDelete('restrict');

            // Location
            $table->text('address');
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('pincode', 10);
            $table->string('country', 100)->default('India');

            // Contact
            $table->string('phone', 20);
            $table->string('email', 255)->nullable();

            // GPS
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Legal
            $table->string('tax_number', 50);
            $table->string('pan_number', 20)->nullable();

            $table->enum('status', ['active', 'inactive', 'suspended', 'setup'])->default('setup');
            $table->json('settings')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['city', 'state']);
            $table->index('status');
        });

        // 2. Add the foreign key constraint to the users table
        Schema::table('users', function (Blueprint $table) {
            // Assumes 'station_id' column was created in the initial users migration
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Drop the foreign key on users first to avoid constraint violation
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['station_id']);
        });

        // 2. Drop the stations table
        Schema::dropIfExists('stations');
    }
};