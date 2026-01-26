<?php

use App\Models\Sale;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sales = Sale::latest()->take(5)->get();

foreach ($sales as $sale) {
    echo "ID: " . $sale->id . " | Amount: " . $sale->amount . " | Mode: " . $sale->payment_mode . "\n";
}
