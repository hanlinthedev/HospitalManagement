<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['jwt.auth']], function () {
    // Common user route
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('role:user');

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