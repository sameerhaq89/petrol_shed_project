<?php

use App\Models\FuelType;
use App\Models\User;
use App\Models\Station;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Verifying Validation Rules...\n";

    // Unguard
    \Illuminate\Database\Eloquent\Model::unguard();

    // Cleanup past runs
    Station::whereIn('station_code', ['S1-VAL', 'S2-VAL'])->forceDelete();

    $station1 = Station::create(['name' => 'S1', 'station_code' => 'S1-VAL', 'license_number' => 'L1-VAL', 'tax_number' => 'T1', 'address' => 'A1', 'city' => 'C1', 'state' => 'St1', 'pincode' => '111111', 'phone' => '111']);
    $station2 = Station::create(['name' => 'S2', 'station_code' => 'S2-VAL', 'license_number' => 'L2-VAL', 'tax_number' => 'T2', 'address' => 'A2', 'city' => 'C2', 'state' => 'St2', 'pincode' => '222222', 'phone' => '222']);

    // Create mock role if needed or assign valid role_id
    // Assuming role_id 1 is valid or using factory
    // Create mock role
    $role = \App\Models\Role::firstOrCreate(
        ['slug' => 'test-role'],
        ['name' => 'TestRole', 'priority' => 1]
    );
    $roleId = $role->id;

    // Assuming role_id 1 is valid or using factory
    $user1 = User::create(['name' => 'User1', 'email' => 'u1@val.com', 'password' => 'pass', 'station_id' => $station1->id, 'role_id' => $roleId, 'phone' => '111222333']);
    $user2 = User::create(['name' => 'User2', 'email' => 'u2@val.com', 'password' => 'pass', 'station_id' => $station2->id, 'role_id' => $roleId, 'phone' => '444555666']);

    // Create existing fuel type in Station 1
    FuelType::create(['name' => 'Petrol', 'code' => 'P92', 'unit' => 'L', 'station_id' => $station1->id]);

    // Test 1: User 1 tries to create "P92" again (Should FAIL)
    echo "\nTest 1: User 1 creating duplicate 'P92'...\n";
    Auth::login($user1);
    $data = ['code' => 'P92'];
    $rules = [
        'code' => [
            Rule::unique('fuel_types')
                ->where('station_id', auth()->user()->station_id)
                ->whereNull('deleted_at')
        ]
    ];
    $validator = Validator::make($data, $rules);
    if ($validator->fails()) {
        echo "SUCCESS: Validation failed as expected.\n";
    } else {
        echo "FAILED: Validation passed but should have failed!\n";
    }

    // Test 2: User 2 tries to create "P92" (Should PASS)
    echo "\nTest 2: User 2 creating 'P92' (duplicate code, different station)...\n";
    Auth::login($user2);

    // Rebuild rules to capture new user's station_id
    $rules2 = [
        'code' => [
            Rule::unique('fuel_types')
                ->where('station_id', auth()->user()->station_id)
                ->whereNull('deleted_at')
        ]
    ];

    $validator = Validator::make($data, $rules2);
    if (!$validator->fails()) {
        echo "SUCCESS: Validation passed as expected.\n";
    } else {
        echo "FAILED: Validation failed: " . implode(', ', $validator->errors()->all()) . "\n";
    }

    // Cleanup
    FuelType::whereIn('station_id', [$station1->id, $station2->id])->forceDelete();
    $user1->delete();
    $user2->delete();
    $station1->delete();
    $station2->delete();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
