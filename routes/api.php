<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api', 'role'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    // Tasks
    Route::middleware(['manager'])->prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('/{id}', [TaskController::class, 'show']);
        Route::put('/{id}', [TaskController::class, 'update']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
    });
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->middleware('customer');

    // Users
    Route::middleware(['manager'])->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/{id}/toggle-availability', [UserController::class, 'toggleAvailability']);
    });

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
});
