<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(){
        $doctors = DoctorProfile::with(['user', 'specialization'])
                ->when(request('search'), function($query){
                    $query->where("name", 'like', '%'.request('search').'%');
                })
                ->get();

        if(count($doctors) === 0){
            return response()->json([
            ], 204);    
        }

        return response()->json([
            'data' => $doctors,
            'message' => "all doctors retrived successfully",
            'statusCode' => 200,
        ], 200);
    }

    public function show($id){

        $doctor = DoctorProfile::with(['user', 'specialization'])->where('id', $id)->get();

        if(count($doctor) == 0){
            return response()->json([
            ], 204);    
        }

        return response()->json([
            'data' => $doctor,
            'message' => "doctor retrived successfully",
            'statusCode' => 200,
        ], 200);
    }
}
