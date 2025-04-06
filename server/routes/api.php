<?php

use App\Http\Controllers\Api\DoctorProfilesController;
use App\Http\Controllers\Api\PatientProfilesController;
use App\Http\Controllers\Api\SpecializationsController;
use App\Http\Controllers\Api\UserProfilesController;
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
    
  Route::resource('/userprofiles',UserProfilesController::class);
Route::post('/userprofiles/update/{id}',[UserProfilesController::class,'update']);

Route::resource('/patientprofiles',PatientProfilesController::class);



    // Admin-only routes
    Route::group(['middleware' => ['role:admin']], function () {
        // Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        // Route::apiResource('/admin/users', AdminUserController::class);
Route::resource('/specializations',SpecializationsController::class);
      
    });

    // Doctor-only routes
    Route::group(['middleware' => ['role:doctor']], function () {
        // Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard']);
      Route::resource('/doctorprofiles',DoctorProfilesController::class);
Route::post('/doctorprofiles/update/{id}',[DoctorProfilesController::class,'update']);
    });
});


