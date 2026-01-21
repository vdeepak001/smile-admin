<?php

namespace App\Livewire\Student;

use Livewire\Component;

class CourseView extends Component
{
    public $course;
    public $preTestMark;
    public $finalTestMark;
    public $topics = [];
    public $preTestEnabled = false;
    public $topicsEnabled = false;
    public $finalTestEnabled = false;

    public function mount(\App\Models\Course $course)
    {
        if (!$course->active_status) {
            abort(404);
        }
        $this->course = $course;
        $this->loadProgress();
    }

    public function loadProgress()
    {
        $user = auth()->user();

        // 1. Check Pre-Test
        // Assuming Pre-Test is applicable if 'test_questions' > 0 defined in course
        // Or strictly if the user Requirement says "Pre-Test (If Applicable)" - we'll assume always applicable if questions exist?
        // For now, let's assume it's applicable if the Course has general questions.
        // But user said "Activate only when each are enabled for ex. If Pre-test is assigned".
        // Let's assume Pre-test is always Step 1.

         $this->preTestMark = \App\Models\Marks::where('student_id', $user->id)
            ->where('course_id', $this->course->course_id)
            ->where('test_type', 'pre')
            ->first();

        // Topics
        $this->topics = $this->course->topics()
            ->where('active_status', true)
            ->with(['questions', 'course']) // optimized
            ->get()
            ->map(function ($topic) use ($user) {
                $topic->mark = \App\Models\Marks::where('student_id', $user->id)
                    ->where('course_id', $this->course->course_id)
                    ->where('topic_id', $topic->topic_id)
                    ->where('test_type', 'topic')
                    ->first();
                return $topic;
            });
        
        // Final Test
        $this->finalTestMark = \App\Models\Marks::where('student_id', $user->id)
            ->where('course_id', $this->course->course_id)
            ->where('test_type', 'final')
            ->first();


        // Logic for Enabling
        $this->preTestEnabled = true; // Always open unless completed? Or stays open to view score?
        
        $preTestDone = $this->preTestMark != null;
        
        // Topics enabled only if Pre-Test done (or if Pre-Test not applicable - but we assume applicable for now based on flow)
        $this->topicsEnabled = $preTestDone;

        // Final Test enabled only if all topics completed
        $allTopicsCompleted = $this->topics->every(function ($topic) {
            return $topic->mark != null;
        });

        $this->finalTestEnabled = $preTestDone && $allTopicsCompleted;
    }

    public function render()
    {
        return view('livewire.student.course-view')->layout('layouts.app');
    }
}
