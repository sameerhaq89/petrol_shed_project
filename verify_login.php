<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Station;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

echo "--- Login Verification ---\n";

$email = 'admin@purple.com';
$password = 'password';

echo "Attempting login for: $email\n";

if (Auth::attempt(['email' => $email, 'password' => $password])) {
    echo "[SUCCESS] Authentication successful.\n";
    $user = Auth::user();
    echo "User ID: " . $user->id . "\n";
    echo "User Name: " . $user->name . "\n";
    echo "Station ID: " . ($user->station_id ?? 'N/A') . "\n";
} else {
    echo "[FAILURE] Authentication failed.\n";

    $user = User::where('email', $email)->first();
    if ($user) {
        echo "User exists in database. Password mismatch.\n";
    } else {
        echo "User does NOT exist in database.\n";
    }
}

echo "\n--- System Integrity Check ---\n";
try {
    $userCount = User::count();
    $stationCount = Station::count();
    echo "Users in DB: $userCount\n";
    echo "Stations in DB: $stationCount\n";
} catch (\Exception $e) {
    echo "[ERROR] Database connection or query failed: " . $e->getMessage() . "\n";
}
