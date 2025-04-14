<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    private function getDoctorProfile(){
        $profile = Auth::user()->doctorProfile;

        if (!$profile) {
            return $this->errorResponse('Doctor profile not found.', null, 403);
        }
        return $profile;
    }

    public function index()
    {
        $doctorprofile = DoctorProfile::all();
        $specialization = Specialization::get()->pluck('name', 'id');

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
            'specialization_id' => 'required|exists:specializations,id',
            'degree' => 'required',
            'experience' => 'required',
            'profile_picture' => 'required|file',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating profile', $validator->errors());
        }

        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->doctorProfile) {
                return $this->errorResponse('Doctor profile already exists.', null, 409);
            }

            // $user = Auth::user();
            // $user_id = $user->id;

            // $doctorprofile = new DoctorProfile();
            // $doctorprofile->user_id = $user_id;
            // $doctorprofile->name = $request->name;
            // $doctorprofile->specialization_id = $request->specialization_id;
            // $doctorprofile->degree = $request->degree;
            // $doctorprofile->experience = $request->experience;

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $fname = $file->getClientOriginalName();
                $file->move(public_path('assets/img/doctor/profile_picture/'), $fname);
                // $doctorprofile->profile_picture = 'assets/img/doctor/profile_picture/' . $fname;
            }

            // $doctorprofile->save();

            $user->doctorProfile()->create([
                'name' => $request->name,
                'specialization_id' => $request->specialization_id,
                'degree' => $request->degree,
                'experience' => $request->experience,
                'profile_picture' => ($request->hasFile('profile_picture')) ? 'assets/img/doctor/profile_picture/' . $fname : null,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Doctor profile created successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating profile', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'specialization_id' => 'required|exists:specializations,id',
            'degree' => 'required',
            'experience' => 'required',
            'profile_picture' => 'required|file',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating profile', $validator->errors());
        }

        try {
            // $user = Auth::user(); // You can use $user->id instead of hardcoded 1
            // $user_id = $user->id;

            // $doctorprofile = DoctorProfile::findOrFail($id);
            // $doctorprofile->user_id = 1;
            // $doctorprofile->name = $request->name;
            // $doctorprofile->specialization_id = $request->specialization_id;
            // $doctorprofile->degree = $request->degree;
            // $doctorprofile->experience = $request->experience;

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!$user->doctorProfile) {
                return $this->errorResponse('Doctor profile not found.', null, 403);
            }

            $data = $request->only(['name', 'specialization_id', 'degree', 'experience']);

            if ($request->hasFile('profile_picture')) {

                if (File::exists($user->doctorProfile->profile_picture)) {
                    File::delete($user->doctorProfile->profile_picture);
                }

                $file = $request->file('profile_picture');
                $fname = $file->getClientOriginalName();
                $file->move(public_path('assets/img/doctor/'), $fname);
                // $doctorprofile->profile_picture = 'assets/img/doctor/' . $fname;
                $data['profile_picture'] = 'assets/img/doctor/profile_picture/' . $fname;
            }

            $user->doctorProfile()->update($data);

            // $doctorprofile->save();            

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

    public function show()
    {
        $profile = $this->getDoctorProfile();
        return response()->json(['status' => 200, 'data' => $profile], 200);
    }

    public function patients()
    {
        $profile = $this->getDoctorProfile();

        $appointments = Appointment::with('patient')
            ->whereHas('schedule', function ($query) use ($profile) {
                $query->where('doctor_id', $profile->id);
            })->get();

        $patients = $appointments->pluck('patient')->unique('id')->values()->sortBy('name');

        return response()->json(['status' => 200, 'data' => $patients], 200);
    }

    public function getPatientAppointments(PatientProfile $patient)
    {
        $profile = $this->getDoctorProfile();

        $appointments = $patient->appointments()
            ->whereHas('schedule', function ($query) use ($profile) {
                $query->where('doctor_id', $profile->id);
            })
            ->orderBy('booking_date', 'desc')
            ->get();

        if ($appointments->isEmpty()) {
            return $this->errorResponse('Unauthorized access to this patient.', null, 403);
        }

        return response()->json(['status' => 200, 'data' => $appointments], 200);
    }

    public function getAppointmentSchedule(PatientProfile $patient, Appointment $appointment)
    {
        $profile = $this->getDoctorProfile();

        if (!($appointment->schedule && $appointment->schedule->doctor_id == $profile->id)) {
            return $this->errorResponse('This appointment does not belong to your patients', null, 403);
        }

        if ($appointment->patient_id != $patient->id) {
            return $this->errorResponse('This appointment does not belong to this patient', null, 403);
        }

        $schedule = $appointment->schedule;

        return response()->json(['status' => 200, 'data' => $schedule], 200);
    }

    public function appointments(Request $request)
    {
        $profile = $this->getDoctorProfile();

        $query = Appointment::whereHas('schedule', function ($sub_query) use ($profile) {
            $sub_query->where('doctor_id', $profile->id);
        });

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('booking_date', 'desc')->get();

        return response()->json(['status' => 200, 'data' => $appointments], 200);
    }

    public function schedules()
    {
        $profile = $this->getDoctorProfile();
        $schedules = $profile->schedules()->orderBy('day')->orderBy('period')->get();

        return response()->json(['status' => 200, 'data' => $schedules], 200);
    }
}
