<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. DISABLE CHECKS (Start)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Clean Database
        $tables = [
            'permissions',
            'role_permissions',
            'roles',
            'users',
            'stations',
            'fuel_types',
            'fuel_prices',
            'tanks',
            'pumps',
            'shifts',
            'pump_operator_assignments',
            'sales',
            'cash_drops',
            'pump_readings',
            'stock_movements'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // 3. Run Seeders (While checks are still OFF)
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StationSeeder::class,

            FuelTypeSeeder::class,
            FuelPriceSeeder::class,
            TankSeeder::class,
            PumpSeeder::class,
            ShiftSeeder::class,
            SaleSeeder::class,
                // CashDropSeeder::class, // Optional/Test data
            RolePermissionSeeder::class, // <--- Added Centralized Assignments
        ]);

        // 4. RE-ENABLE CHECKS (End)
        // Only turn them back on AFTER all data is inserted
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "All Seeders Completed Successfully!\n";
    }
}