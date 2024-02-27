<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/admin/login', function () {
    return view('login');
});
Route::post('/admin/login', [AdminController::class, 'login']);

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
