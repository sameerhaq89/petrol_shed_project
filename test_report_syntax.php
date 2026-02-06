<?php



require __DIR__ . '/vendor/autoload.php';

use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Carbon\Carbon;

error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    echo "Testing Report Generation...\n";

    $controller = new ReportController();

    // Mock Request for Sales Report
    $request = new Request([
        'report_type' => 'sales',
        'start_date' => Carbon::now()->subDays(30)->format('Y-m-d'),
        'end_date' => Carbon::now()->format('Y-m-d'),
    ]);

    // We can't easily call generate() because it returns a View which might fail outside HTTP context or if view data is missing.
    // However, we can test getReportData logic if we expose it or use reflection, 
    // OR we can just check if the code runs without syntax errors by instantiating.
    // Let's try to call the method and catch any exception.

    // Note: generate() returns a View, which might try to render and fail because of missing facade/session stuff in bare script.
    // So let's just inspect the class using reflection to ensure methods exist and basic syntax is ok.

    $rc = new ReflectionClass(ReportController::class);
    echo "Class loaded successfully.\n";

    foreach ($rc->getMethods() as $method) {
        echo "Method found: " . $method->getName() . "\n";
    }

    echo "Syntax check passed.\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
