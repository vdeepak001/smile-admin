<?php

namespace App\Livewire\College\Student;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public ?Student $selectedStudent = null;
    public $assignedCourses = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function viewCourses($studentId)
    {
        $student = Student::with(['user'])->findOrFail($studentId);

        // Verify student belongs to this college
        if ($student->user->college_id !== Auth::user()->collegeAccount->college_id) {
            $this->dispatch('toast-message', message: 'Unauthorized access!', type: 'error');
            return;
        }

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

    public function render()
    {
        // Get the college_id of the logged-in college user
        $collegeId = Auth::user()->collegeAccount->college_id;

        $query = Student::with(['user', 'degree'])
            ->join('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('degrees', 'students.degree_id', '=', 'degrees.id')
            ->where('users.college_id', $collegeId)
            ->select('students.*');

        // Apply search - search across multiple fields
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('students.enrollment_no', 'like', $searchTerm)
                  ->orWhere('students.roll_number', 'like', $searchTerm)
                  ->orWhere('users.first_name', 'like', $searchTerm)
                  ->orWhere('users.last_name', 'like', $searchTerm)
                  ->orWhere('users.phone_number', 'like', $searchTerm)
                  ->orWhere('degrees.name', 'like', $searchTerm);

                // For email search, use email_hash for exact matches
                if (filter_var($this->search, FILTER_VALIDATE_EMAIL)) {
                    $emailHash = hash('sha256', strtolower(trim($this->search)));
                    $q->orWhere('users.email_hash', $emailHash);
                }
            });
        }

        // Apply filter
        if ($this->filter === 'active') {
            $query->where('students.active_status', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('students.active_status', false);
        }

        // Apply sorting with joins for related fields
        switch ($this->sortField) {
            case 'name':
                $query->orderBy('users.first_name', $this->sortDirection)
                      ->orderBy('users.last_name', $this->sortDirection);
                break;
            case 'email':
                $query->orderBy('users.email', $this->sortDirection);
                break;
            case 'phone':
                $query->orderBy('users.phone_number', $this->sortDirection);
                break;
            case 'roll_number':
                $query->orderBy('students.roll_number', $this->sortDirection);
                break;
            case 'degree':
                $query->orderBy('degrees.name', $this->sortDirection);
                break;
            case 'enrollment_no':
                $query->orderBy('students.enrollment_no', $this->sortDirection);
                break;
            case 'active_status':
                $query->orderBy('students.active_status', $this->sortDirection);
                break;
            case 'created_at':
            default:
                $query->orderBy('students.created_at', $this->sortDirection);
                break;
        }

        $students = $query->paginate($this->perPage);

        // Get counts for the college
        $totalCount = Student::whereHas('user', function ($q) use ($collegeId) {
            $q->where('college_id', $collegeId);
        })->count();

        $activeCount = Student::whereHas('user', function ($q) use ($collegeId) {
            $q->where('college_id', $collegeId);
        })->where('active_status', true)->count();

        $inactiveCount = Student::whereHas('user', function ($q) use ($collegeId) {
            $q->where('college_id', $collegeId);
        })->where('active_status', false)->count();

        return view('livewire.college.student.index', [
            'students' => $students,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }
}
