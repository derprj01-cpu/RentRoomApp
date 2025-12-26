<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_name' => 'Room ' . $this->faker->randomLetter(),
            'location' => $this->faker->randomElement(['Gedung A', 'Gedung B']),
            'capacity' => $this->faker->numberBetween(20, 300),
            'type' => $this->faker->randomElement(['classroom', 'lab', 'ballroom']),
            'description' => $this->faker->sentence(),
            'status' => 'available',
        ];
    }
}
