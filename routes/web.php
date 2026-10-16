<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Indonesian Aliases for convenience
    Route::redirect('/pesanan', '/bookings');
    Route::redirect('/pemesanan', '/bookings');
    Route::redirect('/pesanan/create', '/bookings/create');
    Route::redirect('/pemesanan/create', '/bookings/create');

    // Bookings - Specific Static Routes FIRST
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/approvals', [BookingController::class, 'pendingApprovals'])->name('bookings.approvals');
    Route::get('/bookings/export', [BookingController::class, 'export'])->name('bookings.export');

    // Admin-only: Create & Store (MUST be before {booking} wildcard!)
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    });

    // Dynamic {booking} wildcard routes (strictly constrained to numbers)
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->whereNumber('booking')
        ->name('bookings.show');
        
    Route::post('/bookings/{booking}/approve-l1', [BookingController::class, 'approveL1'])
        ->whereNumber('booking')
        ->name('bookings.approve-l1');
        
    Route::post('/bookings/{booking}/approve-l2', [BookingController::class, 'approveL2'])
        ->whereNumber('booking')
        ->name('bookings.approve-l2');
        
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])
        ->whereNumber('booking')
        ->name('bookings.reject');

    // Admin-only routes
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {

        // Bookings admin actions on specific booking
        Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])
            ->whereNumber('booking')
            ->name('bookings.edit');
            
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])
            ->whereNumber('booking')
            ->name('bookings.update');
            
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
            ->whereNumber('booking')
            ->name('bookings.cancel');
            
        Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])
            ->whereNumber('booking')
            ->name('bookings.complete');

        // Vehicles
        Route::resource('vehicles', VehicleController::class);

        // Drivers
        Route::resource('drivers', DriverController::class);

        // Users
        Route::resource('users', UserController::class)->except(['show']);

        // Activity Logs
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    });
});
