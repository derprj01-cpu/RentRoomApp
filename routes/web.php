<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // ADMIN
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'index'])
                ->name('dashboard');
            Route::resource('rooms', RoomsController::class);
            Route::resource('bookings', BookingsController::class);
        });

    // USER
    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('/dashboard', [UserDashboard::class, 'index'])
                ->name('dashboard');
            Route::resource('bookings', BookingsController::class)->only([
                'index', 'create', 'store', 'update','destroy'
            ]);
        });
});


require __DIR__.'/auth.php';
