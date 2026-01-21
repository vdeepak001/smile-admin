<?php

namespace App\Livewire\Student;

use Livewire\Component;

class MyCourses extends Component
{
    public function render()
    {
        $assignedCourses = \App\Models\AssignedCourse::where('student_id', auth()->id())
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

        return view('livewire.student.my-courses', compact('assignedCourses'))->layout('layouts.app');
    }
}
