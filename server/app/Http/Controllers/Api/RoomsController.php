<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Gate;

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


    public function scheudlesOfRoom($id){

        $room = Room::with('schedules')->where('id', $id)->get();
        return response()->json([
            'status' => 200,
            'data' => $room,
        ], 200);

    }

    public function index()
    {
        $rooms = Room::all();
        return response()->json([
            'rooms' => RoomResource::collection($rooms),
            'status' => 200,
        ], 200);
    }

    public function show(Room $room){

        if(! $room){
            return response()->json([
            ], 204);    
        }
        return response()->json([
            'status' => 200,
            'room' => new RoomResource($room),
        ], 200 );
    }


    public function store(Request $request)
    {

        Gate::authorize('create', Room::class);

        $validator = Validator::make($request->all(), [
            'room_number' => 'required|unique:rooms,room_number|integer',
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
                'room' => new RoomResource($room),
                'message' => 'Room created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating room', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, Room $room)
    {
        Gate::authorize('update', $room);
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|integer|unique:rooms,room_number,' . $room->id,
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating room', $validator->errors());
        }

        try {
            $room->room_number = $request->room_number;

            $room->save();

            return response()->json([
                'status' => 200,
                'room' => new RoomResource($room),
                'message' => 'Room updated successfully',
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating room', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(Room $room)
    {

        Gate::authorize('delete', $room);

        try {
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
