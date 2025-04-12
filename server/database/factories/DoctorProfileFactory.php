<?php

namespace Database\Factories;

use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorProfile>
 */
class DoctorProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'name' => $this->faker->name(),
            'specialization_id' => Specialization::inRandomOrder()->first()?->id,
            'degree' => $this->faker->randomElement(['MD', 'MBBS', 'DO', 'PhD']),
            'experience' => $this->faker->numberBetween(1, 20),
            'profile_picture' => $this->faker->imageUrl(200, 200, 'people', true, 'Doctor'),
        ];
    }
}
