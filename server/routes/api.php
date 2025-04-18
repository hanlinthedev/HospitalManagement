<?php

use App\Http\Controllers\Api\AppointmentsController;
use App\Http\Controllers\Api\DoctorProfilesController;
use App\Http\Controllers\Api\DoctorRemarksController;
use App\Http\Controllers\Api\PatientProfilesController;
use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\SchedulesController;
use App\Http\Controllers\Api\SpecializationsController;
use App\Http\Controllers\Api\UserProfilesController;
use App\Http\Controllers\Api\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JwtAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;

Route::group(['prefix' => "auth"], function () {
    Route::post('signup', [JwtAuthController::class, 'register']);
    Route::post('signin', [JwtAuthController::class, 'login']);
});

Route::get('departments', [SpecializationsController::class, 'index']);
Route::get('departments/{department}', [SpecializationsController::class, 'show']);
Route::get('departments/{department}/doctors', [HomeController::class, 'doctorsOfDepartment']);
Route::get('doctors', [DoctorController::class, 'index']);
Route::get('doctors/{doctor}', [DoctorController::class, 'show']);
Route::get('home', [HomeController::class, 'index']);


Route::group(['middleware' => ['jwtauthmiddleware']], function () {
    // Common user route
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('role:user');
    Route::post('logout', [JwtAuthController::class, 'logout']);

    Route::post('refresh', [JwtAuthController::class, 'refresh']);
    Route::resource('/userprofiles', UserProfilesController::class);
    Route::post('/userprofiles/update/{id}', [UserProfilesController::class, 'update']);

    Route::resource('/patientprofiles', PatientProfilesController::class);

    Route::get('/appointments', [AppointmentsController::class, 'getAppointmentsByUser'])->name('appointments.get_appointments_by_user');
    Route::patch('/appointments/{appointment}', [AppointmentsController::class, 'update'])->name('appointments.update');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentsController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments', [AppointmentsController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentsController::class, 'show'])->name('appointments.show');

    Route::get('/profile', [UserProfilesController::class, 'index']);
    Route::post('/profile', [UserProfilesController::class, 'store']);
    Route::post('/profile/update/{id}', [UserProfilesController::class, 'update']);

    // patient_profile
    Route::get('/profile/patient/{id}/', [PatientProfilesController::class, 'getid']);
    Route::post('/profile/patient/create', [PatientProfilesController::class, 'store']);
    Route::put('/profile/patient/update/{id}', [PatientProfilesController::class, 'update']);
    Route::delete('/profile/patient/delete/{id}', [PatientProfilesController::class, 'destroy']);

    // get_booking from patient
    Route::get('/profile/patient/{id}/bookings',[AppointmentsController::class,'getBookings']);

    // Admin-only routes
    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'],  function () {
        // Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        // Route::apiResource('/admin/users', AdminUserController::class);

        // doctors
        Route::post('/doctors', [DoctorController::class, 'store']);
        Route::put('/doctors/{id}', [DoctorController::class, 'update']);
        Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);

        // deartment or specialization
        Route::get('/departments', [SpecializationsController::class, 'index']);
        Route::get('/departments/{department}', [SpecializationsController::class, 'show']);
        Route::get('/departments/{department}/doctors', [HomeController::class, 'doctorsOfDepartment']);
        Route::post('/departments', [SpecializationsController::class, 'store']);
        Route::put('/departments/{id}', [SpecializationsController::class, 'update']);
        Route::delete('/departments/{id}', [SpecializationsController::class, 'destroy']);
      
    }); 
   
    // get_doctor
    Route::resource('/doctorprofiles', DoctorProfilesController::class);

    // Route::delete('/admin/doctors/{id}',[DoctorProfilesController::class,'destroy']);
    Route::resource('/rooms',RoomsController::class);
    Route::resource('/schedules',SchedulesController::class);
    Route::resource('/doctorprofiles',DoctorProfilesController::class);
    Route::resource('/appointments',AppointmentsController::class);
    Route::resource('/doctorremarks',DoctorRemarksController::class);


    // Doctor-only routes
    Route::group(['middleware' => ['role:doctor'], 'prefix' => 'doctor/profile'], function () {
        // Route::post('/doctorprofiles/update/{id}', [DoctorProfilesController::class, 'update']);

        Route::get('/', [DoctorProfilesController::class, 'show'])->name('doctor.profile.index');
        Route::patch('/', [DoctorProfilesController::class, 'update'])->name('doctor.profile.update');
        Route::post('/', [DoctorProfilesController::class, 'store'])->name('doctor.profile.store');

        Route::get('/patients', [DoctorProfilesController::class, 'patients'])->name('doctor.profile.patients');
        Route::get('/patients/{patient}/appointments', [DoctorProfilesController::class, 'getPatientAppointments'])->name('doctor.profile.patients.appointments');
        Route::get('/patients/{patient}/appointments/{appointment}/schedule', [DoctorProfilesController::class, 'getAppointmentSchedule'])->name('doctor.profile.patients.appointments.schedule');

        Route::get('/appointments', [DoctorProfilesController::class, 'appointments'])->name('doctor.profile.appointments');

        Route::get('/schedules', [SchedulesController::class, 'getSchedulesForDoctor'])->name('doctor.profile.schedules.get_schedules_for_doctor');
        Route::get('/schedules/{schedule}', [SchedulesController::class, 'show'])->name('doctor.profile.schedules.show');
        Route::patch('/schedules/{schedule}', [SchedulesController::class, 'update'])->name('doctor.profile.schedules.update');
        Route::delete('/schedules/{id}', [SchedulesController::class, 'destroy'])->name('doctor.profile.schedules.destroy');
        Route::post('/schedules', [SchedulesController::class, 'store'])->name('doctor.profile.schedules.store');

        Route::get('/appointments/{appointment}/remark', [DoctorRemarksController::class, 'getAppointmentRemark'])->name('doctor.profile.appointments.remark');
        Route::patch('/appointments/{appointment}/remark', [DoctorRemarksController::class, 'update'])->name('doctor.profile.appointments.remark.update');
        Route::post('/appointments/{appointment}/remark', [DoctorRemarksController::class, 'store'])->name('doctor.profile.appointments.remark.store');
    });
});
