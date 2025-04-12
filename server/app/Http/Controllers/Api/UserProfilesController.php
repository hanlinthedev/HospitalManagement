<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfilesController extends Controller
{
    // Unified error response method
    private function errorResponse($message, $errors = null, $statusCode = 422)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    public function test() {
        $data = User::role('admin')->with('roles')->get();
        return response()->json($data, 200);
    }
    public function index()
    {
        $userprofiles = UserProfile::all();

        return response()->json([
            'status' => 200,
            'data' => $userprofiles
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'phone' => 'required',
            'profile_picture' => 'required|file'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while creating profile', $validator->errors());
        }

        try {
            $user = Auth::user(); // You can use $user->id instead of hardcoded 1
            $user_id = $user->id;

            $userprofile = new UserProfile();
            $userprofile->user_id = $user_id;
            $userprofile->username = $request->username;
            $userprofile->phone = $request->phone;

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $fname = $file->getClientOriginalName();
                $file->move(public_path('assets/img/user/'), $fname);
                $userprofile->profile_picture = 'assets/img/user/' . $fname;
            }

            $userprofile->save();

            return response()->json([
                'status' => 200,
                'message' => 'User profile created successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating profile', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'phone' => 'required',
            'profile_picture' => 'required|file'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed while updating profile', $validator->errors());
        }

        try {
            $user = Auth::user(); // You can use $user->id instead of hardcoded 1
            $user_id = $user->id;
            $userprofile = UserProfile::find($id);

            if (!$userprofile) {
                return $this->errorResponse('User profile not found', null, 404);
            }

            $userprofile->user_id = $user_id;
            $userprofile->username = $request->username;
            $userprofile->phone = $request->phone;

            if ($request->hasFile('profile_picture')) {
                if (File::exists($userprofile->profile_picture)) {
                    File::delete($userprofile->profile_picture);
                }

                $file = $request->file('profile_picture');
                $fname = $file->getClientOriginalName();
                $file->move(public_path('assets/img/user/'), $fname);
                $userprofile->profile_picture = 'assets/img/user/' . $fname;
            }

            $userprofile->save();

            return response()->json([
                'status' => 200,
                'message' => 'User profile updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating profile', ['exception' => [$e->getMessage()]], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $userprofile = UserProfile::findOrFail($id);

            if (!$userprofile) {
                return $this->errorResponse('User profile not found', null, 404);
            }

            if (File::exists($userprofile->profile_picture)) {
                File::delete($userprofile->profile_picture);
            }

            $userprofile->delete();

            return response()->json([
                'status' => 200,
                'message' => 'User profile deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting profile', ['exception' => [$e->getMessage()]], 500);
        }
    }
}
