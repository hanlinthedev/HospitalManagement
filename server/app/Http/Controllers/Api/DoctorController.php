<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::role('doctor')->get();
        return response()->json(['status' => 200, 'data' => $doctors], 200);
    }

    public function show(User $doctor)
    {
        return response()->json(['status' => 200, 'data' => $doctor], 200);
    }

    public function search(Request $request)
    {
        $doctors = User::role('doctor')
            ->where('email', 'like', '%' . $request->input('search') . '%')
            ->get();

        return response()->json(['status' => 200, 'data' => $doctors], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|email|max:255|string|unique:users,email",
            'password' => "required|max:30|string|min:8",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole('doctor');
        
        return response()->json([
            'status' => 200,
            'message' => "Doctor created successfully",
        ], 200);
    }

    public function update(Request $request, User $doctor)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|email|max:255|string|unique:users,email",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors(),
            ], 400);
        }

        $doctor->update([
            'email' => $request->email,
        ]);
        
        return response()->json([
            'status' => 200,
            'message' => "Doctor updated successfully",
        ], 200);
    }
}
