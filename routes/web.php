<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TicketPriceController;
use Illuminate\Support\Facades\Route;

// Halaman customer
Route::get('/', [OrderController::class, 'index'])
    ->name('customer.index');

Route::post('/checkout', [OrderController::class, 'store'])
    ->name('customer.checkout');

// Halaman admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [
            OrderController::class,
            'adminDashboard',
        ])->name('admin.dashboard');

        Route::patch('/orders/{id}/status', [
            OrderController::class,
            'updateStatus',
        ])->name('admin.orders.updateStatus');

        Route::resource('movies', MovieController::class);

        Route::resource('ticket-prices', TicketPriceController::class);

        Route::resource('schedules', ScheduleController::class);
    });

// Halaman yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.index');
    })->name('dashboard');

    // Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Route autentikasi bawaan
require __DIR__ . '/auth.php';
