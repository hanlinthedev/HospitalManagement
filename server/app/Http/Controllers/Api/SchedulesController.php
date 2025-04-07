<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;
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

    public function index()
    {
        $schedule = Schedule::all();
        return response()->json([ 'status' => 200,'data' => $schedule], 200);
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
            'room_id'=>"nullable|exists:rooms,id",
            'doctor_id'=>"nullable|exists:doctor_profiles,id",
            'day'=> 'required',
            'period'=> 'required',
            'booking_limit'=> 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating schedule', $validator->errors());
        }

        try {

            $schedule = new Schedule();
            $schedule->room_id = $request->room_id;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = $request->day;
            $schedule->period = $request->period;
            $schedule->booking_limit = $request->booking_limit;

            $schedule->save();

            return response()->json([
                'status' => 200,
                'message' => 'Room created successfully'
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_id'=>"nullable|exists:rooms,id",
            'doctor_id'=>"nullable|exists:doctor_profiles,id",
            'day'=> 'required',
            'period'=> 'required',
            'booking_limit'=> 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating schedule', $validator->errors());
        }

        try {

            $schedule = Schedule::findOrFail($id);
            $schedule->room_id = $request->room_id;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = $request->day;
            $schedule->period = $request->period;
            $schedule->booking_limit = $request->booking_limit;

            $schedule->save();

            return response()->json([
                'status' => 200,
                'message' => 'Schedule updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating schedule', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);

            if (!$schedule) {
                return $this->errorResponse('Schedule not found', null, 404);
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
}
