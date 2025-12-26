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
        return view('admin.dashboard', [
            'totalRooms'   => Room::count(),
            'availableRooms'   => Room::where('status', 'available')->count(),
            'totalUsers'   => User::where('role', 'user')->count(),
            'todayBookings' => Booking::whereDate('booking_date', today())->count(),
            'totalBookings'=> Booking::count(),
            'activeBookings'=> Booking::whereIn('status', ['pending', 'approved'])->count(),
            'latestBookings' => Booking::latest()->limit(5)->get(),
        ]);
    }
}
