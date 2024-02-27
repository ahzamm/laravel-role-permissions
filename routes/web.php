<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/admin/login', function () {
    return view('login');
})->name('login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('manage-users');
});
