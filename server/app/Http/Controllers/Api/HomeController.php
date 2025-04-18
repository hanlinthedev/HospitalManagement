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
        $doctor = DoctorProfile::with(['specialization' => function($query) {
    $query->select(['id', 'name','icon']);
}])->select(['name','specialization_id','profile_picture'])->take(3)->get()->toArray();
        $department = Specialization::select(['id','name','icon'])->take(3)->get()->toArray();
        $data = [
            'doctor' => $doctor,
            'department' => $department,
        ];
        return response()->json($data,200);

    }
}
