<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Station;
use App\Models\Shift;
use App\Models\Tank;
use App\Models\Pump;
use App\Models\Sale;
use App\Models\FuelType;
use App\Services\CashDropService;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

function logStep($step, $message)
{
    echo "\n[" . strtoupper($step) . "] $message\n";
    echo str_repeat('-', 50) . "\n";
}

function logSuccess($message)
{
    echo "  ✅ SUCCESS: $message\n";
}

function logError($message, $exception = null)
{
    echo "  ❌ ERROR: $message\n";
    if ($exception) {
        echo "     Details: " . $exception->getMessage() . "\n";
    }
    // Don't exit, try to continue
}

/* ==========================================================================
   1. AUTHENTICATION & MASTER DATA
   ========================================================================== */
logStep("SETUP", "Checking Master Data & Auth");

// User
$user = User::first();
if (!$user) {
    $user = User::factory()->create();
    logSuccess("Created new test user: {$user->email}");
} else {
    logSuccess("Using existing user: {$user->email} (ID: {$user->id})");
}

Auth::login($user);
if (Auth::check()) {
    logSuccess("User logged in successfully.");
} else {
    logError("Failed to login.");
    exit(1);
}

// Station
$station = Station::first();
if (!$station) {
    $station = Station::create(['name' => 'Main Station', 'location' => 'City Center']);
    logSuccess("Created new station: {$station->name}");
} else {
    logSuccess("Using existing station: {$station->name} (ID: {$station->id})");
}

// Fuel Type
$fuelType = FuelType::first();
if (!$fuelType) {
    // Assuming FuelType has name
    // Check model structure if fails, but usually name/code
    try {
        $fuelType = FuelType::create(['name' => 'Petrol', 'code' => 'P95', 'price' => 350.00]);
        logSuccess("Created Fuel Type: {$fuelType->name}");
    } catch (\Exception $e) {
        // Fallback if model differs, search by ID 1
        $fuelType = new FuelType();
        $fuelType->id = 1;
        $fuelType->name = 'Test Fuel';
        logError("Could not create FuelType, assuming ID 1 exists for testing.");
    }
} else {
    logSuccess("Using Fuel Type: {$fuelType->name}");
}

// Tank
$tank = Tank::where('station_id', $station->id)->first();
if (!$tank) {
    $tank = Tank::create([
        'station_id' => $station->id,
        'fuel_type_id' => $fuelType->id ?? 1,
        'capacity' => 10000,
        'current_level' => 5000,
        'name' => 'Tank 1'
    ]);
    logSuccess("Created Tank: {$tank->name}");
} else {
    logSuccess("Using Tank: {$tank->name}");
}

// Pump
$pump = Pump::where('station_id', $station->id)->first();
if (!$pump) {
    $pump = Pump::create([
        'station_id' => $station->id,
        'pump_number' => 1,
        'pump_name' => 'Pump 01',
        'tank_id' => $tank->id,
        'fuel_type_id' => $fuelType->id ?? 1,
        'current_reading' => 10000,
        'status' => 'active'
    ]);
    logSuccess("Created Pump: {$pump->pump_name}");
} else {
    logSuccess("Using Pump: {$pump->pump_name}");
}

/* ==========================================================================
   2. SHIFT OPERATIONS
   ========================================================================== */
logStep("SHIFT", "Managing Shifts");

// Close any open shifts to start fresh
$openShifts = Shift::where('status', 'open')->get();
foreach ($openShifts as $os) {
    $os->update(['status' => 'closed', 'end_time' => now(), 'closed_at' => now()]);
    logSuccess("Closed execution of previous open shift ID: {$os->id}");
}

// Open new Shift
try {
    $shift = Shift::create([
        'station_id' => $station->id,
        'user_id' => $user->id,
        'shift_number' => rand(1000, 9999),
        'shift_date' => now()->toDateString(),
        'start_time' => now(),
        'status' => 'open',
        'opening_cash' => 5000.00,
        'opening_notes' => 'Automated Test Shift'
    ]);
    logSuccess("Opened new shift ID: {$shift->id}");
} catch (\Exception $e) {
    logError("Failed to open shift", $e);
    exit(1);
}

/* ==========================================================================
   3. OPERATIONS (Sales & Cash Drops)
   ========================================================================== */
logStep("OPERATIONS", "Recording Sales and Drops");

// 3.1 Record a Sale
try {
    $sale = Sale::create([
        'shift_id' => $shift->id,
        'station_id' => $station->id, // Required
        'pump_id' => $pump->id,
        'fuel_type_id' => $fuelType->id ?? 1,
        'created_by' => $user->id, // Instead of user_id
        'sale_number' => 'SL-' . time(), // Unique
        'sale_datetime' => now(), // Required
        'quantity' => 10.00, // Instead of liters
        'rate' => 350.00,
        'amount' => 3500.00,
        'final_amount' => 3500.00,
        'payment_mode' => 'cash', // Instead of payment_method
        'created_at' => now()
    ]);
    logSuccess("Recorded Cash Sale: ID {$sale->id} for {$sale->amount}");

    // Update shift totals (assuming logic exists in app, but doing manual here for data consistency check later)
    $shift->increment('cash_sales', 3500.00);
    $shift->increment('total_sales', 3500.00);
    $shift->increment('total_fuel_sold', 10.00);

} catch (\Exception $e) {
    logError("Failed to record sale", $e);
}

// 3.2 Record a Cash Drop
logStep("CASH DROP", "Testing Cash Drop Flow");
try {
    $dropService = app(CashDropService::class);

    // Create
    $dropData = [
        'user_id' => $user->id,
        'amount' => 1500.00,
        'notes' => 'Mid-day drop'
    ];
    $drop = $dropService->createDrop($dropData);
    logSuccess("Created Cash Drop ID: {$drop->id} for {$drop->amount}");

    // Verify
    $verifiedDrop = $dropService->verifyDrop($drop->id);
    if ($verifiedDrop->status === 'verified') {
        logSuccess("Verified Cash Drop ID: {$drop->id}");
    } else {
        logError("Cash Drop verification failed. Status: {$verifiedDrop->status}");
    }

} catch (\Exception $e) {
    logError("Cash Drop Error", $e);
}

/* ==========================================================================
   4. CLOSING & REPORTING
   ========================================================================== */
logStep("CLOSING", "Closing Shift and Final Summary");

try {
    $shift->refresh();
    // Logic for closing
    $shift->update([
        'status' => 'closed',
        'end_time' => now(),
        'closed_at' => now(),
        'closing_cash' => 5000 + 3500 - 1500, // Opening + Sales - Drop (Simplistic view)
    ]);
    logSuccess("Closed Shift ID: {$shift->id}");
} catch (\Exception $e) {
    logError("Failed to close shift", $e);
}

// Final Report
echo "\n========================================\n";
echo "       FINAL INTEGRITY REPORT\n";
echo "========================================\n";
echo "Station:  {$station->name}\n";
echo "Shift ID: {$shift->id}\n";
echo "User:     {$user->name}\n";
echo "----------------------------------------\n";
echo "Total Sales Recorded:   " . Sale::where('shift_id', $shift->id)->sum('amount') . "\n";
echo "Total Drops Verified:   " . \App\Models\CashDrop::where('shift_id', $shift->id)->where('status', 'verified')->sum('amount') . "\n";
echo "Shift Status:           " . $shift->status . "\n";
echo "========================================\n";
