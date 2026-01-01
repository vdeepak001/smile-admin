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
}
