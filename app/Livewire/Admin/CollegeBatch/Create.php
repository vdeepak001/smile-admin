<?php

namespace App\Livewire\Admin\CollegeBatch;

use Livewire\Component;
use App\Models\CollegeBatch;
use App\Models\CollegeInfo;

class Create extends Component
{
    public $collegeId;
    public $college;
    public $batch_id;
    public $year;
    public $selectedCourses = [];
    public $start_date;
    public $end_date;
    public $batch_type = 1;
    public $final_test_questions_count;
    public $availableCourses = [];

   
    public function mount($collegeId)
    {
        $this->collegeId = $collegeId;
        $this->college = CollegeInfo::where('college_id', $collegeId)->with('courses')->firstOrFail();
        $this->availableCourses = $this->college->courses;
        
        // Set default year to current year
        $this->year = date('Y');
        
        // Generate batch ID
        $this->generateBatchId();
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
            'batch_id' => 'required|unique:college_batches,batch_id',
            'selectedCourses' => 'required|array|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'batch_type' => 'required|integer|in:1,2,3',
            'final_test_questions_count' => 'nullable|integer|min:1',
        ];
    }

    protected $messages = [
        'selectedCourses.required' => 'Please select at least one course.',
        'selectedCourses.min' => 'Please select at least one course.',
        'end_date.after' => 'End date must be after start date.',
    ];

    public function save()
    {
        $this->validate();

        CollegeBatch::create([
            'batch_id' => $this->batch_id,
            'college_id' => $this->collegeId,
            'courses' => $this->selectedCourses,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'batch_type' => $this->batch_type,
            'final_test_questions_count' => $this->final_test_questions_count,
            'active_status' => true,
            'created_by' => auth()->user()->name ?? 'System',
        ]);

        session()->flash('success', 'Batch created successfully!');
        return redirect()->route('college-batches.index', $this->collegeId);
    }

    public function render()
    {
        return view('livewire.admin.college-batch.create');
    }
    public function setBatchType($type)
    {
        $this->batch_type = (int) $type;
    }
}
