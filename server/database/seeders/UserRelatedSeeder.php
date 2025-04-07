<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\DoctorRemark;
use App\Models\PatientProfile;
use App\Models\Schedule;
use App\Models\Specialization;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRelatedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 users
        User::factory()->count(5)->create()->each(function ($user) {
            UserProfile::factory()->create(['user_id' => $user->id]);
            $user->assignRole('user');
        });

        // Create 5 patients
        User::factory()->count(5)->create()->each(function ($user) {
            PatientProfile::factory()->create(['user_id' => $user->id]);
            $user->assignRole('user');
        });

        $day_period_combos = [
            ['day' => 'Monday', 'period' => 'Morning'],
            ['day' => 'Monday', 'period' => 'Afternoon'],
            ['day' => 'Tuesday', 'period' => 'Morning'],
            ['day' => 'Tuesday', 'period' => 'Afternoon'],
            ['day' => 'Wednesday', 'period' => 'Morning'],
            ['day' => 'Wednesday', 'period' => 'Afternoon'],
            ['day' => 'Thursday', 'period' => 'Morning'],
            ['day' => 'Thursday', 'period' => 'Afternoon'],
            ['day' => 'Friday', 'period' => 'Morning'],
            ['day' => 'Friday', 'period' => 'Afternoon'],
            ['day' => 'Saturday', 'period' => 'Morning'],
            ['day' => 'Saturday', 'period' => 'Afternoon'],
            ['day' => 'Sunday', 'period' => 'Morning'],
            ['day' => 'Sunday', 'period' => 'Afternoon'],
        ];

        // Create 5 doctors
        User::factory()->count(5)->create()->each(function ($user) use ($day_period_combos) {
            $doctor_profile = DoctorProfile::factory()->create(['user_id' => $user->id]);
            $user->assignRole('doctor');

            // Create 3 random day period combinations
            $schedules = collect($day_period_combos)->shuffle()->take(3);

            // Create schedules for each combination
            $schedules->each(function ($combo) use ($doctor_profile) {
                $schedule = Schedule::factory()->create([
                    'doctor_id' => $doctor_profile->id,
                    'day' => $combo['day'],
                    'period' => $combo['period'],
                ]);

                // Create 3 appointments for each schedule
                Appointment::factory()->count(3)->create([
                    'schedule_id' => $schedule->id,
                    'patient_id' => PatientProfile::inRandomOrder()->first()->id,
                ])->each(function ($appointment) {
                    // Create 1 doctor remark for each appointment
                    DoctorRemark::factory()->create([
                        'appointment_id' => $appointment->id,
                    ]);
                });
            });
        });
    }
}
