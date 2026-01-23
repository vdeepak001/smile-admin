<?php

namespace App\Livewire\Student;

use Livewire\Component;

class TestPlayer extends Component
{
    public $testType;
    public $contextId; // course_id or topic_id
    public \App\Models\Course $course;
    public ?\App\Models\CourseTopic $topic = null;
    
    protected $questions = null;
    public $currentQuestionIndex = 0;
    public $answers = []; // [question_id => selected_choice]
    public $isFinished = false;
    public $score = 0;
    public $totalQuestionsCount = 0;
    public $correctAnswersCount = 0;
    public $wrongAnswersCount = 0;
    public $questionIds = [];
    
    // Timer properties
    public $testStartTime;
    public $testDuration; // in minutes
    public $timeRemaining; // in seconds
    
    // Per-question timer properties (for topic tests)
    public $questionStartTime; // timestamp when current question was started
    public $questionTimers = []; // [question_id => time_in_seconds]
    public $currentQuestionTime = 0; // current question elapsed time in seconds

    public function mount($test_type, $context_id)
    {
        $this->testType = $test_type;
        $this->contextId = $context_id;

        $this->loadQuestions();
        $this->initializeTimer();
        $this->startQuestionTimer();
    }

    public function initializeTimer()
    {
        // Set test duration based on test type
        // Default durations (in minutes)
        $durations = [
            'pre' => 15,
            'topic' => 10,
            'practice' => 30,
            'mock1' => 45,
            'mock2' => 45,
            'final' => 60,
        ];

        $this->testDuration = $durations[$this->testType] ?? 30;
        // Store as timestamp string to persist across Livewire requests
        $this->testStartTime = now()->toDateTimeString();
        $this->calculateTimeRemaining();
    }

    public function calculateTimeRemaining()
    {
        if ($this->isFinished) {
            $this->timeRemaining = 0;
            return;
        }

        // Calculate elapsed time using timestamps
        $startTimestamp = strtotime($this->testStartTime);
        $currentTimestamp = time();
        $elapsedSeconds = $currentTimestamp - $startTimestamp;
        
        $totalSeconds = $this->testDuration * 60;
        $this->timeRemaining = max(0, $totalSeconds - $elapsedSeconds);

        // Auto-submit if time is up
        if ($this->timeRemaining <= 0) {
            $this->submitTest();
        }
    }

    public function loadQuestions()
    {
        if ($this->testType === 'topic') {
            $this->topic = \App\Models\CourseTopic::where('active_status', true)->findOrFail($this->contextId);
            $this->course = $this->topic->course;
            
            if (!$this->course->active_status) {
                 abort(404);
            }
            
            // For topic test, take ALL questions from the topic (no limit)
            $this->questionIds = \App\Models\Question::where('topic_id', $this->contextId)
                ->inRandomOrder()
                ->pluck('question_id')
                ->toArray();
                 
                
        } else {
            // Pre, Final, Practice, Mock1, Mock2 Tests
            $this->course = \App\Models\Course::where('active_status', true)->findOrFail($this->contextId);
            
            // Limit logic: 
            // Pre-Test: Always 10 random questions
            // Practice: All questions or use course setting
            // Mock1, Mock2: Use course setting or default to 10
            // Final Test: Use batch setting or course setting or default to 10
            
            if ($this->testType === 'pre') {
                $limit = 10;
            } elseif ($this->testType === 'practice') {
                // For practice, use course setting or default to 20 questions
                $limit = ($this->course->test_questions > 0) ? $this->course->test_questions : 20;
            } elseif (in_array($this->testType, ['mock1', 'mock2'])) {
                // For mock tests, use course setting or default to 10
                $limit = ($this->course->test_questions > 0) ? $this->course->test_questions : 10;
            } else {
                // Final test - use batch-based count
                $limit = $this->getBatchFinalTestCount();
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

    protected function getBatchFinalTestCount()
    {
        $user = auth()->user();
        $student = $user->student;
        
        if (!$student) {
            // Not a student, use course default
            return $this->course->test_questions > 0 ? $this->course->test_questions : 10;
        }
        
        // Find batch that includes this course
        $batch = $student->batches()
            ->where('active_status', true)
            ->get()
            ->first(function ($batch) {
                return in_array($this->course->course_id, $batch->courses ?? []);
            });
        
        if ($batch && $batch->final_test_questions_count > 0) {
            return $batch->final_test_questions_count;
        }
        
        // Fall back to course setting or default
        return $this->course->test_questions > 0 ? $this->course->test_questions : 10;
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

    public function selectAnswer($questionId, $option)
    {
        // Just store the selected answer without validation
        $this->answers[$questionId] = $option;
    }
    
    public function startQuestionTimer()
    {
        if ($this->testType === 'topic' && !empty($this->questionIds)) {
            $currentQuestionId = $this->questionIds[$this->currentQuestionIndex] ?? null;
            if ($currentQuestionId) {
                // Store current timestamp
                $this->questionStartTime = now()->timestamp;
                // Initialize timer for this question if not exists
                if (!isset($this->questionTimers[$currentQuestionId])) {
                    $this->questionTimers[$currentQuestionId] = 0;
                }
            }
        }
    }
    
    public function pauseQuestionTimer()
    {
        if ($this->testType === 'topic' && $this->questionStartTime && !empty($this->questionIds)) {
            $currentQuestionId = $this->questionIds[$this->currentQuestionIndex] ?? null;
            if ($currentQuestionId) {
                // Calculate elapsed time since question started
                $elapsed = now()->timestamp - $this->questionStartTime;
                // Add to accumulated time for this question
                if (!isset($this->questionTimers[$currentQuestionId])) {
                    $this->questionTimers[$currentQuestionId] = 0;
                }
                $this->questionTimers[$currentQuestionId] += $elapsed;
                // Reset start time
                $this->questionStartTime = null;
            }
        }
    }
    
    public function updateCurrentQuestionTime()
    {
        if ($this->testType === 'topic' && $this->questionStartTime && !empty($this->questionIds)) {
            $currentQuestionId = $this->questionIds[$this->currentQuestionIndex] ?? null;
            if ($currentQuestionId) {
                // Calculate current elapsed time
                $elapsed = now()->timestamp - $this->questionStartTime;
                $accumulated = $this->questionTimers[$currentQuestionId] ?? 0;
                $this->currentQuestionTime = $accumulated + $elapsed;
            }
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->pauseQuestionTimer();
            $this->currentQuestionIndex--;
            $this->startQuestionTimer();
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->totalQuestionsCount - 1) {
            $this->pauseQuestionTimer();
            $this->currentQuestionIndex++;
            $this->startQuestionTimer();
        }
    }

    public function submitTest()
    {
        // Pause the current question timer before finishing
        $this->pauseQuestionTimer();
        $this->finishTest();
    }

    public function finishTest()
    {
        // Ensure questions are loaded before scoring and saving
        if (empty($this->questions)) {
            $this->loadQuestionsFromIds();
        }

        $this->isFinished = true;
        $this->calculateScore();
        $this->saveMarks();
        $this->saveAnsweredQuestions();
    }

    public function saveAnsweredQuestions()
    {
        try {
            // Delete previous attempts for this test to avoid duplicates
            \App\Models\Answered::where('user_id', auth()->id())
                ->where('course_id', $this->course->course_id)
                ->where('test_type', $this->testType)
                ->when($this->testType === 'topic', function($query) {
                    return $query->where('topic_id', $this->topic->topic_id);
                })
                ->delete();

            // Save all answered questions to the database
            foreach ($this->answers as $questionId => $option) {
                $question = \App\Models\Question::find($questionId);
                if (!$question) continue;
                
                $isCorrect = $question->right_answer == $option;
                $sequence = array_search($questionId, $this->questionIds) + 1;
                
                // Get time taken for this question (for topic tests)
                $timeTaken = $this->questionTimers[$questionId] ?? 0;

                \App\Models\Answered::create([
                    'user_id' => auth()->id(),
                    'course_id' => $this->course->course_id,
                    'topic_id' => $question->topic_id,
                    'question_id' => $questionId,
                    'test_type' => $this->testType,
                    'sequence' => $sequence,
                    'answered_choice' => (string)$option,
                    'answered_status' => $isCorrect ? 'correct' : 'incorrect',
                    'time_taken' => $timeTaken,
                    'answered_date' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error saving answered questions: ' . $e->getMessage());
            // Continue anyway to show completion screen
        }
    }

    public function calculateScore()
    {
        $this->correctAnswersCount = 0;
        $allQuestions = \App\Models\Question::whereIn('question_id', $this->questionIds)->get();
        
        foreach ($allQuestions as $question) {
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
        ])->layout('layouts.fullscreen');
    }
}
