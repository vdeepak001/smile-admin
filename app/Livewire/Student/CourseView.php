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
    
    // Batch type properties
    public $batchType = 3; // Default to Type 3 (all tests)
    public $showPreTest = true;
    public $showTopicTests = true;
    public $showFinalTest = true;

    public function mount(\App\Models\Course $course)
    {
        if (!$course->active_status) {
            abort(404);
        }
        $this->course = $course;
        $this->determineBatchType();
        $this->loadProgress();
    }

    protected function determineBatchType()
    {
        $user = auth()->user();
        
        // Get student record
        $student = $user->student;
        
        if (!$student) {
            // Not a student, default to Type 3 (show all tests)
            $this->batchType = 3;
            $this->setTestVisibility();
            return;
        }
        
        // Find batch that includes this course
        $batch = $student->batches()
            ->where('active_status', true)
            ->get()
            ->first(function ($batch) {
                return in_array($this->course->course_id, $batch->courses ?? []);
            });
        
        if ($batch) {
            $this->batchType = (int) $batch->batch_type;
        } else {
            // No batch assigned, default to Type 3 (show all tests)
            $this->batchType = 3;
        }
        
        $this->setTestVisibility();
    }

    protected function setTestVisibility()
    {
        switch ($this->batchType) {
            case 1: // Type 1: Only Final Test
                $this->showPreTest = false;
                $this->showTopicTests = false;
                $this->showFinalTest = true;
                break;
            
            case 2: // Type 2: Topic-wise Test & Final Test
                $this->showPreTest = false;
                $this->showTopicTests = true;
                $this->showFinalTest = true;
                break;
            
            case 3: // Type 3: Pre-Test, Topic-wise Test & Final Test
            default:
                $this->showPreTest = true;
                $this->showTopicTests = true;
                $this->showFinalTest = true;
                break;
        }
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


        // Logic for Enabling based on batch type
        $preTestDone = $this->preTestMark != null;
        
        // All topics completed
        $allTopicsCompleted = $this->topics->every(function ($topic) {
            return $topic->mark != null;
        });
        
        switch ($this->batchType) {
            case 1: // Type 1: Only Final Test - available immediately
                $this->preTestEnabled = false;
                $this->topicsEnabled = false;
                $this->finalTestEnabled = true;
                break;
            
            case 2: // Type 2: Topic-wise Test & Final Test
                $this->preTestEnabled = false;
                $this->topicsEnabled = true; // Topics always enabled
                $this->finalTestEnabled = $allTopicsCompleted; // Final enabled after all topics
                break;
            
            case 3: // Type 3: Pre-Test, Topic-wise Test & Final Test (sequential)
            default:
                $this->preTestEnabled = true; // Pre-test always available
                $this->topicsEnabled = $preTestDone; // Topics unlock after pre-test
                $this->finalTestEnabled = $preTestDone && $allTopicsCompleted; // Final after all
                break;
        }
    }

    public function render()
    {
        return view('livewire.student.course-view')->layout('layouts.app');
    }
}
