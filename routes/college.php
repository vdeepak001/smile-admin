<?php

use Illuminate\Support\Facades\Route;

Route::prefix('college')->middleware(['auth', 'role:college'])->group(function () {
    Route::get('/dashboard', function () {
        return view('college.dashboard');
    })->name('college.dashboard');
});

