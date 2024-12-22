<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('/login', 'login');
    Route::post('/oauth/google', 'loginGoogle');
});

Route::prefix('v1')->group(function () {
    Route::post('add/personal', [UserController::class, 'store']);
});

Route::prefix('v1')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('students')->group(function () {
        Route::apiResource('', StudentController::class)->except(['create', 'edit']);
    });

    Route::prefix('user')->group(function () {
        Route::apiResource('', UserController::class)->except(['create', 'edit']);
    });

    Route::prefix('dashboard')->group(function() {
        Route::get('summary', [DashboardController::class, 'summary']);
    });

})->middleware('auth:sanctum');

