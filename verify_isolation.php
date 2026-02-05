<?php

use App\Models\FuelType;
use App\Models\Station;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Verifying Fuel Type Isolation...\n";

    // Unguard to allow mass assignment for test
    Model::unguard();

    // 1. Check if station_id column exists
    if (!Schema::hasColumn('fuel_types', 'station_id')) {
        throw new Exception("station_id column missing in fuel_types table.");
    }
    echo "Column 'station_id' exists.\n";

    // 2. Create two test stations
    echo "Creating Test Stations...\n";
    $rnd = rand(10000, 99999);
    $station1 = Station::create([
        'name' => 'Test Station 1',
        'station_code' => 'S1-' . $rnd,
        'license_number' => 'LIC1-' . $rnd,
        'address' => 'Addr 1',
        'city' => 'City 1',
        'state' => 'State 1',
        'pincode' => '123456',
        'phone' => '111',
        'email' => 'test1@test.com',
        'tax_number' => 'TAX1'
    ]);

    $station2 = Station::create([
        'name' => 'Test Station 2',
        'station_code' => 'S2-' . $rnd,
        'license_number' => 'LIC2-' . $rnd,
        'address' => 'Addr 2',
        'city' => 'City 2',
        'state' => 'State 2',
        'pincode' => '123456',
        'phone' => '222',
        'email' => 'test2@test.com',
        'tax_number' => 'TAX2'
    ]);

    $station1Id = $station1->id;
    $station2Id = $station2->id;
    echo "Created Stations: $station1Id, $station2Id\n";

    // Cleanup first (just in case)
    FuelType::whereIn('station_id', [$station1Id, $station2Id])->forceDelete();

    // 3. Create Fuel Type for Station 1
    echo "Creating Fuel Type for Station 1 ($station1Id)...\n";
    FuelType::create([ // Code is S1F
        'name' => 'Station1 Fuel',
        'code' => 'S1F',
        'unit' => 'L',
        'station_id' => $station1Id
    ]);

    // 4. Create Fuel Type for Station 2
    echo "Creating Fuel Type for Station 2 ($station2Id)...\n";
    FuelType::create([ // Code is S2F 
        'name' => 'Station2 Fuel',
        'code' => 'S2F',
        'unit' => 'L',
        'station_id' => $station2Id
    ]);

    // 5. Query for Station 1
    $s1Types = FuelType::where('station_id', $station1Id)->get();
    echo "Station 1 Fuel Types: " . $s1Types->count() . " (Expected 1)\n";
    if ($s1Types->count() !== 1 || $s1Types->first()->code !== 'S1F') {
        echo "FAILED: Station 1 sees wrong types: " . $s1Types->pluck('code')->implode(', ') . "\n";
    } else {
        echo "SUCCESS: Station 1 sees only its fuel types.\n";
    }

    // 6. Query for Station 2
    $s2Types = FuelType::where('station_id', $station2Id)->get();
    echo "Station 2 Fuel Types: " . $s2Types->count() . " (Expected 1)\n";
    if ($s2Types->count() !== 1 || $s2Types->first()->code !== 'S2F') {
        echo "FAILED: Station 2 sees wrong types: " . $s2Types->pluck('code')->implode(', ') . "\n";
    } else {
        echo "SUCCESS: Station 2 sees only its fuel types.\n";
    }

    // 7. Test Unique Constraint
    echo "Testing Unique Constraint within Station 1...\n";
    try {
        FuelType::create([
            'name' => 'Duplicate',
            'code' => 'S1F',
            'unit' => 'L',
            'station_id' => $station1Id
        ]);
        echo "FAILED: Duplicate code allowed for same station!\n";
    } catch (\Illuminate\Database\QueryException $e) {
        echo "SUCCESS: Duplicate code prevented for same station.\n";
    }

    // 8. Test Same Code Different Station
    echo "Testing Same Code on Different Station...\n";
    try {
        FuelType::create([
            'name' => 'Same Code S2',
            'code' => 'S1F', // Same code as Station 1
            'unit' => 'L',
            'station_id' => $station2Id
        ]);
        echo "SUCCESS: Same code allowed for different station.\n";
    } catch (\Illuminate\Database\QueryException $e) {
        echo "FAILED: Same code prevented for different station! " . $e->getMessage() . "\n";
    }

    // Cleanup
    FuelType::whereIn('station_id', [$station1Id, $station2Id])->forceDelete();
    $station1->delete();
    $station2->delete();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    // echo $e->getTraceAsString();
    exit(1);
}
