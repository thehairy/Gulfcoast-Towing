<?php

use App\Http\Controllers\Auth\SteamController;
use App\Http\Controllers\Employee\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Landing Page - Öffentlich zugänglich
Route::get('/', function () {
    return Inertia::render('Landing/Index');
})->name('home');

// Steam Authentication Routes
Route::get('/auth/steam', [SteamController::class, 'redirect'])->name('steam.redirect');
Route::get('/auth/steam/callback', [SteamController::class, 'callback'])->name('steam.callback');

// Employee Login
Route::get('/employee/login', [DashboardController::class, 'login'])->name('employee.login');
Route::post('/employee/logout', [DashboardController::class, 'logout'])->name('employee.logout');

// Mitarbeiterportal - Nur für Mitarbeiter mit Steam-Authentifizierung
Route::prefix('mitarbeiter')->name('employee.')->middleware(['employee.auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/auftraege', function () {
        return Inertia::render('Employee/Orders', [
            'employee' => session('employee')
        ]);
    })->name('orders');
    
    Route::get('/fahrzeuge', function () {
        return Inertia::render('Employee/Vehicles', [
            'employee' => session('employee')
        ]);
    })->name('vehicles');
});

// Kundenportal - Für alle registrierten Spieler (Steam oder normale Registrierung)
Route::prefix('kunde')->name('customer.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Customer/Dashboard');
    })->name('dashboard');
    
    Route::get('/auftraege', function () {
        return Inertia::render('Customer/Orders');
    })->name('orders');
    
    Route::get('/anfrage', function () {
        return Inertia::render('Customer/Request');
    })->name('request');
});

// Alte Dashboard Route für Kompatibilität
Route::get('dashboard', function () {
    return redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
