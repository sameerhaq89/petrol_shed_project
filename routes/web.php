<?php

use App\Http\Controllers\AddExpensesController;
use App\Http\Controllers\AddPurchasesController;
use App\Http\Controllers\CashDropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DipReadingController;
use App\Http\Controllers\FuelManagementController;
use App\Http\Controllers\FuelPriceController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PumpController;
use App\Http\Controllers\PumperManagementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettlementListcontroller;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VarianceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register']);

// --- AUTHENTICATED ROUTES GROUP ---
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    // Route::get('/', [HomeController::class, 'index'])->name('home');

    // Simple Pages
    Route::get('/add-purchases', [AddPurchasesController::class, 'index'])->name('add-purchases');
    Route::get('/add-expenses', [AddExpensesController::class, 'index'])->name('add-expenses');

    // Tank & Settlement
    // This creates all necessary routes: tanks.index, tanks.store, tanks.update, etc.
    Route::resource('tanks', TankController::class);
    Route::post('tanks/{id}/adjust-stock', [TankController::class, 'adjustStock'])->name('tanks.adjustStock');

    // Resources
    // Route::get('/dip-management', [DipManagementController::class, 'index']);
    // This creates: pumps.index, pumps.store, pumps.edit, pumps.update, pumps.destroy
    Route::resource('pumps', PumpController::class);
    Route::resource('dip-management', DipReadingController::class);

    Route::resource('settlement-list', SettlementListcontroller::class);
    Route::get('/settlement-data', [SettlementListcontroller::class, 'getData']);

    // Fuel Price Managementd
    Route::resource('fuel-prices', FuelPriceController::class);
    Route::get('fuel-management', [FuelManagementController::class, 'index'])->name('fuel-management.index');
    // Fuel Type Management (Settings)
    // Show the Closing Meter Page
    Route::get('/pumper-management/close/{id}', [PumperManagementController::class, 'closeDutyForm'])->name('pumper.close-form');

    // Process the Closing
    Route::post('/pumper-management/close/{id}', [PumperManagementController::class, 'processCloseDuty'])->name('pumper.process-close');
    Route::resource('fuel-types', FuelTypeController::class);
    Route::get('/pumper-management', [PumperManagementController::class, 'index'])->name('pumper.index');
    Route::post('/pumper-management/assign', [PumperManagementController::class, 'assignPumper'])->name('pumper.assign');
    // --- USER MANAGEMENT ---
    // This single line creates: index, create, store, show, edit, update, destroy
    // It automatically names them: users.index, users.create, users.store, etc.
    Route::resource('users', UserController::class);
    // --- SETTLEMENT LIST (History) ---
    // This uses SettlementListController which correctly sends $settlements to the view
    Route::resource('settlement-list', SettlementListcontroller::class);

    // --- SETTLEMENT ENTRY (The Missing Link) ---
    // UNCOMMENT THIS LINE so you can view/enter data for a specific shift
    Route::get('/settlement/{id}', [ShiftController::class, 'show'])->name('settlement.entry');
    // web.php
    // Add this to your routes/web.php
    Route::get('/pumper-management/ledger/{id}', [PumperManagementController::class, 'showLedger'])->name('pumper.ledger');
    Route::get('/pumper-management/report/{id}', [PumperManagementController::class, 'settlementReport'])->name('pumper.report');
    Route::get('/pumper-management/close-duty/{id}', [PumperManagementController::class, 'closeDutyForm'])->name('pumper.close.form');
    // --- SHIFT ACTIONS (Open/Close) ---
    // --- SETTLEMENT ENTRY (The Missing Link) ---
    // This was likely pointing to the wrong place or had the wrong name
    Route::get('/settlement/{id}', [ShiftController::class, 'show'])->name('settlement.index');
    // If someone goes to /settlement without an ID, send them to the latest open shift
    Route::get('/settlement', [ShiftController::class, 'directEntry'])->name('settlement.index');
    Route::post('/pumper-management/settle/{id}', [PumperManagementController::class, 'settleShortage'])->name('pumper.settle');
    // This is the main page that needs the ID
    Route::get('/settlement/{id}', [ShiftController::class, 'show'])->name('settlement.entry');

    Route::post('/shifts/open', [ShiftController::class, 'store'])->name('shifts.open');
    Route::put('/shifts/{id}/close', [ShiftController::class, 'update'])->name('shifts.close');
    // Change the existing line to this or add this one:
    Route::post('/shifts/close-settlement', [ShiftController::class, 'close'])->name('settlement.close');
    Route::post('/settlement/save-reading', [ShiftController::class, 'saveReading'])->name('settlement.save-reading');
    Route::get('/settlement-direct', [ShiftController::class, 'directEntry'])->name('settlement.direct');
    // --- CASH DROPS ---
    Route::post('cash-drops', [CashDropController::class, 'store'])->name('cash-drops.store');
    Route::post('cash-drops/{id}/verify', [CashDropController::class, 'verify'])->name('cash-drops.verify');
    Route::delete('/sales/{id}', [App\Http\Controllers\ShiftController::class, 'deleteSale'])->name('sales.destroy');
    // --- ROLE MANAGEMENT ---
    // We apply the permission check here specifically for roles
    Route::resource('roles', RoleController::class)->middleware('can:roles.view');
    // --- CASH DROPS ---
    Route::post('/settlement/start', [App\Http\Controllers\ShiftController::class, 'startShift'])->name('settlement.start');
    Route::post('/settlement/{id}/calculate', [VarianceController::class, 'calculate'])->name('variance.calculate');
    Route::post('/settlement/{id}/explain', [VarianceController::class, 'explain'])->name('variance.explain');
    Route::post('/settlement/{id}/approve', [VarianceController::class, 'approve'])->name('variance.approve');

    // ADD THIS MISSING LINE:
    Route::delete('cash-drops/{id}', [CashDropController::class, 'destroy'])->name('cash-drops.destroy');
    Route::post('/cash-drop/store', [App\Http\Controllers\CashDropController::class, 'store'])->name('cash-drop.store');

    // --- PUMPER SALES ENTRY ---
    Route::get('/pumper/sales', [PumperManagementController::class, 'salesEntry'])->name('pumper.sales.entry');
    Route::post('/pumper/sales', [PumperManagementController::class, 'storeSale'])->name('pumper.sales.store');

});

// Remove the extra blocks at the bottom to avoid conflicts!
