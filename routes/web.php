<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes(['register' => false, 'confirm' => false, 'reset' => false]);
});

Route::middleware(['auth'])->group(function () {
    Route::livewire('/', 'repository.index')
        ->name('index');

    Route::livewire('/repo/{repo}', 'repository.show')
        ->name('repo.show');

    Route::livewire('/repo/{repo}/edit', 'repository.edit')
        ->name('repo.edit');
});
