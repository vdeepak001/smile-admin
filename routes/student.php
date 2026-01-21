<?php

use Illuminate\Support\Facades\Route;

Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    // Course Routes
    Route::get('/my-courses', \App\Livewire\Student\MyCourses::class)->name('student.my-courses');
    Route::get('/my-courses/{course}', \App\Livewire\Student\CourseView::class)->name('student.course.show');
    Route::get('/test/take/{test_type}/{context_id}', \App\Livewire\Student\TestPlayer::class)->name('student.test.take');
});

