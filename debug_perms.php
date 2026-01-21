<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$roles = Role::all(['id', 'name', 'slug']);
echo "Roles:\n";
foreach ($roles as $r) {
    echo "ID: {$r->id}, Name: {$r->name}, Slug: {$r->slug}\n";
    $perms = $r->permissions->pluck('slug')->toArray();
    echo "Permissions: " . implode(', ', $perms) . "\n\n";
}

$user = User::where('name', 'Pumper Anil')->first();
if ($user) {
    echo "User: {$user->name}, Role ID: {$user->role_id}\n";
    if ($user->role) {
        echo "Role: {$user->role->name}\n";
        echo "Has sales.entry.access? " . ($user->can('sales.entry.access') ? 'YES' : 'NO') . "\n";
    } else {
        echo "No Role Assigned\n";
    }
} else {
    echo "User 'Pumper Anil' not found.\n";
}
