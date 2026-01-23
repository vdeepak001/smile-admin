<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Marks;
use App\Models\Answered;
use App\Models\CourseTopic;

class TestReport extends Component
{
    public $course;
    public $topic;
    public $testType;
    public $topicId;
    public $mark;
    public $answeredQuestions = [];
    public $questionsToShow = 10; // Number of questions to display
    public $currentPage = 1;
    public $reportAvailable = false;
    public $timeUntilAvailable = null;

    public function mount($course, $test_type, $topic_id = null)
    {
        $this->course = Course::where('active_status', true)
            ->findOrFail($course);
        
        $this->testType = $test_type;
        $this->topicId = $topic_id;

        if ($topic_id) {
            $this->topic = CourseTopic::findOrFail($topic_id);
        }

        $this->loadTestData();
    }

    public function loadTestData()
    {
        $studentId = auth()->id();
        $courseId = $this->course->course_id;

        // Load marks
        $query = Marks::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('test_type', $this->testType);

        if ($this->topicId) {
            $query->where('topic_id', $this->topicId);
        } else {
            $query->whereNull('topic_id');
        }

        $this->mark = $query->first();

        if (!$this->mark) {
            abort(404, 'Test report not found');
        }

        // Check if report is available (1 hour after completion)
        $this->checkReportAvailability();

        if ($this->reportAvailable) {
            // Load answered questions with question details
            $answeredQuery = Answered::where('user_id', $studentId)
                ->where('course_id', $courseId)
                ->where('test_type', $this->testType)
                ->with('question');

            if ($this->topicId) {
                $answeredQuery->where('topic_id', $this->topicId);
            }

            $this->answeredQuestions = $answeredQuery
                ->orderBy('sequence')
                ->get();
        }
    }

    public function checkReportAvailability()
    {
        if (!$this->mark || !$this->mark->completed_at) {
            $this->reportAvailable = false;
            return;
        }

        $completedAt = $this->mark->completed_at;
        $now = now();
        $hoursSinceCompletion = $completedAt->diffInHours($now);
        
        // Report available after 1 hour
        if ($hoursSinceCompletion >= 1) {
            $this->reportAvailable = true;
            $this->timeUntilAvailable = null;
        } else {
            $this->reportAvailable = false;
            $minutesRemaining = 60 - $completedAt->diffInMinutes($now);
            $this->timeUntilAvailable = $minutesRemaining;
        }
    }

    public function loadMore()
    {
        $this->currentPage++;
        $this->questionsToShow = $this->currentPage * 10;
    }

    public function getVisibleQuestionsProperty()
    {
        return $this->answeredQuestions->take($this->questionsToShow);
    }

    public function getHasMoreQuestionsProperty()
    {
        return $this->answeredQuestions->count() > $this->questionsToShow;
    }

    public function render()
    {
        return view('livewire.student.test-report')->layout('layouts.app');
    }
}
