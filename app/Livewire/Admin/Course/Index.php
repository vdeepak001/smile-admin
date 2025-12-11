<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortField = 'inserted_on';
    public $sortDirection = 'desc';
    public $perPage = 6;
    public ?Course $selectedCourse = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'inserted_on'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function viewCourse($courseId)
    {
        $this->selectedCourse = Course::with(['insertedBy'])->findOrFail($courseId);
        $this->dispatch('open-modal', 'view-course-detail');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSortField()
    {
        $this->resetPage();
    }

    public function updatingSortDirection()
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

    public function toggleStatus($courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->active_status = !$course->active_status;
        $course->save();

        $status = $course->active_status ? 'activated' : 'deactivated';
        $this->dispatch('toast-message', message: "Course {$status} successfully!", type: 'success');
    }

    public function render()
    {
        $query = Course::with(['insertedBy']);

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('course_name', 'like', '%' . $this->search . '%')
                    ->orWhere('course_code', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filter
        if ($this->filter === 'active') {
            $query->where('active_status', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('active_status', false);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $courses = $query->paginate($this->perPage);

        // Get counts for filters (respecting search)
        $baseQuery = Course::query();
        if ($this->search) {
            $baseQuery->where(function ($q) {
                $q->where('course_name', 'like', '%' . $this->search . '%')
                    ->orWhere('course_code', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $totalCount = $baseQuery->count();
        $activeCount = (clone $baseQuery)->where('active_status', true)->count();
        $inactiveCount = (clone $baseQuery)->where('active_status', false)->count();

        return view('livewire.admin.course.index', [
            'courses' => $courses,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }
}
