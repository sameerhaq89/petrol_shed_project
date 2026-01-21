<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

echo "Checking Permissions...\n\n";

// Check Users
$users = App\Models\User::with('role')->get();

foreach ($users as $user) {
    echo "User: " . $user->name . " (Email: " . $user->email . ", ID: " . $user->id . ")\n";
    $roleName = $user->role ? $user->role->name : 'No Role';
    echo "Role: " . $roleName . " (ID: " . $user->role_id . ")\n";

    try {
        echo "Can view.admin.sidebar? " . ($user->can('view.admin.sidebar') ? 'YES' : 'NO') . "\n";
        echo "Can sales.entry.access? " . ($user->can('sales.entry.access') ? 'YES' : 'NO') . "\n";
    } catch (\Exception $e) {
        echo "Error checking permissions: " . $e->getMessage() . "\n";
    }

    try {
        echo "Has Permission (method): " . ($user->hasPermission('view.admin.sidebar') ? 'YES' : 'NO') . "\n";
    } catch (\Exception $e) {
        echo "Error checking hasPermission method: " . $e->getMessage() . "\n";
    }

    echo "--------------------------------------------------\n";
}

// Check Roles
echo "\nChecking Role Definitions:\n";
try {
    $roles = \App\Models\Role::with('permissions')->get();
    foreach ($roles as $role) {
        echo "Role: " . $role->name . " (ID: $role->id)\n";
        echo "Permissions: " . $role->permissions->pluck('name', 'slug')->map(function ($name, $slug) {
            return "$name ($slug)";
        })->implode(', ') . "\n";
        echo "--------------------------------------------------\n";
    }
} catch (\Exception $e) {
    echo "Error checking roles: " . $e->getMessage() . "\n";
}
