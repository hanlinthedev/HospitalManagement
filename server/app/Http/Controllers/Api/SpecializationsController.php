<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationsController extends Controller
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
        $specialization = Specialization::all();

        return response()->json([
            'status' => 200,
            'data' => $specialization
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating specialization', $validator->errors());
        }

        try {

            $specialization = new Specialization();
            $specialization->name = $request->name;

            $specialization->save();

            return response()->json([
                'status' => 200,
                'message' => 'Specialization created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating specialization', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating specialization', $validator->errors());
        }

        try {

            $specialization = Specialization::findOrFail($id);
            $specialization->name = $request->name;

            $specialization->save();

            return response()->json([
                'status' => 200,
                'message' => 'Specialization updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating specialization', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $specialization = Specialization::findOrFail($id);

            if (!$specialization) {
                return $this->errorResponse('User profile not found', null, 404);
            }

            $specialization->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Specialization deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting specialization', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
