<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/users', function () {
        return view('index');
    })->name('users');
});
