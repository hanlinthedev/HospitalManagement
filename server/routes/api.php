<?php

use App\Http\Controllers\Api\DoctorProfilesController;
use App\Http\Controllers\Api\PatientProfilesController;
use App\Http\Controllers\Api\SpecializationsController;
use App\Http\Controllers\Api\UserProfilesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('/userprofiles',UserProfilesController::class);
Route::post('/userprofiles/update/{id}',[UserProfilesController::class,'update']);

Route::resource('/patientprofiles',PatientProfilesController::class);
Route::resource('/specializations',SpecializationsController::class);

Route::resource('/doctorprofiles',DoctorProfilesController::class);
Route::post('/doctorprofiles/update/{id}',[DoctorProfilesController::class,'update']);
