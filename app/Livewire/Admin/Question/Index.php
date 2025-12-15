<?php

namespace App\Livewire\Admin\Question;

use App\Models\Question;
use App\Models\Course;
use App\Models\CourseTopic;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $courseFilter = '';
    public $topicFilter = '';
    public $typeFilter = '';
    public $levelFilter = '';
    public $sortField = 'inserted_on';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public ?Question $selectedQuestion = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'courseFilter' => ['except' => ''],
        'topicFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'levelFilter' => ['except' => ''],
        'sortField' => ['except' => 'inserted_on'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function viewQuestion($questionId)
    {
        $this->selectedQuestion = Question::with(['course', 'topic', 'insertedBy', 'updatedBy'])->findOrFail($questionId);
        $this->dispatch('open-modal', 'view-question-detail');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingCourseFilter()
    {
        $this->resetPage();
    }

    public function updatingTopicFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingLevelFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function toggleStatus($questionId)
    {
        $question = Question::findOrFail($questionId);
        $question->active_status = !$question->active_status;
        $question->save();

        $status = $question->active_status ? 'activated' : 'deactivated';
        $this->dispatch('toast-message', message: "Question {$status} successfully!", type: 'success');
    }

    public function render()
    {
        $query = Question::with(['course', 'topic']);

        // Apply search
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->where('question_text', 'like', '%' . $this->search . '%')
                  ->orWhereHas('course', function (Builder $courseQ) {
                      $courseQ->where('course_name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('topic', function (Builder $topicQ) {
                      $topicQ->where('topic_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply active status filter
        if ($this->filter === 'active') {
            $query->where('active_status', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('active_status', false);
        }

        // Apply course filter
        if ($this->courseFilter) {
            $query->where('course_id', $this->courseFilter);
        }

        // Apply topic filter
        if ($this->topicFilter) {
            $query->where('topic_id', $this->topicFilter);
        }

        // Apply type filter
        if ($this->typeFilter) {
            $query->where('question_type', $this->typeFilter);
        }

        // Apply level filter
        if ($this->levelFilter) {
            $query->where('level', $this->levelFilter);
        }

        // Apply sorting
        if (in_array($this->sortField, ['inserted_on', 'level', 'question_type'])) {
             $query->orderBy($this->sortField, $this->sortDirection);
        } else {
             $query->orderBy('inserted_on', 'desc');
        }

        $questions = $query->paginate($this->perPage);

        $totalCount = Question::count();
        $activeCount = Question::where('active_status', true)->count();
        $inactiveCount = Question::where('active_status', false)->count();

        $courses = Course::where('active_status', true)->orderBy('course_name')->get();
        $topics = CourseTopic::where('active_status', true)->orderBy('topic_name')->get();

        return view('livewire.admin.question.index', [
            'questions' => $questions,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'courses' => $courses,
            'topics' => $topics,
        ]);
    }
}
