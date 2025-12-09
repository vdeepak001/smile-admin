<?php

namespace App\Livewire\Admin\Degree;

use App\Models\Degree;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    // View Modal State
    public ?Degree $selectedDegree = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

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

    public function toggleStatus($degreeId)
    {
        $degree = Degree::findOrFail($degreeId);
        $degree->active_status = !$degree->active_status;
        $degree->save();

        $status = $degree->active_status ? 'activated' : 'deactivated';
        $this->dispatch('toast-message', message: "Degree {$status} successfully!", type: 'success');
    }

    public function viewDegree($degreeId)
    {
        $this->selectedDegree = Degree::with(['createdBy', 'updatedBy'])->findOrFail($degreeId);
        $this->dispatch('open-modal', 'view-degree-detail');
    }

    public function render()
    {
        $query = Degree::query();

        // Apply search
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Apply filter
        if ($this->filter === 'active') {
            $query->where('active_status', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('active_status', false);
        }

        // Apply sorting
        if (in_array($this->sortField, ['created_at', 'name', 'active_status'])) {
             $query->orderBy($this->sortField, $this->sortDirection);
        } else {
             $query->orderBy('created_at', 'desc');
        }

        $degrees = $query->paginate($this->perPage);

        // Counters (can be optimized if strict correctness strictly required with search)
        $totalCount = Degree::count(); 
        $activeCount = Degree::where('active_status', true)->count();
        $inactiveCount = Degree::where('active_status', false)->count();

        return view('livewire.admin.degree.index', [
            'degrees' => $degrees,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }
}
