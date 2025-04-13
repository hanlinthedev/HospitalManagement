<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Models\DoctorProfile;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Support\Facades\Gate;
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
        $schedules = ScheduleResource::collection(Schedule::all());
        return response()->json([ 'status' => 200,'data' => $schedules], 200);
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

    public function show(Schedule $schedule){

            return response()->json([
                'status' => 200,
                'data' => new ScheduleResource($schedule),
            ], 200);
        
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Schedule::class);

        $validator = Validator::make($request->all(), [
            'room_id'=>"required|exists:rooms,id",
            'doctor_id'=>"required|exists:doctor_profiles,id",
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
                'data' => new ScheduleResource($schedule),
                'message' => 'schedule created successfully'
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
        Gate::authorize('update', $schedule);
        $validator = Validator::make($request->all(), [
            'room_id'=>"exists:rooms,id",
            'doctor_id'=>"  exists:doctor_profiles,id",
            'day'=> 'required',
            'period'=> 'required',
            'booking_limit'=> 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating schedule', $validator->errors());
        }

        try {

            $schedule->room_id = $request->room_id;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = $request->day;
            $schedule->period = $request->period;
            $schedule->booking_limit = $request->booking_limit;

            $schedule->save();

            return response()->json([
                'status' => 200,
                'data' => new ScheduleResource($schedule),
                'message' => 'Schedule updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating schedule', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(Schedule $schedule)
    {
        Gate::authorize('delete', $schedule);

        try {
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
