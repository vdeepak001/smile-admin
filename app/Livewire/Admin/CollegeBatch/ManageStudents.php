<?php

namespace App\Livewire\Admin\CollegeBatch;

use Livewire\Component;
use App\Models\CollegeBatch;
use App\Models\CollegeInfo;
use App\Models\Student;
use App\Models\User;

class ManageStudents extends Component
{
    public $collegeId;
    public $batchId;
    public $college;
    public $batch;
    public $availableStudents = [];
    public $selectedStudents = [];
    public $batchYear;

    public function mount($collegeId, $batchId)
    {
        $this->collegeId = $collegeId;
        $this->batchId = $batchId;
        
        // Load college and batch
        $this->college = CollegeInfo::where('college_id', $collegeId)->firstOrFail();
        $this->batch = CollegeBatch::findOrFail($batchId);
        
        // Extract year from batch_id
        $this->batchYear = $this->batch->getBatchYear();
        
        // Get students with matching start_year
        $this->loadAvailableStudents();
        
        // Pre-select already assigned students
        $this->selectedStudents = $this->batch->students()->pluck('students.student_id')->toArray();
    }

    public function loadAvailableStudents()
    {
        // Get all students with matching start_year
        // Join with users table to get student details
        $this->availableStudents = Student::with(['user', 'degree'])
            ->where('start_year', $this->batchYear)
            ->where('active_status', true)
            ->get();
    }

    public function toggleSelectAll()
    {
        if (count($this->selectedStudents) === $this->availableStudents->count()) {
            // Deselect all
            $this->selectedStudents = [];
        } else {
            // Select all
            $this->selectedStudents = $this->availableStudents->pluck('student_id')->toArray();
        }
    }

    public function save()
    {
        $this->validate([
            'selectedStudents' => 'array',
        ]);

        // Get current user name
        $assignedBy = auth()->user()->name ?? 'System';
        
        // Sync students with the batch
        // This will add new students and remove unselected ones
        $syncData = [];
        foreach ($this->selectedStudents as $studentId) {
            $syncData[$studentId] = [
                'assigned_by' => $assignedBy,
                'assigned_at' => now(),
            ];
        }
        
        $this->batch->students()->sync($syncData);

        session()->flash('success', 'Students assigned to batch successfully!');
        return redirect()->route('college-batches.index', $this->collegeId);
    }

    public function render()
    {
        return view('livewire.admin.college-batch.manage-students');
    }
}
