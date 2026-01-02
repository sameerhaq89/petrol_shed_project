<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TankController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\DipManagementController;

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

Route::middleware(['auth', 'is-admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/add-purchases', [App\Http\Controllers\AddPurchasesController::class, 'index'])->name('add-purchases');
    Route::get('/add-expenses', [App\Http\Controllers\AddExpensesController::class, 'index'])->name('add-expenses');
    Route::get('/tanks', [TankController::class, 'index']);
    Route::get('/settlement', [SettlementController::class, 'index']);
     Route::get('/settlement/entries', [SettlementController::class, 'entries']); // just to check nothing else
    Route::get('/dip-management', [DipManagementController::class, 'index']);
});
