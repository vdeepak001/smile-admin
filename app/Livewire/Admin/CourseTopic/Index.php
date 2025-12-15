<?php

namespace App\Livewire\Admin\CourseTopic;

use App\Models\CourseTopic;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $courseFilter = '';
    public $sortField = 'inserted_on';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public ?CourseTopic $selectedTopic = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'courseFilter' => ['except' => ''],
        'sortField' => ['except' => 'inserted_on'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function viewTopic($topicId)
    {
        $this->selectedTopic = CourseTopic::with(['course', 'insertedBy', 'updatedBy'])->findOrFail($topicId);
        $this->dispatch('open-modal', 'view-topic-detail');
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

    public function toggleStatus($topicId)
    {
        $topic = CourseTopic::findOrFail($topicId);
        $topic->active_status = !$topic->active_status;
        $topic->save();

        $status = $topic->active_status ? 'activated' : 'deactivated';
        $this->dispatch('toast-message', message: "Topic {$status} successfully!", type: 'success');
    }

    public function render()
    {
        $query = CourseTopic::with(['course']);

        // Apply search
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->where('topic_name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('course', function (Builder $courseQ) {
                      $courseQ->where('course_name', 'like', '%' . $this->search . '%');
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

        // Apply sorting
        if (in_array($this->sortField, ['inserted_on', 'topic_name'])) {
             $query->orderBy($this->sortField, $this->sortDirection);
        } else {
             $query->orderBy('inserted_on', 'desc');
        }

        $topics = $query->paginate($this->perPage);

        $totalCount = CourseTopic::count();
        $activeCount = CourseTopic::where('active_status', true)->count();
        $inactiveCount = CourseTopic::where('active_status', false)->count();

        $courses = Course::where('active_status', true)->orderBy('course_name')->get();

        return view('livewire.admin.course-topic.index', [
            'topics' => $topics,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'courses' => $courses,
        ]);
    }
}
