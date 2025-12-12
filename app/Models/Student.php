<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'user_id',
        'degree_id',
        'specialization',
        'year_of_study',
        'start_year',
        'end_year',
        'enrollment_no',
        'roll_number',
        'guardian_name',
        'date_of_birth',
        'active_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active_status' => 'boolean',
        'date_of_birth' => 'date',
        'year_of_study' => 'integer',
        'start_year' => 'integer',
        'end_year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'assigned_course',
            'student_id',
            'course_id',
            'user_id',
            'course_id'
        )
        ->withPivot('completion_status', 'assigned_by', 'assigned_on');
    }
}
