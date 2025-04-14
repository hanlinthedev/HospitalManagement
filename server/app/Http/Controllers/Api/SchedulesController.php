<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SchedulesController extends Controller
{
    private function errorResponse($message, $errors = null, $statusCode = 422)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    private function getDoctorProfile()
    {
        $profile = Auth::user()->doctorProfile;

        if (!$profile) {
            return $this->errorResponse('Doctor profile not found.', null, 403);
        }
        return $profile;
    }

    public function index()
    {
        $schedule = Schedule::all();
        return response()->json(['status' => 200, 'data' => $schedule], 200);
    }

    // // if needed to create 
    // public function create()
    // {  
    //     $rooms = Room::get()->pluck('room_number','id');
    //     $doctors = DoctorProfile::get()->pluck('name','id');
    //     return response()->json([
    //         'status' => 200, 
    //         'data' => [
    //             'rooms' => $rooms,
    //             'doctors' => $doctors
    //         ],
    //     ]);
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => "nullable|exists:rooms,id",
            'doctor_id' => "nullable|exists:doctor_profiles,id",
            'day' => 'required',
            'period' => 'required',
            'booking_limit' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating schedule', $validator->errors());
        }

        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->hasRole('doctor')) {
                $profile = $this->getDoctorProfile();

                $is_schedule_exists = $profile->schedules()
                    ->where('day', $request->day)
                    ->where('period', $request->period)
                    ->exists();

                if ($is_schedule_exists) {
                    return $this->errorResponse('A schedule for this day and period already exists.', null, 409);
                }

                $profile->schedules()->create([
                    'day' => $request->day,
                    'period' => $request->period,
                    'booking_limit' => $request->booking_limit
                ]);
            } else {
                $schedule = new Schedule();
                $schedule->room_id = $request->room_id;
                $schedule->doctor_id = $request->doctor_id;
                $schedule->day = $request->day;
                $schedule->period = $request->period;
                $schedule->booking_limit = $request->booking_limit;

                $schedule->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Schedule created successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating room', ['exception' => [$e->getMessage()]], 500);
        }
    }

    // // if needed to edit
    // public function edit(string $id)
    // {   
    //     $schedules = Schedule::findOrFail($id);
    //     $rooms = Room::get()->pluck('room_number','id');
    //     $doctors = DoctorProfile::get()->pluck('name','id');
    //     return response()->json([
    //         'status' => 200, 
    //         'data' => [
    //             'rooms' => $rooms,
    //             'doctors' => $doctors,
    //             'schedules' => $schedules
    //         ],
    //     ]);
    // }

    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => "nullable|exists:rooms,id",
            'doctor_id' => "nullable|exists:doctor_profiles,id",
            'day' => 'required',
            'period' => 'required',
            'booking_limit' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating schedule', $validator->errors());
        }

        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->hasRole('doctor')) {
                $profile = $this->getDoctorProfile();

                if ($schedule->doctor_id != $profile->id) {
                    return $this->errorResponse('This schedule does not belong to you', null, 403);
                }

                $schedule->update([
                    'day' => $request->day,
                    'period' => $request->period,
                    'booking_limit' => $request->booking_limit
                ]);
            } else {
                // $schedule = Schedule::findOrFail($id);
                $schedule->room_id = $request->room_id;
                $schedule->doctor_id = $request->doctor_id;
                $schedule->day = $request->day;
                $schedule->period = $request->period;
                $schedule->booking_limit = $request->booking_limit;

                $schedule->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Schedule updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating schedule', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);

            if (!$schedule) {
                return $this->errorResponse('Schedule not found', null, 404);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->hasRole('doctor')) {
                $profile = $this->getDoctorProfile();

                if ($schedule->doctor_id != $profile->id) {
                    return $this->errorResponse('This schedule does not belong to you', null, 403);
                }
            }

            $schedule->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Schedule deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting schedule', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function getSchedulesForDoctor()
    {
        $profile = $this->getDoctorProfile();
        $schedules = $profile->schedules()->orderBy('day')->orderBy('period')->get();

        return response()->json(['status' => 200, 'data' => $schedules], 200);
    }

    public function show(Schedule $schedule)
    {
        $schedule->load('appointments');

        $profile = $this->getDoctorProfile();
        if ($schedule->doctor_id != $profile->id) {
            return $this->errorResponse('This schedule does not belong to you', null, 403);
        }

        return response()->json(['status' => 200, 'data' => $schedule], 200);
    }
}
