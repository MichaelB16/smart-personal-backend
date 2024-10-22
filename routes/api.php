<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('/login', 'login');
    Route::post('/oauth/google', 'loginGoogle');
});

Route::prefix('v1')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('students', StudentController::class)->except(['create', 'edit']);
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
