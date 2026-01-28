<?php

use App\Models\User;
use App\Models\Station;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Verifying Seeder Results...\n\n";

// 1. Check Stations
$stations = Station::all();
echo "Stations Found: " . $stations->count() . "\n";
foreach ($stations as $station) {
    echo "- ID: {$station->id}, Name: {$station->name}\n";
}
echo "\n";

// 2. Check Users and their Stations
$users = User::with('stations')->get();
foreach ($users as $user) {
    if ($user->role_id == 1) continue; // Skip Super Admin

    echo "User: {$user->name} (Role: {$user->role_id})\n";
    echo "  Active Station ID: " . ($user->station_id ?? 'NULL') . "\n";
    echo "  Assigned Stations (Pivot): " . $user->stations->count() . "\n";
    foreach ($user->stations as $s) {
        echo "    - {$s->name} (ID: {$s->id})\n";
    }
    echo "\n";
}
