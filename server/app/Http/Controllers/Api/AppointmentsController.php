<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
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
        $appointment = Appointment::all();
        return response()->json([ 'status' => 200,'data' => $appointment], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id'=>"required|exists:schedules,id",
            'patient_id'=>"required|exists:patient_profiles,id",
            'booking_no'=> 'required',
            'booking_date'=> 'required',
            'status'=> 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating appointment', $validator->errors());
        }

        try {

            $appointment = new Appointment();
            $appointment->schedule_id = $request->schedule_id;
            $appointment->patient_id = $request->patient_id;
            $appointment->booking_no = $request->booking_no;
            $appointment->booking_date = $request->booking_date;
            $appointment->status = $request->status;

            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating appointment', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id'=>"required|exists:schedules,id",
            'patient_id'=>"required|exists:patient_profiles,id",
            'booking_no'=> 'required',
            'booking_date'=> 'required',
            'status'=> 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating appointment', $validator->errors());
        }

        try {

            $appointment = Appointment::findOrFail($id);
            $appointment->schedule_id = $request->schedule_id;
            $appointment->patient_id = $request->patient_id;
            $appointment->booking_no = $request->booking_no;
            $appointment->booking_date = $request->booking_date;
            $appointment->status = $request->status;

            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating appointment', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);

            if (!$appointment) {
                return $this->errorResponse('Appointment not found', null, 404);
            }

            $appointment->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting appointment', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
