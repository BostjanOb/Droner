<?php

use App\Http\Controllers\BuildController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

//Route::resource('token', TokenController::class)->only(['index', 'store']);

//Route::middleware('auth:sanctum')->group(function () {
//    Route::apiResource('repositories', RepositoryController::class)->except(['store']);
//    Route::resource('repositories.builds', BuildController::class)->only(['index', 'store', 'show']);
//});
