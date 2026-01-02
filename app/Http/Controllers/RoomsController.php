<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Room::query();

    if ($request->filled('search')) {
        $query->where('room_name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('sort')) {
        $query->orderBy(
            $request->sort,
            $request->get('direction', 'asc')
        );
    } else {
        $query->latest();
    }

    $rooms = $query->paginate(10)->withQueryString();

    if ($request->ajax()) {
        return view('admin.rooms.partials.results', compact('rooms'));
    }

    return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_name'   => ['required', 'string', 'max:255'],
            'location'    => ['required', 'string', 'max:255'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'type'        => ['required', 'in:meeting,classroom,lab,ballroom'],
            'status'      => ['required', 'in:available,unavailable'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Room::create($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'room_name'   => ['required', 'string', 'max:255'],
            'location'    => ['required', 'string', 'max:255'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'type'        => ['required', 'in:meeting,classroom,lab,ballroom'],
            'status'      => ['required', 'in:available,unavailable'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $room = Room::findOrFail($id);

        $room->update($validated);

        return redirect()->route('admin.rooms.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room successfully deleted.');
            }
}
