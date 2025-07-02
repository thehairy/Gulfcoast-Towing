<?php

use App\Http\Controllers\Auth\SteamController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\DispatchController;
use App\Http\Controllers\Employee\ServiceRegulationsController;
use App\Http\Controllers\Employee\EmployeeListController;
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
});

// Employee List Management - Jetzt über das Dashboard verfügbar
Route::prefix('employee-list')->middleware(['employee.auth'])->group(function () {
    Route::get('/', [EmployeeListController::class, 'index'])->name('employee.list');
    Route::put('/{employee}', [DashboardController::class, 'updateEmployee'])->name('employee.update');
    Route::post('/{employee}/training', [DashboardController::class, 'addTraining'])->name('employee.training.add');
    Route::delete('/{employee}/training/{training}', [DashboardController::class, 'removeTraining'])->name('employee.training.remove');
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

// Admin routes for testing
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/import-employees', function () {
        \Illuminate\Support\Facades\Artisan::call('employees:import-towing');
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Import completed',
            'output' => $output
        ]);
    })->name('import.employees');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
