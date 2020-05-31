<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/repo/{id}', function ($id) {
        return view('repo.show');
    })->name('repo.show');

    Route::get('/users', function () {
        return view('index');
    })->name('users');
});
