<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {

            return view('admin.bookings.index',[
                'bookings' => $bookings = Booking::with(['user', 'room'])
                ->latest()
                ->paginate(10),
            ]);
        }

        $bookings = Booking::with('room')
            ->where('user_id', auth()->id())
            ->paginate(10);

        return view('user.bookings.index',[
                'bookings' => $bookings
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Booking::class);

        $rooms = Room::select('id', 'room_name', 'location')->where('status','available')->orderBy('room_name')->get();
        return view('user.bookings.create',compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Booking::class);

        $validated = $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'booking_date'   => 'required|date',
            'start_time'     => 'required|date_format:H:i',
            'duration_type'  => 'required|in:6_hours,12_hours,daily',
            'purpose'        => 'required|string',
        ]);

        // Start datetime
        $start = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['booking_date'] . ' ' . $validated['start_time']
        );

        // Hitung end time
        $end = match ($validated['duration_type']) {
            '6_hours'  => $start->copy()->addHours(6),
            '12_hours' => $start->copy()->addHours(12),
            'daily'    => $start->copy()->endOfDay(),
        };

        Booking::create([
            'user_id'       => auth()->id(),
            'room_id'       => $validated['room_id'],
            'booking_date'  => $validated['booking_date'],
            'start_time'    => $start->format('H:i'),
            'end_time'      => $end->format('H:i'),
            'duration_type' => $validated['duration_type'],
            'purpose'       => $validated['purpose'],
            'status'        => 'pending',
        ]);

        return redirect()
            ->route('user.bookings.index')
            ->with('success', 'Booking successfully submitted.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $user = auth()->user();

        // USER hanya boleh lihat booking miliknya
        if ($user->role === 'user' && $booking->user_id !== $user->id) {
            abort(403);
        }

        $booking->load(['room', 'user']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve(Booking $booking)
    {
        $this->authorize('approve', $booking);

        $booking->update(['status' => 'approved']);

        return back()->with('success', 'Booking approved.');
    }

    public function reject(Booking $booking)
    {
        $this->authorize('approve', $booking);

        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking rejected.');
    }


    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        if (! in_array($booking->status, ['pending', 'approved'])) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
