<?php

namespace App\Livewire\Admin\CollegeInfo;

use App\Models\CollegeInfo;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 6;
    public ?CollegeInfo $selectedCollege = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function viewCollege($collegeId)
    {
        $this->selectedCollege = CollegeInfo::with(['courses', 'user', 'createdBy', 'updatedBy'])
            ->withCount('students')
            ->findOrFail($collegeId);
        $this->dispatch('open-modal', 'view-college-detail');
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

    public function toggleStatus($collegeId)
    {
        $college = CollegeInfo::findOrFail($collegeId);
        $college->active_status = !$college->active_status;
        $college->save();

        $status = $college->active_status ? 'activated' : 'deactivated';
        $this->dispatch('toast-message', message: "College {$status} successfully!", type: 'success');
    }

    public function render()
    {
        $query = CollegeInfo::with(['courses', 'createdBy']);

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('college_name', 'like', '%' . $this->search . '%')
                    ->orWhere('college_code', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_person', 'like', '%' . $this->search . '%');
                    
                // For email search, use email_hash for exact matches
                if (filter_var($this->search, FILTER_VALIDATE_EMAIL)) {
                    $emailHash = hash('sha256', strtolower(trim($this->search)));
                    $q->orWhereHas('user', function ($userQuery) use ($emailHash) {
                        $userQuery->where('email_hash', $emailHash);
                    });
                }
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

        $collegeInfos = $query->paginate($this->perPage);

        // Get counts for filters (respecting search)
        $baseQuery = CollegeInfo::query();
        if ($this->search) {
            $baseQuery->where(function ($q) {
                $q->where('college_name', 'like', '%' . $this->search . '%')
                    ->orWhere('college_code', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_person', 'like', '%' . $this->search . '%');
                    
                // For email search, use email_hash for exact matches
                if (filter_var($this->search, FILTER_VALIDATE_EMAIL)) {
                    $emailHash = hash('sha256', strtolower(trim($this->search)));
                    $q->orWhereHas('user', function ($userQuery) use ($emailHash) {
                        $userQuery->where('email_hash', $emailHash);
                    });
                }
            });
        }

        $totalCount = $baseQuery->count();
        $activeCount = (clone $baseQuery)->where('active_status', true)->count();
        $inactiveCount = (clone $baseQuery)->where('active_status', false)->count();

        return view('livewire.admin.college-info.index', [
            'collegeInfos' => $collegeInfos,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }
}
