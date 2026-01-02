<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();

        $todayBookings = Booking::whereDate('booking_date', today())->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $activeBookings = Booking::whereIn('status', ['pending', 'approved'])
            ->where('start_time', '>=', now())
            ->count();

        // Recent bookings (5 terbaru)
        $recentBookings = Booking::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        // Today's bookings list
        $todayBookingsList = Booking::with(['user', 'room'])
            ->whereDate('booking_date', today())
            ->orderBy('start_time')
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'todayBookings',
            'pendingBookings',
            'activeBookings',
            'recentBookings',
            'todayBookingsList'
        ));
    }
}
