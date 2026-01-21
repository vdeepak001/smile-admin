<?php

namespace App\Livewire\Student;

use Livewire\Component;

class MyCourses extends Component
{
    public function render()
    {
        // Fetch college courses
        $collegeCourses = \App\Models\AssignedCourse::where('student_id', auth()->id())
            ->where(function($q) {
                $q->where('valid_until', '>=', now())
                  ->orWhereNull('valid_until');
            })
            ->whereHas('course', function($q) {
                $q->where('course_type', 'college')
                  ->where('active_status', true);
            })
            ->with(['course' => function($query) {
                $query->with(['marks' => function($q) {
                    $q->where('student_id', auth()->id());
                }]);
            }])
            ->get();

        // Fetch open courses (assigned to student)
        $openCourses = \App\Models\AssignedCourse::where('student_id', auth()->id())
            ->where(function($q) {
                $q->where('valid_until', '>=', now())
                  ->orWhereNull('valid_until');
            })
            ->whereHas('course', function($q) {
                $q->where('course_type', 'open')
                  ->where('active_status', true);
            })
            ->with(['course' => function($query) {
                $query->with(['marks' => function($q) {
                    $q->where('student_id', auth()->id());
                }]);
            }])
            ->get();

        return view('livewire.student.my-courses', compact('collegeCourses', 'openCourses'))->layout('layouts.app');
    }
}
