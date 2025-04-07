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
            ]);
        }
    }
}
