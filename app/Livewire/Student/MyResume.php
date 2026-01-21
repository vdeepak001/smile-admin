<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MyResume extends Component
{
    use WithFileUploads;

    public $resume;
    public $resumeUrl;
    public $uploadedResume;
    public $duhamiCvUrl;

    public function mount()
    {
        $this->loadResume();
    }

    public function loadResume()
    {
        $student = auth()->user();
        
        // Check if student has uploaded resume
        if ($student->resume_path) {
            $this->uploadedResume = $student->resume_path;
        }

        // DuhamiCV URL
        $this->duhamiCvUrl = 'https://www.duhami.cv'; // Updated to correct URL
    }

    public function uploadResume()
    {
        $this->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $student = auth()->user();

        // Delete old resume if exists
        if ($student->resume_path) {
            Storage::disk('public')->delete($student->resume_path);
        }

        // Store new resume
        $path = $this->resume->store('resumes', 'public');

        // Update user record
        $student->update([
            'resume_path' => $path,
        ]);

        $this->uploadedResume = $path;
        $this->resume = null;

        session()->flash('success', 'Resume uploaded successfully!');
    }

    public function deleteResume()
    {
        $student = auth()->user();

        if ($student->resume_path) {
            Storage::disk('public')->delete($student->resume_path);
            
            $student->update([
                'resume_path' => null,
            ]);

            $this->uploadedResume = null;

            session()->flash('success', 'Resume deleted successfully!');
        }
    }

    public function render()
    {
        return view('livewire.student.my-resume')->layout('layouts.app');
    }
}
