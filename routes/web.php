<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CalendarController;
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
    Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');

    // ADMIN
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'index'])
                ->name('dashboard');

            // Route::get('/rooms/search', [RoomsController::class, 'search'])->name('rooms.search');

            Route::resource('rooms', RoomsController::class);

            Route::resource('bookings', BookingsController::class);

            Route::patch('bookings/{booking}/approve', [BookingsController::class, 'approve'])
                ->name('bookings.approve');

            Route::patch('bookings/{booking}/reject', [BookingsController::class, 'reject'])
                ->name('bookings.reject');

        });

    // USER
    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('/dashboard', [UserDashboard::class, 'index'])
                ->name('dashboard');
            Route::resource('bookings', BookingsController::class)->only([
                'index', 'create', 'store', 'update',
            ]);
            Route::patch('bookings/cancel/{booking}', [BookingsController::class, 'cancel'])
                ->name('bookings.cancel');
                Route::get('/bookings/{booking}', [BookingsController::class, 'show'])
                ->middleware('auth')
                ->name('bookings.show');
        });
});


require __DIR__.'/auth.php';
