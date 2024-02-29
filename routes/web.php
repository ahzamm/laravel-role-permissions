<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAPIController;


Route::get('/admin/login', function () {
    return view('login');
})->name('login');
Route::post('/admin/login', [AdminAPIController::class, 'login']);

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/admin/manage-users', [AdminAPIController::class, 'manageUsers'])->name('manage-users');

Route::middleware('auth:sanctum')->group(function () {

    // Route::get('/admin/create-user',  [AdminController::class, 'createUser'])->name('createUser');
});
