<?php

use App\Models\PumpOperatorAssignment;
use App\Models\Sale;
use App\Models\CashDrop;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get latest assignment (assuming pumper user is ID 2 based on seeder for logic, but let's query broad)
$assignment = PumpOperatorAssignment::latest()->first();

$user_id = $assignment->user_id;
$shift_id = $assignment->shift_id;

$totalSales = Sale::where('shift_id', $shift_id)->where('created_by', $user_id)->sum('amount');
$cashSales = Sale::where('shift_id', $shift_id)->where('created_by', $user_id)->where('payment_mode', 'cash')->sum('amount');
$cardSales = Sale::where('shift_id', $shift_id)->where('created_by', $user_id)->where('payment_mode', 'card')->sum('amount');
$drops = CashDrop::where('shift_id', $shift_id)->where('user_id', $user_id)->sum('amount');
$float = $assignment->opening_cash;

$cashInHand = $float + $cashSales - $drops;

echo "Float: " . $float . "\n";
echo "Total Sales: " . $totalSales . "\n";
echo "Cash Sales: " . $cashSales . "\n";
echo "Card Sales: " . $cardSales . "\n";
echo "Drops: " . $drops . "\n";
echo "Calculated Cash In Hand: " . $cashInHand . "\n";
