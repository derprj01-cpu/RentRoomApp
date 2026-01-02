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
    public function index(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            $query = Booking::with(['user', 'room'])
                ->select('bookings.*')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->join('rooms', 'bookings.room_id', '=', 'rooms.id');

            // Search functionality
            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('users.name', 'like', "%{$searchTerm}%")
                    ->orWhere('users.email', 'like', "%{$searchTerm}%")
                    ->orWhere('rooms.room_name', 'like', "%{$searchTerm}%")
                    ->orWhere('rooms.location', 'like', "%{$searchTerm}%")
                    ->orWhere('bookings.purpose', 'like', "%{$searchTerm}%");
                });
            }

            // Filter by status
            if ($request->has('status') && $request->status) {
                $query->where('bookings.status', $request->status);
            }

            // Filter by room type
            if ($request->has('type') && $request->type) {
                $query->where('rooms.type', $request->type);
            }

            // Filter by date
            if ($request->has('date') && $request->date) {
                $query->whereDate('bookings.start_time', $request->date);
            }

            // Sorting
            $sortBy = $request->get('sort', 'bookings.created_at');
            $sortOrder = $request->get('direction', 'desc');

            // Map frontend sort keys to database columns
            $sortMap = [
                'user_name' => 'users.name',
                'room_name' => 'rooms.room_name',
                'location' => 'rooms.location',
                'schedule' => 'bookings.start_time',
                'type' => 'rooms.type',
                'purpose' => 'bookings.purpose',
            ];

            $sortColumn = $sortMap[$sortBy] ?? 'bookings.created_at';
            $query->orderBy($sortColumn, $sortOrder);

            $bookings = $query->paginate(10);

            // AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.bookings.partials.results', compact('bookings'))->render(),
                    'total' => $bookings->total()
                ]);
            }

            return view('admin.bookings.index', compact('bookings'));
        }

        // User view
        $query = Booking::with('room')
            ->where('user_id', auth()->id());

        // Search for user
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('purpose', 'like', "%{$searchTerm}%")
                ->orWhereHas('room', function($roomQuery) use ($searchTerm) {
                    $roomQuery->where('room_name', 'like', "%{$searchTerm}%")
                                ->orWhere('location', 'like', "%{$searchTerm}%");
                });
            });
        }

        // Filter by status for user
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by type for user
        if ($request->has('type') && $request->type) {
            $query->whereHas('room', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        // Sorting for user
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('direction', 'desc');

        $sortMap = [
            'room_name' => 'rooms.room_name',
            'location' => 'rooms.location',
            'schedule' => 'start_time',
            'type' => 'rooms.type',
        ];

        if (array_key_exists($sortBy, $sortMap)) {
            if (in_array($sortBy, ['room_name', 'location', 'type'])) {
                $query->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                    ->orderBy($sortMap[$sortBy], $sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $bookings = $query->paginate(10);

        // AJAX request for user
        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.bookings.partials.results', compact('bookings'))->render(),
                'total' => $bookings->total()
            ]);
        }

        return view('user.bookings.index', compact('bookings'));
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
        // Authorization check
        if (auth()->user()->role === 'user' && $booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Load relationships
        $booking->load(['room', 'user']);

        // For user bookings count
        $booking->user->loadCount('bookings');

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
