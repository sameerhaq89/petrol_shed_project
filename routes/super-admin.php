<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
|
| Here are the routes for the Super Admin panel.
|
*/

Route::prefix('super-admin')->name('super-admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('super-admin.pages.dashboard');
    })->name('dashboard');

    // Subscriptions
    Route::get('/subscriptions', function () {
        return view('super-admin.pages.subscriptions');
    })->name('subscriptions');

    // Stations
    Route::get('/stations', function () {
        return view('super-admin.pages.stations');
    })->name('stations');

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/list', function () {
            return view('super-admin.pages.users.list');
        })->name('list');

        Route::get('/admins', function () {
            return view('super-admin.pages.users.admins');
        })->name('admins');

        Route::get('/staff', function () {
            return view('super-admin.pages.users.staff');
        })->name('staff');
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

    // Logout
    Route::post('/logout', function () {
        // Add logout logic here
        return redirect()->route('login');
    })->name('logout');
});
