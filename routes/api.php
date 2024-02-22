<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::post('/user/logout-from-all-devices', [UserController::class, 'logoutFromAllDevices']);
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::post('/user/change-password', [UserController::class, 'changePassword']);
    Route::post('/user/admin-change-password', [UserController::class, 'adminChangePassword']);
    Route::post('/user/admin-delete-user', [UserController::class, 'adminDeleteUser']);
    
    
    Route::post('/create-role', [RoleController::class, 'createRole']);
});