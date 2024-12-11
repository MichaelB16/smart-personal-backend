<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('/login', 'login');
    Route::post('/oauth/google', 'loginGoogle');
    Route::get('/test', 'sendEmail');
});

Route::prefix('v1')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::prefix('students')->name('students.')->group(function () {
        Route::apiResource('', StudentController::class)->except(['create', 'edit']);
        Route::get('summary', [StudentController::class, 'summary']);
    });
})->middleware('auth:sanctum');

