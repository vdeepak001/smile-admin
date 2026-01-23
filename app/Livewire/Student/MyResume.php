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
    public $resumePhoto; // For temporary file upload
    public $duhamiCvUrl;

    // Resume Builder Data
    public $basics = [
        'name' => '',
        'label' => '',
        'email' => '',
        'phone' => '',
        'url' => '',
        'summary' => '',
        'location' => [
            'city' => '',
            'region' => '',
        ],
        'profiles' => [
            'linkedin' => '',
            'github' => '',
        ],
        'image' => '', // Base64 image data or path
        'show_image' => false,
    ];
    public $work = [];
    public $education = [];
    public $projects = [];
    public $skills = [];
    public $achievements = [];
    public $certificates = [];
    public $languages = [];
    public $interests = [];

    public function mount()
    {
        $this->loadResume();
        $this->initializeBuilderData();
    }

    public function loadResume()
    {
        $student = auth()->user();
        
        // Check if student has uploaded resume
        if ($student->resume_path) {
            $this->uploadedResume = $student->resume_path;
        }

        // DuhamiCV URL
        $this->duhamiCvUrl = 'https://www.duhami.cv';
    }

    public function initializeBuilderData()
    {
        $student = auth()->user();
        $data = $student->resume_data;

        if ($data) {
            $this->basics = array_merge($this->basics, $data['basics'] ?? []);
            $this->work = $data['work'] ?? [];
            $this->education = $data['education'] ?? [];
            $this->projects = $data['projects'] ?? [];
            $this->skills = $data['skills'] ?? [];
            $this->achievements = $data['achievements'] ?? [];
            $this->certificates = $data['certificates'] ?? [];
            $this->languages = $data['languages'] ?? [];
            $this->interests = $data['interests'] ?? [];
        } else {
            // Default name and email from user
            $this->basics['name'] = $student->name;
            $this->basics['email'] = $student->email;
        }
    }

    public function addWork()
    {
        $this->work[] = [
            'company' => '',
            'position' => '',
            'startDate' => '',
            'endDate' => '',
            'summary' => '',
            'highlights' => [],
        ];
    }

    public function removeWork($index)
    {
        unset($this->work[$index]);
        $this->work = array_values($this->work);
    }

    public function addEducation()
    {
        $this->education[] = [
            'institution' => '',
            'area' => '',
            'studyType' => '',
            'startDate' => '',
            'endDate' => '',
            'score' => '',
        ];
    }

    public function removeEducation($index)
    {
        unset($this->education[$index]);
        $this->education = array_values($this->education);
    }

    public function addSkill()
    {
        $this->skills[] = [
            'name' => '',
            'level' => '',
            'keywords' => [],
        ];
    }

    public function removeSkill($index)
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function addLanguage()
    {
        $this->languages[] = [
            'language' => '',
            'fluency' => '',
        ];
    }

    public function removeLanguage($index)
    {
        unset($this->languages[$index]);
        $this->languages = array_values($this->languages);
    }

    public function addProject()
    {
        $this->projects[] = [
            'name' => '',
            'description' => '',
            'startDate' => '',
            'endDate' => '',
            'highlights' => [],
        ];
    }

    public function removeProject($index)
    {
        unset($this->projects[$index]);
        $this->projects = array_values($this->projects);
    }

    public function addAchievement()
    {
        $this->achievements[] = '';
    }

    public function removeAchievement($index)
    {
        unset($this->achievements[$index]);
        $this->achievements = array_values($this->achievements);
    }

    public function addCertificate()
    {
        $this->certificates[] = [
            'name' => '',
            'date' => '',
            'issuer' => '',
        ];
    }

    public function removeCertificate($index)
    {
        unset($this->certificates[$index]);
        $this->certificates = array_values($this->certificates);
    }

    public function addInterest()
    {
        $this->interests[] = '';
    }

    public function removeInterest($index)
    {
        unset($this->interests[$index]);
        $this->interests = array_values($this->interests);
    }

    public function saveBuilderData()
    {
        $student = auth()->user();
        
        // Handle specific resume photo upload
        if ($this->resumePhoto) {
            $path = $this->resumePhoto->store('resume_photos', 'public');
            $this->basics['image'] = $path;
            $this->resumePhoto = null;
        }

        $data = [
            'basics' => $this->basics,
            'work' => $this->work,
            'education' => $this->education,
            'projects' => $this->projects,
            'skills' => $this->skills,
            'achievements' => $this->achievements,
            'certificates' => $this->certificates,
            'languages' => $this->languages,
            'interests' => $this->interests,
        ];

        $student->update([
            'resume_data' => $data,
        ]);

        session()->flash('success', 'Resume data saved successfully!');
    }

    public function generatePdf()
    {
        $this->saveBuilderData();

        $data = [
            'basics' => $this->basics,
            'work' => $this->work,
            'education' => $this->education,
            'projects' => $this->projects,
            'skills' => $this->skills,
            'achievements' => $this->achievements,
            'certificates' => $this->certificates,
            'languages' => $this->languages,
            'interests' => $this->interests,
        ];

        // Convert photo to base64 if showing image
        if (isset($this->basics['show_image']) && $this->basics['show_image']) {
            $student = auth()->user();
            $photoPath = !empty($this->basics['image']) ? $this->basics['image'] : $student->avatar;

            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                try {
                    $mimeType = Storage::disk('public')->mimeType($photoPath);
                    $dataContent = Storage::disk('public')->get($photoPath);
                    $data['basics']['image_data'] = 'data:' . $mimeType . ';base64,' . base64_encode($dataContent);
                } catch (\Exception $e) {
                    // Fail silently if image cannot be processed
                }
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('resumes.default', $data);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, ($this->basics['name'] ?: 'Resume') . '.pdf');
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
