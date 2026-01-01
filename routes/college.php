<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\College\StudentController;

Route::prefix('college')->middleware(['auth', 'role:college'])->group(function () {
    Route::get('/dashboard', function () {
        return view('college.dashboard');
    })->name('college.dashboard');

    // College Students Management
    Route::get('/students', function () {
        return view('college.students.index');
    })->name('college.students.index');

    Route::get('/students/{student}', [StudentController::class, 'show'])->name('college.students.show');

    // Edit access removed for college dashboard
    // Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('college.students.edit');
    // Route::put('/students/{student}', [StudentController::class, 'update'])->name('college.students.update');

    // College Course Reports
    Route::get('/course-reports', function () {
        return view('college.course-reports.index');
    })->name('college.course-reports.index');
});

