<?php

use Illuminate\Support\Facades\Route;

Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    // Course Routes
    Route::get('/my-courses', \App\Livewire\Student\MyCourses::class)->name('student.my-courses');
    Route::get('/open-courses', \App\Livewire\Student\OpenCourses::class)->name('student.open-courses');
    Route::get('/my-courses/{course}', \App\Livewire\Student\CourseView::class)->name('student.course.show');
    Route::get('/open-courses/{course}', \App\Livewire\Student\OpenCourseView::class)->name('student.open-course.show');
    Route::get('/test/take/{test_type}/{context_id}', \App\Livewire\Student\TestPlayer::class)->name('student.test.take');
    
    // Reports Routes
    Route::get('/my-reports', \App\Livewire\Student\MyReports::class)->name('student.my-reports');
    Route::get('/my-reports/{course}', \App\Livewire\Student\CourseReport::class)->name('student.course-report');
    Route::get('/my-reports/{course}/{test_type}/{topic_id?}', \App\Livewire\Student\TestReport::class)->name('student.test-report');
    
    // Resume Route
    Route::get('/my-resume', \App\Livewire\Student\MyResume::class)->name('student.my-resume');
});

