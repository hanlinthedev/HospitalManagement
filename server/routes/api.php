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
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

Route::group(['prefix' => "auth"], function(){
    Route::post('signup', [JwtAuthController::class, 'register']);
    Route::post('signin', [JwtAuthController::class, 'login']);  

} );

Route::get('home', [HomeController::class, 'index']);
Route::get('departments', [SpecializationsController::class, 'index']);
Route::get('departments/{department}', [SpecializationsController::class, 'show']);
Route::get('departments/{department}/doctors', [HomeController::class, 'doctorsOfDepartment']);
Route::get('doctors', [DoctorController::class, 'index']);
Route::get('doctors/{doctor}', [DoctorController::class, 'show']);

Route::group(['middleware' => ['jwtauthmiddleware']], function () {
    // Common user route
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('role:user');
    Route::post('logout', [JwtAuthController::class, 'logout']);  
    Route::post('refresh', [JwtAuthController::class, 'refresh'] );
    Route::resource('/userprofiles',UserProfilesController::class);
    Route::post('/userprofiles/update/{id}',[UserProfilesController::class,'update']);

    Route::resource('/patientprofiles',PatientProfilesController::class);

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


