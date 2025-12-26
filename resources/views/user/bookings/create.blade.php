<x-app-layout>
    <x-slot name="header">
        <h4>Booking Ruangan</h4>
    </x-slot>

    <div class="container mt-4">
        <form method="POST" action="#">
            @csrf

            <div class="mb-3">
                <label class="form-label">Ruangan</label>
                <select class="form-select">
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->room_name }} - {{ $room->location }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label>Tanggal</label>
                    <input type="date" class="form-control">
                </div>
                <div class="mb-3 col-md-6">
                    <label>Durasi</label>
                    <select class="form-select">
                        <option>6 Jam</option>
                        <option>12 Jam</option>
                        <option>Harian</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-primary">Submit Booking</button>
        </form>
    </div>
</x-app-layout>
