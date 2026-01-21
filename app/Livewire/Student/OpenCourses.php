<?php

namespace App\Livewire\Student;

use Livewire\Component;

class OpenCourses extends Component
{
    public function render()
    {
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

        return view('livewire.student.open-courses', compact('openCourses'))->layout('layouts.app');
    }
}
