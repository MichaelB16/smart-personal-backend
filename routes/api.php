<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardStudentController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentEvaluationController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/oauth/google', 'loginGoogle');
    });

    Route::controller(UsersController::class)->group(function () {
        Route::post('personal/register', 'store');
    });

    Route::prefix('forgot_password')->group(function () {
        Route::post('verify', [ForgotPasswordController::class, 'forgotPassword']);
    });

    Route::prefix('new_password')->group(function () {
        Route::post('verify/{token}', [NewPasswordController::class, 'checkToken']);
        Route::put('update/{id}', [NewPasswordController::class, 'updatePassword']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::prefix('training')->group(function () {
            Route::get('pdf/{id}', [TrainingController::class, 'pdf']);
            Route::post('generate', [TrainingController::class, 'generateTraining']);
            Route::post('save', [TrainingController::class, 'saveTraining']);
        });

        Route::prefix('diet')->group(function () {
            Route::get('pdf/{id}', [DietController::class, 'pdf']);
            Route::post('generate', [DietController::class, 'generateDiet']);
            Route::post('save', [DietController::class, 'saveDiet']);
        });

        Route::apiResource('evaluations', EvaluationController::class)->only(['store', 'update', 'destroy']);

        Route::apiResource('student/evaluations', StudentEvaluationController::class)->only(['index']);

        Route::apiResource('settings', SettingController::class)->only(['index', 'store']);

        Route::apiResource('students', StudentsController::class)->except(['create', 'edit']);

        Route::apiResource('messages', MessagesController::class)->only(['index', 'store']);

        Route::apiResource('users', UsersController::class)->only(['destroy', 'update', 'show', 'store']);

        Route::prefix('dashboard')->group(function () {
            Route::get('summary', [DashboardController::class, 'summary']);
            Route::get('students', [DashboardStudentController::class, 'index']);
        });
    });
});
