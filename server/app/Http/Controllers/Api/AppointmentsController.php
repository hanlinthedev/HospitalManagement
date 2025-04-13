<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        return response()->json(['status' => 200, 'data' => $appointment], 200);
    }

    public function getBookings(string $id)
    {
        try{

            $getbookingid = Appointment::where("patient_id", $id)->get();
            return response()->json(['status' => 200, 'data' => $getbookingid], 200);

        }catch(\Exception $e){
            return $this->errorResponse('An error occurred while getting booking', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => "required|exists:schedules,id",
            'patient_id' => "required|exists:patient_profiles,id",
            'booking_no' => 'required',
            'booking_date' => 'required',
            // 'status' => 'required'
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
            $appointment->status = 'Pending';
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment created successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating appointment', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => "required|exists:schedules,id",
            'patient_id' => "required|exists:patient_profiles,id",
            'booking_no' => 'required',
            'booking_date' => 'required',
            // 'status' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating appointment', $validator->errors());
        }

        try {

            // $appointment = Appointment::findOrFail($id);
            $appointment->schedule_id = $request->schedule_id;
            $appointment->patient_id = $request->patient_id;
            $appointment->booking_no = $request->booking_no;
            $appointment->booking_date = $request->booking_date;
            // $appointment->status = $request->status;

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

    public function getAppointmentsByUser()
    {
        $patientIds = Auth::user()->patientProfiles->pluck('id');

        $appointments = Appointment::whereIn('patient_id', $patientIds)->orderBy('booking_date', 'desc')->get();

        return response()->json(['status' => 200, 'data' => $appointments], 200);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('remark');
        return response()->json(['status' => 200, 'data' => $appointment], 200);
    }

    public function cancel(Appointment $appointment)
    {
        try {
            $appointment->status = 'Cancelled';
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment canceled successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating appointment', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
