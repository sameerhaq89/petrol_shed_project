<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;

class FixAdminSidebarPermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure the permission exists
        $permissionSlug = 'view.admin.sidebar';
        $permission = Permission::firstOrCreate(
            ['slug' => $permissionSlug],
            ['name' => 'View Admin Sidebar', 'module' => 'system']
        );

        // 2. Find the Station Admin role (slug: admin)
        $role = Role::where('slug', 'admin')->first();

        if ($role) {
            // Check if permission already exists
            if (!$role->permissions->contains('slug', $permissionSlug)) {
                $role->permissions()->attach($permission->id);
                $this->command->info("Permission '{$permissionSlug}' attached to role '{$role->name}'.");
            } else {
                $this->command->info("Role '{$role->name}' already has permission '{$permissionSlug}'.");
            }
        } else {
            $this->command->error("Role with slug 'admin' not found.");
        }
    }
}
