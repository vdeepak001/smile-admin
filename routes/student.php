<?php

use Illuminate\Support\Facades\Route;

Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

