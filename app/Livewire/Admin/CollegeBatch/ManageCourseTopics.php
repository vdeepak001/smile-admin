<?php

namespace App\Livewire\Admin\CollegeBatch;

use Livewire\Component;

use App\Models\CollegeBatch;
use App\Models\CollegeInfo;
use App\Models\Course;
use App\Models\BatchCourseSetting;

class ManageCourseTopics extends Component
{
    public $collegeId;
    public $batchId;
    public $courseId;
    
    public $college;
    public $batch;
    public $course;
    
    public $titles_enabled = true;
    public $updated_date;
    public $batch_type = 1;
    public $selected_topics = [];
    
    public $availableTopics = [];

    public function mount($collegeId, $batchId, $courseId)
    {
        $this->collegeId = $collegeId;
        $this->batchId = $batchId;
        $this->courseId = $courseId;
        
        $this->college = CollegeInfo::where('college_id', $collegeId)->firstOrFail();
        $this->batch = CollegeBatch::findOrFail($batchId);
        $this->course = Course::where('course_id', $courseId)->with('topics')->firstOrFail();
        
        $this->availableTopics = $this->course->topics;
        
        // Load existing settings
        $setting = BatchCourseSetting::where('batch_id', $batchId)
            ->where('course_id', $courseId)
            ->first();
            
        if ($setting) {
            $this->titles_enabled = $setting->titles_enabled;
            $this->updated_date = $setting->updated_date ? $setting->updated_date->format('Y-m-d') : null;
            $this->batch_type = $setting->batch_type;
            // Ensure selected_topics is always an array
            $this->selected_topics = is_array($setting->selected_topics) ? $setting->selected_topics : [];
        } else {
            $this->batch_type = $this->batch->batch_type; // Default to batch type
            $this->selected_topics = [];
        }
    }

    public function toggleTopic($topicId)
    {
        if (in_array($topicId, $this->selected_topics)) {
            $this->selected_topics = array_diff($this->selected_topics, [$topicId]);
        } else {
            $this->selected_topics[] = $topicId;
        }
        
        // Reset array keys to avoid issues
        $this->selected_topics = array_values($this->selected_topics);
    }

    public function toggleSelectAll()
    {
        if (count($this->selected_topics) === count($this->availableTopics)) {
            $this->selected_topics = [];
        } else {
            $this->selected_topics = collect($this->availableTopics)->pluck('topic_id')->toArray();
        }
    }

    public function save()
    {
        $this->validate([
            'updated_date' => 'nullable|date',
            'batch_type' => 'required|integer|in:1,2,3',
            'selected_topics' => 'array',
        ]);

        BatchCourseSetting::updateOrCreate(
            [
                'batch_id' => $this->batchId,
                'course_id' => $this->courseId,
            ],
            [
                'titles_enabled' => $this->titles_enabled,
                'updated_date' => $this->updated_date,
                'batch_type' => $this->batch_type,
                'selected_topics' => $this->selected_topics,
            ]
        );

        session()->flash('success', 'Course topics and settings updated successfully!');
        return redirect()->route('college-batches.index', $this->collegeId);
    }

    public function render()
    {
        return view('livewire.admin.college-batch.manage-course-topics');
    }
}
