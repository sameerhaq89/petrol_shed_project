<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;

class FixPumperSalesPermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure the permission exists
        $permissionSlug = 'sales.entry.access';
        $permission = Permission::firstOrCreate(
            ['slug' => $permissionSlug],
            ['name' => 'Access Sales Entry', 'module' => 'sales']
        );

        // 2. Find the Pumper role (slug: pumper)
        $role = Role::where('slug', 'pumper')->first();

        if ($role) {
            // Check if permission already exists
            if (!$role->permissions->contains('slug', $permissionSlug)) {
                $role->permissions()->attach($permission->id);
                $this->command->info("Permission '{$permissionSlug}' attached to role '{$role->name}'.");
            } else {
                $this->command->info("Role '{$role->name}' already has permission '{$permissionSlug}'.");
            }
        } else {
            $this->command->error("Role with slug 'pumper' not found.");
        }
    }
}
