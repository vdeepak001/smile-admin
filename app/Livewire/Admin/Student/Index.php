<?php

namespace App\Livewire\Admin\Student;

use App\Models\Student;
use App\Models\CollegeInfo; // For filtering if needed
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $selectedCollege = '';
    public ?Student $selectedStudent = null;
    public $assignedCourses = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'selectedCollege' => ['except' => ''],
    ];

    public function viewStudent($studentId)
    {
        $this->selectedStudent = Student::with(['user', 'user.college', 'createdBy', 'updatedBy'])->findOrFail($studentId);
        $this->dispatch('open-modal', 'view-student-detail');
    }

    public function viewCourses($studentId)
    {
        $student = Student::with(['user'])->findOrFail($studentId);
        
        // Get assigned courses from assigned_courses table, filtering for college-type courses only
        $this->assignedCourses = \App\Models\AssignedCourse::where('student_id', $student->user_id)
            ->with(['course', 'assignedBy'])
            ->whereHas('course', function($query) {
                $query->where('course_type', 'college');
            })
            ->get();
        
        $this->selectedStudent = $student;
        $this->dispatch('open-modal', 'view-courses-modal');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSelectedCollege()
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

    public function toggleStatus($studentId)
    {
        $student = Student::findOrFail($studentId);
        $student->active_status = !$student->active_status;
        $student->save();
        
        // Sync user status? Often good practice
        $student->user->active_status = $student->active_status;
        $student->user->save();

        $status = $student->active_status ? 'activated' : 'deactivated';
        $this->dispatch('toast-message', message: "Student {$status} successfully!", type: 'success');
    }

    public function render()
    {
        $query = Student::with(['user', 'user.college', 'degree']);

        // Apply search
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->where('enrollment_no', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function (Builder $userQ) {
                      $userQ->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%')
                            ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply filter
        if ($this->filter === 'active') {
            $query->where('active_status', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('active_status', false);
        }

        if ($this->selectedCollege) {
            $query->whereHas('user', function ($q) {
                $q->where('college_id', $this->selectedCollege);
            });
        }

        // Apply sorting
        // Handling sorting on related User fields involves joins, sticking to student fields or simple sorts for now
        if (in_array($this->sortField, ['created_at', 'enrollment_no', 'active_status'])) {
             $query->orderBy($this->sortField, $this->sortDirection);
        } else {
             $query->orderBy('created_at', 'desc');
        }

        $students = $query->paginate($this->perPage);

        $totalCount = Student::count(); // Optimize this if needed (respecting filters?)
        // To be accurate with search, we should use similar query logic for counts
        // keeping it simple for now or using the query clone:
        
        // $countsQuery = Student::query();
        // if ($this->search) { ... }
        // $totalCount = $countsQuery->count();
        // $activeCount = (clone $countsQuery)->where('active_status', true)->count();
        // $inactiveCount = (clone $countsQuery)->where('active_status', false)->count();
        
        // For simple dashboard counters without search context:
        $activeCount = Student::where('active_status', true)->count();
        $inactiveCount = Student::where('active_status', false)->count();

        $colleges = CollegeInfo::where('active_status', true)->orderBy('college_name')->get();

        return view('livewire.admin.student.index', [
            'students' => $students,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'colleges' => $colleges,
        ]);
    }
}


