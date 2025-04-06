<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JwtAuthController;
use Illuminate\Http\Request;

Route::group(['prefix' => "auth"], function(){
    Route::post('signup', [JwtAuthController::class, 'register']);
    Route::post('signin', [JwtAuthController::class, 'login']);  
} );

Route::group(['middleware' => ['jwtauthmiddleware']], function () {
  // Common user route
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('role:user');
   Route::post('logout', [JwtAuthController::class, 'logout']);
    

    // Admin-only routes
    Route::group(['middleware' => ['role:admin']], function () {
        // Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        // Route::apiResource('/admin/users', AdminUserController::class);
    });

    // Doctor-only routes
    Route::group(['middleware' => ['role:doctor']], function () {
        // Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard']);
    });
});

