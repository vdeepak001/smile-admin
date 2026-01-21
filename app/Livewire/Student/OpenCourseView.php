<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Marks;

class OpenCourseView extends Component
{
    public $course;
    public $preTestMark;
    public $practiceTestMark;
    public $mock1TestMark;
    public $mock2TestMark;
    public $finalTestMark;
    
    public $preTestEnabled = true;
    public $practiceTestEnabled = true;
    public $mock1TestEnabled = false;
    public $mock2TestEnabled = false;
    public $finalTestEnabled = false;

    public function mount($course)
    {
        $this->course = Course::where('active_status', true)
            ->where('course_type', 'open')
            ->findOrFail($course);
        
        $this->loadTestMarks();
        $this->determineTestAvailability();
    }

    public function loadTestMarks()
    {
        $studentId = auth()->id();
        $courseId = $this->course->course_id;

        // Load marks for each test type
        $this->preTestMark = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', 'pre')
            ->whereNull('topic_id')
            ->first();

        $this->practiceTestMark = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', 'practice')
            ->whereNull('topic_id')
            ->first();

        $this->mock1TestMark = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', 'mock1')
            ->whereNull('topic_id')
            ->first();

        $this->mock2TestMark = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', 'mock2')
            ->whereNull('topic_id')
            ->first();

        $this->finalTestMark = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', 'final')
            ->whereNull('topic_id')
            ->first();
    }

    public function determineTestAvailability()
    {
        // Pre-Test is always available (optional)
        $this->preTestEnabled = true;

        // Practice Questions are always available
        $this->practiceTestEnabled = true;

        // Mock Test 1 is available after completing Practice Questions
        $this->mock1TestEnabled = $this->practiceTestMark !== null;

        // Mock Test 2 is available after completing Mock Test 1
        $this->mock2TestEnabled = $this->mock1TestMark !== null;

        // Final Test is available after completing all previous tests
        $this->finalTestEnabled = $this->practiceTestMark !== null 
            && $this->mock1TestMark !== null 
            && $this->mock2TestMark !== null;
    }

    public function render()
    {
        return view('livewire.student.open-course-view')->layout('layouts.app');
    }
}
