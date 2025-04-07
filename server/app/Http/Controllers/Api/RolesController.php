<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
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
        $role = Role::all();

        return response()->json([ 'status' => 200,'data' => $role], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating roles', $validator->errors());
        }

        try {

            $role = new Role();
            $role->name = $request->name;

            $role->save();

            return response()->json([
                'status' => 200,
                'message' => 'Role created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating roles', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating roles', $validator->errors());
        }

        try {

            $role = Role::findOrFail($id);
            $role->name = $request->name;

            $role->save();

            return response()->json([
                'status' => 200,
                'message' => 'Role updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating role', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);

            if (!$role) {
                return $this->errorResponse('Role not found', null, 404);
            }

            $role->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Role deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting role', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
