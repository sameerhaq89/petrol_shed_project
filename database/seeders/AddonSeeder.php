<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Addon;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addons = [
            [
                'name' => 'Tank Management',
                'slug' => 'tank-management',
                'description' => 'Manage fuel tanks, monitor levels, and track dip readings.',
                'icon' => 'fas fa-database',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Settlement',
                'slug' => 'settlement',
                'description' => 'Daily settlement tracking and reconciliation.',
                'icon' => 'fas fa-calculator',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Settlement List',
                'slug' => 'settlement-list',
                'description' => 'View and manage historical settlements.',
                'icon' => 'fas fa-list-alt',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Pump Management',
                'slug' => 'pump-management',
                'description' => 'Manage pumps, track performance, and monitor readings.',
                'icon' => 'fas fa-gas-pump',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Pumper Management',
                'slug' => 'pumper-management',
                'description' => 'Manage pumper staff, shifts, and performance.',
                'icon' => 'fas fa-user-tie',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Dip Management',
                'slug' => 'dip-management',
                'description' => 'Record and track tank dip readings.',
                'icon' => 'fas fa-ruler-vertical',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Fuel Management',
                'slug' => 'fuel-management',
                'description' => 'Manage fuel types, prices, and inventory.',
                'icon' => 'fas fa-oil-can',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Inventory System',
                'slug' => 'inventory',
                'description' => 'Advanced inventory tracking and management.',
                'icon' => 'fas fa-boxes',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Advanced Reports',
                'slug' => 'reports',
                'description' => 'Comprehensive reporting and analytics.',
                'icon' => 'fas fa-chart-bar',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Price Visibility',
                'slug' => 'price-visibility',
                'description' => 'Show/hide prices based on permissions.',
                'icon' => 'fas fa-dollar-sign',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Bulk Upload',
                'slug' => 'bulk-upload',
                'description' => 'Import data in bulk via CSV/Excel.',
                'icon' => 'fas fa-upload',
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'name' => 'Customer Management',
                'slug' => 'customer-management',
                'description' => 'Manage customer accounts and credit.',
                'icon' => 'fas fa-users',
                'sort_order' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Sales Entry',
                'slug' => 'sales-entry',
                'description' => 'Enable sales entry for pumpers and staff.',
                'icon' => 'fas fa-gas-station',
                'sort_order' => 13,
                'is_active' => true,
            ],
        ];

        foreach ($addons as $addon) {
            Addon::updateOrCreate(
                ['slug' => $addon['slug']],
                $addon
            );
        }

        $this->command->info('Addons seeded successfully!');
    }
}
