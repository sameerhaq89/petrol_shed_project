<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class SalesEntryPermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Define new permissions
        $permissions = [
            [
                'name' => 'Access Sales Entry',
                'slug' => 'sales.entry.access',
                'module' => 'sales',
                'description' => 'Allows access to the Pumper Sales Entry screen'
            ],
            [
                'name' => 'View Admin Sidebar',
                'slug' => 'view.admin.sidebar',
                'module' => 'admin',
                'description' => 'Allows viewing the main admin sidebar menu'
            ]
        ];

        // 2. Create them if they don't exist
        foreach ($permissions as $p) {
            Permission::firstOrCreate(
                ['slug' => $p['slug']],
                $p
            );
        }

        // 3. Assign 'sales.entry.access' to Pumper and Admin
        $pumperRole = Role::where('name', 'Pumper')
            ->orWhere('slug', 'pumper')
            ->first();

        $adminRole = Role::where('slug', 'admin')->first();
        // Assuming 'admin' slug exists. If not, might need to check 'super-admin' or id 1.

        $salesPermission = Permission::where('slug', 'sales.entry.access')->first();
        $adminSidebarPermission = Permission::where('slug', 'view.admin.sidebar')->first();

        if ($pumperRole && $salesPermission) {
            if (!$pumperRole->permissions->contains($salesPermission->id)) {
                $pumperRole->permissions()->attach($salesPermission->id);
            }
        }

        if ($adminRole && $salesPermission) {
            if (!$adminRole->permissions->contains($salesPermission->id)) {
                $adminRole->permissions()->attach($salesPermission->id);
            }
        }

        // 4. Assign 'view.admin.sidebar' to Admin (and others usually) but NOT Pumper
        if ($adminRole && $adminSidebarPermission) {
            if (!$adminRole->permissions->contains($adminSidebarPermission->id)) {
                $adminRole->permissions()->attach($adminSidebarPermission->id);
            }
        }

        // Ensure Pumper does NOT have admin sidebar access (preventative)
        if ($pumperRole && $adminSidebarPermission) {
            $pumperRole->permissions()->detach($adminSidebarPermission->id);
        }
    }
}
