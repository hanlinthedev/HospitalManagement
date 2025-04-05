<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PatientProfilesController extends Controller
{
    // Unified error response method
    private function errorResponse($message, $errors = null, $statusCode = 422)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    public function index()
    {
        $patientprofile = PatientProfile::all();

        return response()->json([
            'status' => 200,
            'data' => $patientprofile
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'age' => 'required',
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating profile', $validator->errors());
        }

        try {
            $user = Auth::user(); // You can use $user->id instead of hardcoded 1
            // $user_id = $user->id;

            $patientprofile = new PatientProfile();
            $patientprofile->user_id = 1;
            $patientprofile->name = $request->name;
            $patientprofile->phone = $request->phone;
            $patientprofile->age = $request->age;
            $patientprofile->gender = $request->gender;

            $patientprofile->save();

            return response()->json([
                'status' => 200,
                'message' => 'Patient profile created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating profile', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'age' => 'required',
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating profile', $validator->errors());
        }

        try {
            $user = Auth::user(); // You can use $user->id instead of hardcoded 1
            // $user_id = $user->id;

            $patientprofile = PatientProfile::findOrFail($id);
            $patientprofile->user_id = 1;
            $patientprofile->name = $request->name;
            $patientprofile->phone = $request->phone;
            $patientprofile->age = $request->age;
            $patientprofile->gender = $request->gender;

            $patientprofile->save();

            return response()->json([
                'status' => 200,
                'message' => 'Patient profile updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating profile', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $patientprofile = PatientProfile::find($id);

            if (!$patientprofile) {
                return $this->errorResponse('User profile not found', null, 404);
            }

            $patientprofile->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Patient profile deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting profile', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
