<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $modules = [
            'users',
            'roles',
            'stations',
            'fuel_types',
            'fuel_prices',
            'tanks',
            'pumps',
            'shifts',
            'pumpers',
            'sales',
            'settlements',
            'reports'
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        $permissions = [];


        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = [
                    'name' => ucfirst($action) . ' ' . ucfirst($module),
                    'slug' => $module . '.' . $action,
                    'module' => $module,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }


        // Add Special Permissions
        $specialPermissions = [
            [
                'name' => 'View Admin Sidebar',
                'slug' => 'view.admin.sidebar',
                'module' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Access Sales Entry',
                'slug' => 'sales.entry.access',
                'module' => 'sales',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $permissions = array_merge($permissions, $specialPermissions);

        Permission::insert($permissions);
    }
}