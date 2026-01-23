<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Marks;

class MyReports extends Component
{
    public function render()
    {
        $studentId = auth()->id();

        // Get all courses where student has completed at least one test
        $courseIds = Marks::where('student_id', $studentId)
            ->distinct()
            ->pluck('course_id');

        $courses = Course::whereIn('course_id', $courseIds)
            ->where('active_status', true)
            ->with(['marks' => function($query) use ($studentId) {
                $query->where('student_id', $studentId);
            }])
            ->get()
            ->map(function($course) {
                // Calculate overall statistics
                $marks = $course->marks;
                $totalTests = $marks->count();
                $averageScore = $marks->avg('percentage');
                $highestScore = $marks->max('percentage');
                
                $course->total_tests = $totalTests;
                $course->average_score = round($averageScore, 1);
                $course->highest_score = $highestScore;
                $course->latest_completion_at = $marks->max('completed_at');
                
                return $course;
            });

        return view('livewire.student.my-reports', compact('courses'))->layout('layouts.app');
    }
}
