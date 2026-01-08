<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $events = $this->getEvents();
        $rooms = Room::all();
        $upcomingBookings = $this->getUpcomingBookings();


        return view('calendar.index', compact('events', 'rooms', 'upcomingBookings'));
    }

    public function events(Request $request)
    {
        $query = Booking::with(['room', 'user']);

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('room_id') && $request->room_id) {
            $query->where('room_id', $request->room_id);
        }

        // User can only see their own bookings
        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }

        $bookings = $query->get();
        $events = [];

        foreach ($bookings as $booking) {
            // Gunakan booking_date sebagai tanggal utama
            // Default ke start_time jika booking_date tidak ada
            $date = $booking->booking_date ?? $booking->start_time;
            $dateObj = Carbon::parse($date);

            // Ambil waktu dari start_time dan end_time
            $startTime = Carbon::parse($booking->start_time);
            $endTime = Carbon::parse($booking->end_time);

            // Buat tanggal lengkap dengan waktu
            $eventStart = $dateObj->format('Y-m-d') . 'T' . $startTime->format('H:i:s');
            $eventEnd = $dateObj->format('Y-m-d') . 'T' . $endTime->format('H:i:s');

            // Format untuk display
            $timeDisplay = $startTime->format('h:i A') . ' - ' . $endTime->format('h:i A');

            $events[] = [
                'title' => $booking->room->room_name . ' [' . ucfirst($booking->status) . ']',
                'start' => $eventStart,
                'end'   => $eventEnd,
                'allDay' => false,
                'extendedProps' => [
                    'bookingId' => $booking->id,
                    'purpose' => $booking->purpose,
                    'status'  => $booking->status,
                    'room'    => $booking->room->room_name,
                    'user'    => $booking->user->name ?? 'N/A',
                    'date'    => $dateObj->format('M d, Y'),
                    'time'    => $timeDisplay,
                    'booking_date' => $booking->booking_date
                ]
            ];
        }

        return response()->json($events);
    }

    private function getEvents()
    {
        $query = Booking::with(['room', 'user']);

        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }

        $bookings = $query->get();
        $events = [];

        foreach ($bookings as $booking) {
            $date = $booking->booking_date ?? $booking->start_time;
            $dateObj = Carbon::parse($date);

            $startTime = Carbon::parse($booking->start_time);
            $endTime = Carbon::parse($booking->end_time);

            $eventStart = $dateObj->format('Y-m-d') . 'T' . $startTime->format('H:i:s');
            $eventEnd = $dateObj->format('Y-m-d') . 'T' . $endTime->format('H:i:s');

            $events[] = [
                'title' => $booking->room->room_name . ' [' . ucfirst($booking->status) . ']',
                'start' => $eventStart,
                'end'   => $eventEnd,
                'allDay' => false,
                'extendedProps' => [
                    'bookingId' => $booking->id,
                    'purpose' => $booking->purpose,
                    'status'  => $booking->status,
                    'room'    => $booking->room->room_name,
                    'user'    => $booking->user->name ?? 'N/A',
                    'date'    => $dateObj->format('M d, Y'),
                    'time'    => $startTime->format('h:i A') . ' - ' . $endTime->format('h:i A'),
                    'booking_date' => $booking->booking_date
                ]
            ];
        }

        return $events;
    }

    private function getUpcomingBookings()
    {
        $query = Booking::with(['room', 'user']);

        // Gunakan booking_date untuk filter
        $query->where(function($q) {
            $q->whereNotNull('booking_date')
              ->whereDate('booking_date', '>=', Carbon::today())
              ->whereDate('booking_date', '<=', Carbon::today()->addDays(7));
        });

        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }

        $query->orderBy('booking_date', 'asc')
              ->orderBy('start_time', 'asc');

        return $query->get();
    }
}
