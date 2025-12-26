<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'duration_type' => $this->faker->randomElement(['hourly', 'daily']),
            'duration_value' => $this->faker->randomElement([6, 12, 1]),
            'price' => $this->faker->randomFloat(2, 500000, 2000000),
            'usage_type' => $this->faker->randomElement(['academic', 'event']),
        ];
    }
}
