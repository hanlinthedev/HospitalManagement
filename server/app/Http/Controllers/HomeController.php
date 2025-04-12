<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use League\CommonMark\Util\SpecReader;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class HomeController extends Controller
{

    public function doctorsOfDepartment($id){
        $doctors = Specialization::with('doctors')->where('id', $id)->get();

        return response()->json([
            'data' => $doctors,
            'statusCode' => 200,
            'message' => "doctors retrived successfully",
        ], 200);
    }


    public function index(){

        $doctors = DoctorProfile::with(['user', 'specialization'])->take(3)->get();
        $departments = Specialization::take(3)->get();

        return response()->json([
            'statusCode' => 200,
            'data' => [
                'doctors' => $doctors,
                'departments' => $departments,
            ],
            ], 200);
    }

    public function departments(){
        $departments = Specialization::with('doctors')->get();

        return response()->json([
            'data' => $departments,
        ], 200);
    }
}
