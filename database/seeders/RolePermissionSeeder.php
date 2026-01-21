<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Fetch Roles
        $stationAdminRole = Role::where('slug', 'admin')->first();
        $pumperRole = Role::where('slug', 'pumper')->first();
        $managerRole = Role::where('slug', 'manager')->first();
        // Super admin generally handles permissions via Gate logic, but can be explicit if needed.

        // 2. Fetch Permissions related to Station Admin
        // Typically they get everything except critical system stuff? 
        // Based on previous verification, they had a LOT of permissions.
        // For now, let's assign ALL permissions to Station Admin (except maybe super admin specific ones?)
        // Or better yet, replicate the original logic if we knew it. 
        // Since we don't have the original logic handy, we'll assign ALL permissions to Station Admin 
        // to ensure they don't lose access.

        $allPermissions = Permission::all();

        if ($stationAdminRole) {
            $stationAdminRole->permissions()->sync($allPermissions->pluck('id'));
            $this->command->info("Assigned all permissions to Station Admin.");
        }

        // 3. Pumper Permissions
        // They need sales.entry.access and maybe sales.create/update?
        // Let's verify what they had: creates sales, update sales.
        if ($pumperRole) {
            $pumperPermissions = Permission::whereIn('slug', [
                'sales.create',
                'sales.update',
                'sales.entry.access'
            ])->get();

            $pumperRole->permissions()->sync($pumperPermissions->pluck('id'));
            $this->command->info("Assigned specific sales permissions to Pumper.");
        }

        // 4. Manager permissions (Optional, just preserving state if needed)
        // Managers usually have some subset. Leaving empty/as-is for now unless we know better.
    }
}
