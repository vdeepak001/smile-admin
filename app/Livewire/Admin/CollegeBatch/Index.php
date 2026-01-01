<?php

namespace App\Livewire\Admin\CollegeBatch;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CollegeBatch;
use App\Models\CollegeInfo;

class Index extends Component
{
    use WithPagination;

    public $collegeId;
    public $college;
    public $search = '';
    public $filter = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'filter'];

    public function mount($collegeId)
    {
        $this->collegeId = $collegeId;
        $this->college = CollegeInfo::where('college_id', $collegeId)->firstOrFail();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($batchId)
    {
        $batch = CollegeBatch::where('id', $batchId)->first();
        if ($batch) {
            $batch->active_status = !$batch->active_status;
            $batch->updated_by = auth()->user()->name ?? 'System';
            $batch->save();

            session()->flash('success', 'Batch status updated successfully!');
        }
    }

    public function deleteBatch($batchId)
    {
        $batch = CollegeBatch::find($batchId);
        if ($batch) {
            $batch->delete();
            session()->flash('success', 'Batch deleted successfully!');
        }
    }

    public function render()
    {
        $query = CollegeBatch::where('college_id', $this->collegeId)
            ->with('college');

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('batch_id', 'like', '%' . $this->search . '%');
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

        $batches = $query->paginate(10);

        // Get counts for filters
        $totalCount = CollegeBatch::where('college_id', $this->collegeId)->count();
        $activeCount = CollegeBatch::where('college_id', $this->collegeId)->where('active_status', true)->count();
        $inactiveCount = CollegeBatch::where('college_id', $this->collegeId)->where('active_status', false)->count();

        return view('livewire.admin.college-batch.index', [
            'batches' => $batches,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }
}
