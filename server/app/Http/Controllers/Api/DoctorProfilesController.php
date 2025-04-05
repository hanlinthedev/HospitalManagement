<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DoctorProfilesController extends Controller
{
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
        $doctorprofile = DoctorProfile::all();
        $specialization = Specialization::get()->pluck('name','id');

        return response()->json([
            'status' => 200,
            'data' => $doctorprofile,
            'specialization' => $specialization
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'degree' => 'required',
            'experience' => 'required',
            'profile_picture' => 'required|file',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating profile', $validator->errors());
        }

        try {
            $user = Auth::user(); // You can use $user->id instead of hardcoded 1
            // $user_id = $user->id;

            $doctorprofile = new DoctorProfile();
            $doctorprofile->user_id = 1;
            $doctorprofile->name = $request->name;
            $doctorprofile->specialization_id = $request->specialization_id;
            $doctorprofile->degree = $request->degree;
            $doctorprofile->experience = $request->experience;

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $fname = $file->getClientOriginalName();
                $file->move(public_path('assets/img/doctor/profile_picture/'), $fname);
                $doctorprofile->profile_picture = 'assets/img/doctor/profile_picture/' . $fname;
            }

            $doctorprofile->save();

            return response()->json([
                'status' => 200,
                'message' => 'Doctor profile created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating profile', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'degree' => 'required',
            'experience' => 'required',
            'profile_picture' => 'required|file',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating profile', $validator->errors());
        }

        try {
            $user = Auth::user(); // You can use $user->id instead of hardcoded 1
            // $user_id = $user->id;

            $doctorprofile = DoctorProfile::findOrFail($id);
            $doctorprofile->user_id = 1;
            $doctorprofile->name = $request->name;
            $doctorprofile->specialization_id = $request->specialization_id;
            $doctorprofile->degree = $request->degree;
            $doctorprofile->experience = $request->experience;

            if ($request->hasFile('profile_picture')) {

                if (File::exists($doctorprofile->profile_picture)) {
                    File::delete($doctorprofile->profile_picture);
                }

                $file = $request->file('profile_picture');
                $fname = $file->getClientOriginalName();
                $file->move(public_path('assets/img/doctor/'), $fname);
                $doctorprofile->profile_picture = 'assets/img/doctor/' . $fname;
            }

            $doctorprofile->save();

            return response()->json([
                'status' => 200,
                'message' => 'Doctor profile updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating profile', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $doctorprofile = DoctorProfile::find($id);

            if (!$doctorprofile) {
                return $this->errorResponse('Doctor profile not found', null, 404);
            }

            if (File::exists($doctorprofile->profile_picture)) {
                File::delete($doctorprofile->profile_picture);
            }

            $doctorprofile->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Doctor profile deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting profile', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
