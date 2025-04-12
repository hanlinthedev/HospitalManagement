<?php

namespace Database\Factories;

use App\Models\PatientProfile;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'schedule_id' => Schedule::factory(),
            'patient_id' => PatientProfile::factory(), 
            'booking_no' => $this->faker->unique()->numberBetween(1, 100),
            'booking_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Pending', 'Confirmed', 'Cancelled', 'Completed']),
        ];
    }
}
