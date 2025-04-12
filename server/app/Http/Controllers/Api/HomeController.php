<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\Specialization;

class HomeController extends Controller
{
    public function index()
    {
        $doctor = DoctorProfile::take(3)->get()->toArray();
        $department = Specialization::take(3)->get()->toArray();
        $data = [
            'doctor' => $doctor,
            'department' => $department,
        ];
        return response()->json($data,200);

    }
}
