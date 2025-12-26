<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingLog>
 */
class BookingLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::inRandomOrder()->first()->id,
            'action' => $this->faker->randomElement([
                'created',
                'approved',
                'rejected',
                'cancelled'
            ]),
            'action_by' => User::inRandomOrder()->first()->id,
            'note' => $this->faker->sentence(),
        ];
    }
}
