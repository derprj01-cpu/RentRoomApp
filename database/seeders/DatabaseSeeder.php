<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Price;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@kampus.ac.id',
        'role' => 'admin'
    ]);

    User::factory(4)->create(['role' => 'user']);

    $rooms = Room::factory()->count(20)->create();
    $rooms->each(function ($room) {
        Price::factory()->count(2)->create([
            'room_id' => $room->id,
        ]);
    });

    $bookings = Booking::factory()->count(25)->create();

    $bookings->each(function ($booking) {
        BookingLog::factory()->count(2)->create([
            'booking_id' => $booking->id,
        ]);
    });
    }
}
