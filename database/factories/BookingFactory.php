<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'room_id' => Room::inRandomOrder()->first()->id,
            'booking_date' => now()->addDays(rand(1, 10)),
            'start_time' => '08:00',
            'end_time' => '14:00',
            'duration_type' => '6_hours',
            'purpose' => $this->faker->sentence(),
            'status' => 'pending',
        ];
    }
}
