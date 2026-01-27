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
            'stock_movements',
            'subscription_plans',
            'addons',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        $this->call([

            PermissionSeeder::class,
            SalesEntryPermissionSeeder::class, 
            RoleSeeder::class,
            UserSeeder::class,

                
            StationSeeder::class,
            SubscriptionPlanSeeder::class,
            AddonSeeder::class,
            FuelTypeSeeder::class,
            FuelPriceSeeder::class,
            TankSeeder::class,
            PumpSeeder::class,

               
            ShiftSeeder::class,
            SaleSeeder::class,
            CashDropSeeder::class,

              
            RolePermissionSeeder::class,
        ]);

       
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "All Seeders Completed Successfully!\n";
    }
}