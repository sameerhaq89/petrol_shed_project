<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TankController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\DipManagementController;
use App\Http\Controllers\SettlementListcontroller;
use App\Http\Controllers\PumpController;


use App\Http\Controllers\CashDropController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/add-purchases', [App\Http\Controllers\AddPurchasesController::class, 'index'])->name('add-purchases');
    Route::get('/add-expenses', [App\Http\Controllers\AddExpensesController::class, 'index'])->name('add-expenses');
    Route::get('/tanks', [TankController::class, 'index']);
    Route::get('/settlement', [SettlementController::class, 'index']);
    Route::get('/settlement/entries', [SettlementController::class, 'entries']); // just to check nothing else
    Route::get('/dip-management', [DipManagementController::class, 'index']);
    Route::get('/pump-management', [PumpController::class, 'index']);
    Route::resource('settlement-list', SettlementListcontroller::class);
    Route::get('/settlement-data', [SettlementListcontroller::class, 'getData']);
});




// Route::middleware(['auth'])->group(function () {
//     Route::get('/shifts/{shiftId}/drops', [CashDropController::class, 'index'])->name('cash-drops.index');
//     Route::get('/cash-drops/create', [CashDropController::class, 'create'])->name('cash-drops.create');
//     Route::post('/cash-drops', [CashDropController::class, 'store'])->name('cash-drops.store');
//     Route::post('/cash-drops/{id}/verify', [CashDropController::class, 'verify'])->name('cash-drops.verify');
// });