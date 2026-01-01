<?php

namespace App\Livewire\Admin\CollegeBatch;

use Livewire\Component;
use App\Models\CollegeBatch;
use App\Models\CollegeInfo;

class Edit extends Component
{
    public $collegeId;
    public $batchId;
    public $college;
    public $batch;
    public $batch_id;
    public $year;
    public $selectedCourses = [];
    public $start_date;
    public $end_date;
    public $batch_type;
    public $availableCourses = [];

    public function mount($collegeId, $batchId)
    {
        $this->collegeId = $collegeId;
        $this->batchId = $batchId;
        $this->college = CollegeInfo::where('college_id', $collegeId)->with('courses')->firstOrFail();
        $this->batch = CollegeBatch::findOrFail($batchId);
        $this->availableCourses = $this->college->courses;

        // Populate form fields
        $this->batch_id = $this->batch->batch_id;
        $this->selectedCourses = $this->batch->courses ?? [];
        $this->start_date = $this->batch->start_date->format('Y-m-d');
        $this->end_date = $this->batch->end_date->format('Y-m-d');
        $this->batch_type = $this->batch->batch_type;
        
        // Extract year from batch_id (format: CODE-YEAR-SEQ)
        $parts = explode('-', $this->batch_id);
        $this->year = isset($parts[1]) ? $parts[1] : date('Y');
    }

    public function updatedYear()
    {
        // Regenerate batch ID when year changes
        $this->generateBatchId();
    }

    protected function generateBatchId()
    {
        $this->batch_id = CollegeBatch::generateBatchId($this->college->college_name, $this->year);
    }

    protected function rules()
    {
        return [
            'year' => 'required|integer|min:2000|max:2100',
            'batch_id' => 'required|unique:college_batches,batch_id,' . $this->batchId,
            'selectedCourses' => 'required|array|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'batch_type' => 'required|integer|in:1,2,3',
        ];
    }

    protected $messages = [
        'selectedCourses.required' => 'Please select at least one course.',
        'selectedCourses.min' => 'Please select at least one course.',
        'end_date.after' => 'End date must be after start date.',
    ];

    public function update()
    {
        $this->validate();

        $this->batch->update([
            'batch_id' => $this->batch_id,
            'courses' => $this->selectedCourses,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'batch_type' => $this->batch_type,
            'updated_by' => auth()->user()->name ?? 'System',
        ]);

        session()->flash('success', 'Batch updated successfully!');
        return redirect()->route('college-batches.index', $this->collegeId);
    }

    public function render()
    {
        return view('livewire.admin.college-batch.edit');
    }
}
