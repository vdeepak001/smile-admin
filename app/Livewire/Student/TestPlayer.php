<?php

namespace App\Livewire\Student;

use Livewire\Component;

class TestPlayer extends Component
{
    public $testType;
    public $contextId; // course_id or topic_id
    public $course;
    public $topic;
    
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $answers = []; // [question_id => selected_choice]
    public $isFinished = false;
    public $score = 0;
    public $totalQuestionsCount = 0;
    public $correctAnswersCount = 0;
    public $wrongAnswersCount = 0;
    public $currentQuestionStartTime;
    public $selectedOption = null;
    public $optionStatus = null; // 'correct' or 'wrong'
    public $questionIds = [];

    public function mount($test_type, $context_id)
    {
        $this->testType = $test_type;
        $this->contextId = $context_id;

        $this->currentQuestionStartTime = now();
        $this->loadQuestions();
    }

    public function loadQuestions()
    {
        if ($this->testType === 'topic') {
            $this->topic = \App\Models\CourseTopic::where('active_status', true)->findOrFail($this->contextId);
            $this->course = $this->topic->course;
            
            if (!$this->course->active_status) {
                 abort(404);
            }
            
            // For topic test, take all questions in random order
            $this->questionIds = \App\Models\Question::where('topic_id', $this->contextId)
                ->inRandomOrder()
                ->limit(10)
                ->pluck('question_id')
                ->toArray();
                 
                
        } else {
            // Pre or Final Test
            $this->course = \App\Models\Course::where('active_status', true)->findOrFail($this->contextId);
            
            // Limit logic: 
            // Pre-Test: Always 10 random questions (User Requirement)
            // Final Test: Use logic from course setting, or default to 10
            
            if ($this->testType === 'pre') {
                $limit = 10;
            } else {
                 $limit = ($this->course->test_questions > 0) ? $this->course->test_questions : 10;
            }
            
            $this->questionIds = \App\Models\Question::where('course_id', $this->course->course_id)
                ->inRandomOrder()
                ->limit($limit)
                ->pluck('question_id')
                ->toArray();
        }

        $this->totalQuestionsCount = count($this->questionIds);
        
        if ($this->totalQuestionsCount === 0) {
            // Handle case with no questions
             session()->flash('error', 'No questions available for this test.');
             return redirect()->route('student.course.show', $this->course->course_id);
        }
    }

    public function loadQuestionsFromIds()
    {
        $this->questions = \App\Models\Question::whereIn('question_id', $this->questionIds)
            ->get()
            ->sortBy(function($model) {
                return array_search($model->question_id, $this->questionIds);
            })
            ->values();
        
        $this->totalQuestionsCount = $this->questions->count();
    }

    public function submitAnswer($questionId, $option)
    {
        if ($this->selectedOption !== null) {
            return;
        }

        $timeTaken = now()->diffInSeconds($this->currentQuestionStartTime);
        $this->currentQuestionStartTime = now();
        $this->answers[$questionId] = $option;
        
        // Save to DB immediately as requested
        $question = $this->questions->find($questionId);
        $isCorrect = $question->right_answer == $option;

        $this->selectedOption = $option;
        $this->optionStatus = $isCorrect ? 'correct' : 'incorrect';

        \App\Models\Answered::create([
            'user_id' => auth()->id(),
            'course_id' => $this->course->course_id,
            'topic_id' => $question->topic_id,
            'question_id' => $questionId,
            'test_type' => $this->testType,
            'sequence' => $this->currentQuestionIndex + 1,
            'answered_choice' => (string)$option,
            'answered_status' => $this->optionStatus,
            'time_taken' => max(0, $timeTaken), 
            'answered_date' => now(),
        ]);

        $this->dispatch('answer-submitted');
    }

    public function nextQuestion()
    {
        $this->selectedOption = null;
        $this->optionStatus = null;

        if ($this->currentQuestionIndex < $this->totalQuestionsCount - 1) {
            $this->currentQuestionIndex++;
        } else {
            $this->finishTest();
        }
    }

    public function finishTest()
    {
        $this->isFinished = true;
        $this->calculateScore();
        $this->saveMarks();
    }

    public function calculateScore()
    {
        $this->correctAnswersCount = 0;
        foreach ($this->questions as $question) {
            if (isset($this->answers[$question->question_id])) {
                if ($this->answers[$question->question_id] == $question->right_answer) {
                    $this->correctAnswersCount++;
                }
            }
        }
        $this->wrongAnswersCount = $this->totalQuestionsCount - $this->correctAnswersCount;
        $this->score = ($this->totalQuestionsCount > 0) ? round(($this->correctAnswersCount / $this->totalQuestionsCount) * 100) : 0;
    }

    public function saveMarks()
    {
        // Don't overwrite if already taken? Or allow retake?
        // User requirements imply flow: Pre (once) -> Topic (once?) -> Final.
        // Usually we save every attempt or just the latest.
        // Models structure `Marks` seems to imply one record per user/course/test_type?
        // But `Marks` has no unique constraint logic visible here.
        // I will use updateOrCreate to keep one record per type, or create new.
        // Let's create new or update existing. Ideally update if improvements logic needed, but standard LMS often keeps history. 
        // Given the requirement "Show his Pre-test score", assuming single entry is simpler for now.

        // Note: Marks table has `topic_id`.
        
        \App\Models\Marks::updateOrCreate(
            [
                'student_id' => auth()->id(),
                'course_id' => $this->course->course_id,
                'test_type' => $this->testType,
                'topic_id' => $this->testType === 'topic' ? $this->topic->topic_id : null,
            ],
            [
                'total_questions' => $this->totalQuestionsCount,
                'answered_questions' => count($this->answers),
                'correct_answer' => $this->correctAnswersCount,
                'wrong_answer' => $this->wrongAnswersCount,
                'percentage' => $this->score,
                'completed_on' => now()->toDateString(),
                'completed_at' => now(),
            ]
        );
    }
    
    public function render()
    {
        if (empty($this->questions) && !empty($this->questionIds)) {
            $this->loadQuestionsFromIds();
        }

        return view('livewire.student.test-player', [
            'currentQuestion' => $this->questions[$this->currentQuestionIndex] ?? null
        ])->layout('layouts.app');
    }
}
