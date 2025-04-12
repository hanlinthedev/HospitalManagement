<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            'Cardiologist',
            'Dermatologist',
            'Neurologist',
            'Pediatrician',
            'Psychiatrist',
            'Surgeon',
            'Orthopedic',
            'Dentist',
            'Gynecologist',
            'Ophthalmologist',
        ];

        foreach ($specializations as $specialization) {
            Specialization::create([
                'name' => $specialization,
                'icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png',
            ]);
        }
    }
}
