<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\SubscriptionPlanController;
use App\Http\Controllers\SuperAdmin\AddonController;
use App\Http\Controllers\SuperAdmin\StationManagementController;
use App\Http\Controllers\SuperAdmin\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\Auth\RegisterController;
use App\Http\Controllers\SuperAdmin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
|
| Here are the routes for the Super Admin panel.
|
*/

// Super Admin Authentication Routes
Route::prefix('super-admin')->name('super-admin.')->group(function () {

    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Protected Super Admin Routes
Route::prefix('super-admin')->name('super-admin.')->middleware(['auth:super-admin'])->group(function () {

    // Redirect /super-admin to /super-admin/dashboard
    Route::get('/', function () {
        return redirect()->route('super-admin.dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Subscription Plans Management
    Route::resource('plans', SubscriptionPlanController::class)->except(['show']);
    Route::patch('plans/{id}/toggle-status', [SubscriptionPlanController::class, 'toggleStatus'])->name('plans.toggle-status');

    // Addons Management
    Route::resource('addons', AddonController::class)->except(['show']);
    Route::patch('addons/{id}/toggle-status', [AddonController::class, 'toggleStatus'])->name('addons.toggle-status');

    // Stations Management
    Route::get('/stations', [StationManagementController::class, 'index'])->name('stations.index');
    Route::get('/stations/create', [StationManagementController::class, 'create'])->name('stations.create');
    Route::post('/stations', [StationManagementController::class, 'store'])->name('stations.store');
    Route::get('/stations/{id}', [StationManagementController::class, 'show'])->name('stations.show');
    Route::post('/stations/{id}/assign-subscription', [StationManagementController::class, 'assignSubscription'])->name('stations.assign-subscription');
    Route::get('/stations/{id}/manage-addons', [StationManagementController::class, 'manageAddons'])->name('stations.manage-addons');
    Route::put('/stations/{id}/update-addons', [StationManagementController::class, 'updateAddons'])->name('stations.update-addons');

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/list', [UserManagementController::class, 'index'])->name('list');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/store', [UserManagementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('toggle-status');

        Route::get('/admins', [UserManagementController::class, 'admins'])->name('admins');
        Route::get('/staff', [UserManagementController::class, 'staff'])->name('staff');
    });

    // Extras
    Route::prefix('extras')->name('extras.')->group(function () {
        Route::get('/reports', function () {
            return view('super-admin.pages.extras.reports');
        })->name('reports');

        Route::get('/analytics', function () {
            return view('super-admin.pages.extras.analytics');
        })->name('analytics');

        Route::get('/logs', function () {
            return view('super-admin.pages.extras.logs');
        })->name('logs');
    });

    // Settings
    Route::get('/settings', function () {
        return view('super-admin.pages.settings');
    })->name('settings');

    // Profile
    Route::get('/profile', function () {
        return view('super-admin.pages.profile');
    })->name('profile');
});
