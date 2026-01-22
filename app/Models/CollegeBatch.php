<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollegeBatch extends Model
{
    protected $fillable = [
        'batch_id',
        'college_id',
        'courses',
        'start_date',
        'end_date',
        'batch_type',
        'final_test_questions_count',
        'active_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'courses' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'active_status' => 'boolean',
    ];

    // Relationship with CollegeInfo
    public function college()
    {
        return $this->belongsTo(CollegeInfo::class, 'college_id', 'college_id');
    }

    // Get courses as collection
    public function getCoursesList()
    {
        if (!$this->courses) {
            return collect([]);
        }
        return Course::whereIn('course_id', $this->courses)->get();
    }

    // Generate batch ID
    public static function generateBatchId($collegeName, $year)
    {
        $collegeCode = self::extractCollegeInitials($collegeName);
        
        $lastBatch = self::where('batch_id', 'like', "{$collegeCode}-{$year}-%")
            ->orderBy('batch_id', 'desc')
            ->first();

        if ($lastBatch) {
            $lastSequence = (int) substr($lastBatch->batch_id, -3);
            $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '001';
        }

        return "{$collegeCode}-{$year}-{$newSequence}";
    }

    // Extract initials from college name
    protected static function extractCollegeInitials($collegeName)
    {
        // Split by spaces and get first letter of each word
        $words = preg_split('/\s+/', trim($collegeName));
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        
        // If no initials found, use first 3 characters
        if (empty($initials)) {
            $initials = strtoupper(substr($collegeName, 0, 3));
        }
        
        return $initials;
    }

    // Relationship with students
    public function students()
    {
        return $this->belongsToMany(Student::class, 'batch_student', 'batch_id', 'student_id')
            ->withPivot('assigned_by', 'assigned_at')
            ->withTimestamps();
    }

    // Extract year from batch_id (format: COL-2022-001)
    public function getBatchYear()
    {
        $parts = explode('-', $this->batch_id);
        return isset($parts[1]) ? (int)$parts[1] : null;
    }

    // Relationship with course settings
    public function courseSettings()
    {
        return $this->hasMany(BatchCourseSetting::class, 'batch_id');
    }
}
