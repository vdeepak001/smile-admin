<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchCourseSetting extends Model
{
    use HasFactory;

    protected $table = 'batch_course_settings';

    protected $fillable = [
        'batch_id',
        'course_id',
        'titles_enabled',
        'updated_date',
        'batch_type',
        'selected_topics',
    ];

    protected $casts = [
        'titles_enabled' => 'boolean',
        'updated_date' => 'date',
        'selected_topics' => 'array',
    ];

    public function batch()
    {
        return $this->belongsTo(CollegeBatch::class, 'batch_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
