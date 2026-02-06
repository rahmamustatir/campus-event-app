<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route ini otomatis akan punya awalan "/api"
Route::post('/send-otp', [AuthController::class, 'sendOtp']);