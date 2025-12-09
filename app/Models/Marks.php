<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marks extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'marks';
    protected $primaryKey = 'marks_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_id',
        'total_questions',
        'completed_on',
        'answered_questions',
        'correct_answer',
        'wrong_answer',
        'percentage',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
