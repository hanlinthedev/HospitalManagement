<?php

use App\Http\Controllers\Api\UserProfilesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

