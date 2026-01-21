<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answered extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'answered';
    protected $primaryKey = 'answered_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'course_id',
        'topic_id',
        'question_id',
        'test_type',
        'sequence',
        'answered_choice',
        'answered_status',
        'time_taken',
        'answered_date',
    ];

    protected $casts = [
        'answered_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function topic()
    {
        return $this->belongsTo(CourseTopic::class, 'topic_id', 'topic_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}
