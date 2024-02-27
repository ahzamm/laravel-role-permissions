<?php

use Illuminate\Support\Facades\Route;



Route::get('/admin/login', function () {
    return view('login');
});
