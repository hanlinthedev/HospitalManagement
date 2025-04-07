<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomsController extends Controller
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
        $room = Room::all();
        return response()->json([ 'status' => 200,'data' => $room], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating room', $validator->errors());
        }

        try {

            $room = new Room();
            $room->room_number = $request->room_number;

            $room->save();

            return response()->json([
                'status' => 200,
                'message' => 'Room created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating room', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating room', $validator->errors());
        }

        try {

            $room = Room::findOrFail($id);
            $room->room_number = $request->room_number;

            $room->save();

            return response()->json([
                'status' => 200,
                'message' => 'Room updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating room', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $room = Room::findOrFail($id);

            if (!$room) {
                return $this->errorResponse('Room not found', null, 404);
            }

            $room->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Room deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting room', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
