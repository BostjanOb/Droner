<?php

use App\Http\Controllers\RepositoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('repositories', RepositoryController::class)->except(['store']);
});
