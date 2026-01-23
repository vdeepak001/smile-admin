<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Marks;
use App\Models\CourseTopic;

class CourseReport extends Component
{
    public $course;
    public $preTestMark;
    public $topicMarks = [];
    public $practiceTestMark;
    public $mock1TestMark;
    public $mock2TestMark;
    public $finalTestMark;

    public function mount($course)
    {
        $this->course = Course::where('active_status', true)
            ->findOrFail($course);
        
        $this->loadTestMarks();
    }

    public function loadTestMarks()
    {
        $studentId = auth()->id();
        $courseId = $this->course->course_id;

        // Pre-Test
        $this->preTestMark = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', 'pre')
            ->whereNull('topic_id')
            ->first();

        // Final Test
        $this->finalTestMark = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', 'final')
            ->whereNull('topic_id')
            ->first();

        if ($this->course->course_type === 'college') {
            // Topic Tests
            $topics = CourseTopic::where('course_id', $courseId)
                ->where('active_status', true)
                ->get();

            foreach ($topics as $topic) {
                $mark = Marks::where('student_id', $studentId)
                    ->where('course_id', $courseId)
                    ->where('test_type', 'topic')
                    ->where('topic_id', $topic->topic_id)
                    ->first();

                if ($mark) {
                    $this->topicMarks[] = [
                        'topic' => $topic,
                        'mark' => $mark
                    ];
                }
            }
        } else {
            // Open Course - Mock Tests
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
        }
    }

    public function render()
    {
        return view('livewire.student.course-report')->layout('layouts.app');
    }
}
