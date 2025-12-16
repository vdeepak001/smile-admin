<?php
use App\Http\Controllers\Admin\CollegeInfoController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseTopicController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        $totalColleges = \App\Models\CollegeInfo::where('active_status', true)->count();
        $activeCourses = \App\Models\Course::where('active_status', true)->count();
        $totalUsers = \App\Models\User::count();
        $completedCourses = \App\Models\AssignedCourse::where('completion_status', 'completed')->count();
        $totalStudents = \App\Models\Student::where('active_status', true)->count();
        $totalQuestions = \App\Models\Question::where('active_status', true)->count();
        
        return view('admin.dashboard', compact('totalColleges', 'activeCourses', 'totalUsers', 'completedCourses', 'totalStudents', 'totalQuestions'));
    })->name('admin.dashboard');

    // College Info Routes
    Route::resource('college-info', CollegeInfoController::class);
    Route::post('college-info/{collegeInfo}/restore', [CollegeInfoController::class, 'restore'])->name('college-info.restore');
    Route::delete('college-info/{collegeInfo}/force-delete', [CollegeInfoController::class, 'forceDelete'])->name('college-info.force-delete');

    // Course Routes
    Route::resource('courses', CourseController::class);
    Route::post('courses/{course}/restore', [CourseController::class, 'restore'])->name('courses.restore');
    Route::delete('courses/{course}/force-delete', [CourseController::class, 'forceDelete'])->name('courses.force-delete');

    // Course Topics Routes
    Route::resource('course-topics', CourseTopicController::class);
    Route::post('course-topics/{courseTopic}/restore', [CourseTopicController::class, 'restore'])->name('course-topics.restore');
    Route::delete('course-topics/{courseTopic}/force-delete', [CourseTopicController::class, 'forceDelete'])->name('course-topics.force-delete');

    // Student Routes
    Route::resource('students', StudentController::class);
    Route::get('students/{student}/courses', [StudentController::class, 'showCourses'])->name('students.courses');
    Route::get('students-import/form', [StudentController::class, 'showImport'])->name('students.import.form');
    Route::post('students-import/process', [StudentController::class, 'importBulk'])->name('students.import');
    Route::post('students/{student}/restore', [StudentController::class, 'restore'])->name('students.restore');
    Route::delete('students/{student}/force-delete', [StudentController::class, 'forceDelete'])->name('students.force-delete');

    // Degree Routes
    Route::resource('degrees', \App\Http\Controllers\Admin\DegreeController::class);

    // Question Routes
    Route::resource('questions', QuestionController::class);
    Route::post('questions/{question}/restore', [QuestionController::class, 'restore'])->name('questions.restore');
    Route::delete('questions/{question}/force-delete', [QuestionController::class, 'forceDelete'])->name('questions.force-delete');

    // Placeholder routes for sidebar
    Route::get('users', fn() => view('admin.users.index'))->name('users.index');
});

