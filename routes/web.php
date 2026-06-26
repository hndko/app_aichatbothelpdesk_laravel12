<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\UserController;
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
        Route::get('/', [TiketController::class, 'index'])->name('index');
        Route::get('/create', [TiketController::class, 'create'])->name('create');
        Route::post('/', [TiketController::class, 'store'])->name('store');
        Route::get('/{id}', [TiketController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [TiketController::class, 'updateStatus'])->middleware('role:admin')->name('update-status');
    });

    // Chatbot AJAX Endpoint
    Route::post('/chatbot/{ticketId}/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

    // === Admin Only Routes ===
    Route::middleware('role:admin')->group(function () {

        // Kelola User
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
        });

        // Knowledge Base CRUD
        Route::prefix('knowledge-base')->name('knowledge-base.')->group(function () {
            Route::get('/', [KnowledgeBaseController::class, 'index'])->name('index');
            Route::get('/create', [KnowledgeBaseController::class, 'create'])->name('create');
            Route::post('/', [KnowledgeBaseController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KnowledgeBaseController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KnowledgeBaseController::class, 'update'])->name('update');
            Route::delete('/{id}', [KnowledgeBaseController::class, 'destroy'])->name('destroy');
        });

        // Laporan — placeholder Fase 6
        Route::prefix('report')->name('report.')->group(function () {
            Route::get('/', function () { abort(404); })->name('index');
        });
    });
});
