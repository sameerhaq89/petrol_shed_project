<?php

use App\Models\User;
use App\Models\Station;
use App\Models\Role;
use App\Services\RoleService;
use App\Services\UserService;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Verifying UserController::create Logic...\n";

    // Mock Deps
    $roleService = app(RoleService::class);
    $userService = app(UserService::class);
    $controller = new UserController($userService, $roleService);

    // Setup: Create Station and Admin User
    \Illuminate\Database\Eloquent\Model::unguard();
    // Cleanup first
    User::where('email', 'admin@test.com')->forceDelete();
    Station::where('station_code', 'S-TEST')->forceDelete();

    $station = Station::create([
        'name' => 'Test Station',
        'station_code' => 'S-TEST',
        'license_number' => 'LIC',
        'address' => 'Addr',
        'city' => 'City',
        'state' => 'State',
        'pincode' => '123',
        'phone' => '123',
        'tax_number' => 'TAX'
    ]);

    // Assume Role 2 is Station Admin (or any non-1 role)
    $role = Role::firstOrCreate(['slug' => 'manager'], ['name' => 'Manager', 'priority' => 2]);

    $user = User::create([
        'name' => 'Test Admin',
        'email' => 'admin@test.com',
        'password' => 'pass',
        'station_id' => $station->id,
        'role_id' => $role->id,
        'phone' => '123'
    ]);

    // Login
    Auth::login($user);

    // Call create to check scoping
    $viewCreate = $controller->create();
    $dataCreate = $viewCreate->getData();

    echo "Create View Data Check:\n";
    $stations = $dataCreate['stations'];
    echo "Stations Count: " . $stations->count() . "\n";
    if ($stations->count() == 1 && $stations->first()->id == $station->id) {
        echo "SUCCESS: Stations scoped correctly.\n";
    } else {
        echo "FAILED: Stations not scoped correctly.\n";
    }

    // Call index to check permission
    // Mock user permission to view users (required for index middleware)
    // Actually we skipped middleware in test but controller logic sets pageHeader
    $viewIndex = $controller->index();
    $dataIndex = $viewIndex->getData();
    $pageHeader = $dataIndex['pageHeader'];

    echo "Index Page Header Permission: " . ($pageHeader['link']['can'] ?? 'N/A') . "\n";
    if (($pageHeader['link']['can'] ?? '') == 'users.create') {
        echo "SUCCESS: Permission slug is 'users.create'.\n";
    } else {
        echo "FAILED: Permission slug is '" . ($pageHeader['link']['can'] ?? 'NULL') . "'.\n";
    }

    // Cleanup
    $user->delete();
    $station->delete();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
