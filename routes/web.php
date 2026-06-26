<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — NexusDesk AI
|--------------------------------------------------------------------------
*/

// === Guest Routes ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// === Authenticated Routes ===
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (semua role)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Tiket (semua role — filter di controller)
    Route::prefix('tiket')->name('tiket.')->group(function () {
        Route::get('/', function () { abort(404); })->name('index');
        Route::get('/{id}', function () { abort(404); })->name('show');
    });

    // === Admin Only Routes ===
    Route::middleware('role:admin')->group(function () {

        // Knowledge Base — placeholder Fase 3
        Route::prefix('knowledge-base')->name('knowledge-base.')->group(function () {
            Route::get('/', function () { abort(404); })->name('index');
        });

        // Kelola User — placeholder Fase 2
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', function () { abort(404); })->name('index');
        });

        // Laporan — placeholder Fase 6
        Route::prefix('report')->name('report.')->group(function () {
            Route::get('/', function () { abort(404); })->name('index');
        });
    });
});
