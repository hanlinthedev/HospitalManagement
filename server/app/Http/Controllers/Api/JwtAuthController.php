<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => "required|max:255|string",
            'password' => "required|max:10|string|min:4",
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
                'statusCode' => 400,
            ], 400);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'statusCode' => 201,
            'message' => "user created successfully",
            'token' => $token,
            'user' => $user,
        ], 201);
    }


    public function login(Request $request){
        $cred = $request->only('email', 'password');
        try{
            if(! $token = JWTAuth::attempt($cred)){
                return response()->json([
                    'statusCode' => 401,
                    'message' => "invalid credentials",
                ], 401);
            }

            return response()->json([
                'statusCode' => 200,
                'message' => "user logged in successfully",
                'token' => $token,
            ], 200);
            
        }catch(JWTException $error){
            return response()->json([
                'statusCode' => 500,
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function logout(){

        
        // JWTAuth::invalidate(JWTAuth::getToken());

        auth()->guard('api')->logout();
        return response()->json([
            'statusCode' => 200,
            'message' => 'logged out successfully',
        ], 200);

    }
}
