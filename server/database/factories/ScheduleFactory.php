<?php

namespace Database\Factories;

use App\Models\DoctorProfile;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
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
            'doctor_id' => DoctorProfile::factory(),
            'day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'period' => $this->faker->randomElement(['Morning', 'Afternoon']),
            'booking_limit' => $this->faker->numberBetween(5, 10),
        ];
    }
}
