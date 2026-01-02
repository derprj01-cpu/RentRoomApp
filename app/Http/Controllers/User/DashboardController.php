<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        return view('user.dashboard', [
            'totalBookings'   => Booking::where('user_id', $userId)->count(),
            'activeBookings'  => Booking::where('user_id', $userId)
                                        ->whereIn('status', ['pending', 'approved'])
                                        ->count(),
            'todayBookings'   => Booking::where('user_id', $userId)
                                        ->whereDate('booking_date', today())
                                        ->count(),
            'upcomingBookings'=> Booking::with('room')
                                        ->where('user_id', $userId)
                                        ->whereDate('booking_date', '>=', today())
                                        ->orderBy('start_time')
                                        ->limit(5)
                                        ->get(),
        ]);
    }
}
