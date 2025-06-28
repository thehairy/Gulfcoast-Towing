<?php

use App\Http\Controllers\Auth\SteamController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\DispatchController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Landing Page - Öffentlich zugänglich
Route::get('/', function () {
    return Inertia::render('Landing/Index');
})->name('home');

// Employee Logout
Route::post('/mitarbeiter/logout', [DashboardController::class, 'logout'])->name('employee.logout');

// Mitarbeiterportal - Nur für Mitarbeiter mit Steam-Authentifizierung
Route::prefix('mitarbeiter')->name('employee.')->middleware(['employee.auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Leitstelle/Dispatch
    Route::get('/leitstelle', [DispatchController::class, 'index'])->name('dispatch');
    Route::post('/leitstelle/fahrzeug-zuweisen', [DispatchController::class, 'assignVehicle'])->name('dispatch.assign');
    Route::post('/leitstelle/fahrzeug-zurueckgeben', [DispatchController::class, 'returnVehicle'])->name('dispatch.return');
    Route::post('/leitstelle/fahrzeug-hinzufuegen', [DispatchController::class, 'addVehicle'])->name('dispatch.add-vehicle');
    Route::post('/leitstelle/dienststatus', [DispatchController::class, 'updateDutyStatus'])->name('dispatch.duty-status');
    Route::post('/leitstelle/leitstelle-toggle', [DispatchController::class, 'toggleDispatcher'])->name('dispatch.toggle');
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
