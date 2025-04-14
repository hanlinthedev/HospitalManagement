<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DoctorRemarksController extends Controller
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
        $doctorremark = DoctorRemark::all();
        return response()->json(['status' => 200, 'data' => $doctorremark], 200);
    }

    public function store(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            // 'appointment_id' => 'required|exists:appointments,id',
            'remark' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating doctorremark', $validator->errors());
        }

        try {
            $profile = $this->getDoctorProfile();

            if (!($appointment->schedule && $appointment->schedule->doctor_id == $profile->id)) {
                return $this->errorResponse('This appointment does not belong to your patients', null, 403);
            }

            $appointment->remark()->create([
                'remark' => $request->remark,
            ]);

            // $doctorremark = new DoctorRemark();
            // $doctorremark->appointment_id = $request->appointment_id;
            // $doctorremark->remark = $request->remark;

            // $doctorremark->save();

            return response()->json([
                'status' => 200,
                'message' => 'Remark created successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating doctorremark', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            // 'appointment_id' => 'required|exists:appointments,id',
            'remark' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating doctorremark', $validator->errors());
        }

        try {
            $profile = $this->getDoctorProfile();

            if (!($appointment->schedule && $appointment->schedule->doctor_id == $profile->id)) {
                return $this->errorResponse('This appointment does not belong to your patients', null, 403);
            }

            $appointment->remark()->update([
                'remark' => $request->remark,
            ]);

            // $doctorremark = DoctorRemark::findOrFail($id);
            // $doctorremark->appointment_id = $request->appointment_id;
            // $doctorremark->remark = $request->remark;

            // $doctorremark->save();

            return response()->json([
                'status' => 200,
                'message' => 'Remark updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating doctorremark', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $doctorremark = DoctorRemark::findOrFail($id);

            if (!$doctorremark) {
                return $this->errorResponse('Doctorremark not found', null, 404);
            }

            $doctorremark->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Doctorremark deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting doctorremark', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function getAppointmentRemark(Appointment $appointment)
    {
        $profile = $this->getDoctorProfile();

        if (!($appointment->schedule && $appointment->schedule->doctor_id == $profile->id)) {
            return $this->errorResponse('This appointment does not belong to your patients', null, 403);
        }

        $appointment->load('remark');

        return response()->json(['status' => 200, 'data' => $appointment], 200);
    }
}
