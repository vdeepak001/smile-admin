<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignedCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'assigned_course';
    protected $primaryKey = 'assigned_course_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_id',
        'valid_from',
        'valid_until',
        'completion_status',
        'assigned_by',
        'assigned_on',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'assigned_on' => 'datetime',
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

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
