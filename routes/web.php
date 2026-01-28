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

Route::get('/subscription-expired', function () {
    return view('subscription-expired');
})->name('subscription.expired')->middleware('auth');

Route::middleware(['auth', 'subscription'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::post('/switch-station', [App\Http\Controllers\StationSwitcherController::class, 'switch'])->name('switch-station');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class)->middleware('can:roles.view');

    Route::resource('tanks', TankController::class);
    Route::post('tanks/{id}/adjust-stock', [TankController::class, 'adjustStock'])->name('tanks.adjustStock');



    Route::resource('pumps', PumpController::class);
    Route::resource('dip-management', DipReadingController::class);

    Route::resource('settlement-list', SettlementListcontroller::class);
    Route::get('/settlement-data', [SettlementListcontroller::class, 'getData']);



    Route::get('fuel-management', [FuelManagementController::class, 'index'])->name('fuel-management.index');
    Route::resource('fuel-types', FuelTypeController::class);
    Route::resource('fuel-prices', FuelPriceController::class);

    Route::get('/pumper-management/ledger/{id}', [PumperManagementController::class, 'showLedger'])->name('pumper.ledger');
    Route::get('/pumper-management/report/{id}', [PumperManagementController::class, 'settlementReport'])->name('pumper.report');
    Route::get('/pumper-management/close-duty/{id}', [PumperManagementController::class, 'closeDutyForm'])->name('pumper.close.form');
    Route::post('/pumper-management/settle/{id}', [PumperManagementController::class, 'settleShortage'])->name('pumper.settle');
    Route::get('/pumper-management', [PumperManagementController::class, 'index'])->name('pumper.index');
    Route::post('/pumper-management/assign', [PumperManagementController::class, 'assignPumper'])->name('pumper.assign');
    Route::get('/pumper-management/close/{id}', [PumperManagementController::class, 'closeDutyForm'])->name('pumper.close-form');
    Route::post('/pumper-management/close/{id}', [PumperManagementController::class, 'processCloseDuty'])->name('pumper.process-close');


    Route::get('/settlement/{id}', [ShiftController::class, 'show'])->name('settlement.entry');
    Route::get('/settlement/{id}', [ShiftController::class, 'show'])->name('settlement.index');
    Route::get('/settlement', [ShiftController::class, 'directEntry'])->name('settlement.index');
    Route::get('/settlement/{id}', [ShiftController::class, 'show'])->name('settlement.entry');
    Route::post('/settlement/save-reading', [ShiftController::class, 'saveReading'])->name('settlement.save-reading');
    Route::post('/settlement/start', [ShiftController::class, 'startShift'])->name('settlement.start');
    Route::post('/settlement/{id}/calculate', [VarianceController::class, 'calculate'])->name('variance.calculate');
    Route::post('/settlement/{id}/explain', [VarianceController::class, 'explain'])->name('variance.explain');
    Route::post('/settlement/{id}/approve', [VarianceController::class, 'approve'])->name('variance.approve');
    Route::get('/settlement-direct', [ShiftController::class, 'directEntry'])->name('settlement.direct');


    Route::post('/shifts/open', [ShiftController::class, 'store'])->name('shifts.open');
    Route::put('/shifts/{id}/close', [ShiftController::class, 'update'])->name('shifts.close');
    Route::post('/shifts/close-settlement', [ShiftController::class, 'close'])->name('settlement.close');



    Route::post('cash-drops', [CashDropController::class, 'store'])->name('cash-drops.store');
    Route::post('cash-drops/{id}/verify', [CashDropController::class, 'verify'])->name('cash-drops.verify');

    Route::delete('cash-drops/{id}', [CashDropController::class, 'destroy'])->name('cash-drops.destroy');
    Route::post('/cash-drop/store', [CashDropController::class, 'store'])->name('cash-drop.store');


    Route::get('/pumper/dashboard', [PumperManagementController::class, 'dashboard'])->name('pumpers-dashboard');
    Route::get('/pumper/sales', [PumperManagementController::class, 'salesEntry'])->name('pumper.sales.entry');
    Route::post('/pumper/sales', [PumperManagementController::class, 'storeSale'])->name('pumper.sales.store');
    Route::delete('/sales/{id}', [ShiftController::class, 'deleteSale'])->name('sales.destroy');
});

// Super Admin Routes
require __DIR__ . '/super-admin.php';
