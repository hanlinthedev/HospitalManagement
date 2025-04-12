<?php

use App\Http\Controllers\Api\AppointmentsController;
use App\Http\Controllers\Api\DoctorProfilesController;
use App\Http\Controllers\Api\DoctorRemarksController;
use App\Http\Controllers\Api\PatientProfilesController;
use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\SchedulesController;
use App\Http\Controllers\Api\SpecializationsController;
use App\Http\Controllers\Api\UserProfilesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JwtAuthController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;

Route::group(['prefix' => "auth"], function(){
    Route::post('signup', [JwtAuthController::class, 'register']);
    Route::post('signin', [JwtAuthController::class, 'login']);

} );

Route::get('test',[UserProfilesController::class,'test']);
Route::get('home',[HomeController::class,'index']);

Route::group(['middleware' => ['jwtauthmiddleware']], function () {
    // Common user route
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('role:user');
    Route::post('logout', [JwtAuthController::class, 'logout']);
    Route::post('refresh', [JwtAuthController::class, 'refresh'] );

    // user_profile
    Route::get('/profile', [UserProfilesController::class, 'index']);
    Route::post('/profile',[UserProfilesController::class,'store']);
    Route::post('/profile/update/{id}',[UserProfilesController::class,'update']);

    // patient_profile
    Route::get('/profile/patient/{id}/',[PatientProfilesController::class,'getid']);
    Route::post('/profile/patient/create',[PatientProfilesController::class,'store']);
    Route::put('/profile/patient/update/{id}',[PatientProfilesController::class,'update']);
    Route::delete('/profile/patient/delete/{id}',[PatientProfilesController::class,'destroy']);

    // Admin-only routes
    Route::group(['middleware' => ['role:admin']], function () {
        // Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        // Route::apiResource('/admin/users', AdminUserController::class);
        Route::resource('/admin/specializations',SpecializationsController::class);

    });

    Route::resource('/rooms',RoomsController::class);
    Route::resource('/schedules',SchedulesController::class);
    Route::resource('/doctorprofiles',DoctorProfilesController::class);
    Route::resource('/appointments',AppointmentsController::class);
    Route::resource('/doctorremarks',DoctorRemarksController::class);


    // Doctor-only routes
    Route::group(['middleware' => ['role:doctor']], function () {
        // Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard']);
        // Route::resource('/doctorprofiles',DoctorProfilesController::class);
        Route::post('/doctorprofiles/update/{id}',[DoctorProfilesController::class,'update']);
    });
});


