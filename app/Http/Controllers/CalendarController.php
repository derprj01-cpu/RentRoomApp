<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = [];

        $query = Booking::with(['room', 'user']);

        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }

        $bookings = $query->get();

        foreach ($bookings as $booking) {
            // Gunakan booking_date sebagai tanggal acuan
            $eventDate = $booking->booking_date ?? $booking->start_time;

            // Jika booking_date hanya date tanpa waktu, tambahkan waktu default
            if (is_string($eventDate) && strlen($eventDate) === 10) {
                $startTime = date('Y-m-d 09:00:00', strtotime($eventDate));
                $endTime = date('Y-m-d 10:00:00', strtotime($eventDate));
            } else {
                // Gunakan start_time dan end_time jika ada
                $startTime = $booking->start_time;
                $endTime = $booking->end_time;
            }

            $events[] = [
                'title' => $booking->room->room_name . ' - ' .
                          ($booking->user->name ?? 'N/A') .
                          ' [' . ucfirst($booking->status) . ']',
                'start' => $startTime,
                'end'   => $endTime,
                'allDay' => false, // Event dengan durasi waktu
                'extendedProps' => [
                    'purpose' => $booking->purpose,
                    'status'  => $booking->status,
                    'room'    => $booking->room->room_name,
                    'user'    => $booking->user->name ?? 'N/A',
                    'booking_date' => $booking->booking_date
                ]
            ];
        }

        return view('calendar.index', compact('events'));
    }
}
