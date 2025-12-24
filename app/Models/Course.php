<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;

    protected $fillable = [
        'course_name',
        'course_code',
        'course_type',
        'description',
        'course_pic',
        'test_questions',
        'percent_require',

        'inserted_by',
        'updated_by',
        'inserted_on',
        'updated_on',

        'active_status',
    ];

    protected $casts = [
        'active_status' => 'boolean',

        'inserted_on' => 'datetime',
        'updated_on' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships


    public function topics()
    {
        return $this->hasMany(CourseTopic::class, 'course_id', 'course_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'course_id', 'course_id');
    }

    public function assignedStudents()
    {
        return $this->hasMany(AssignedCourse::class, 'course_id', 'course_id');
    }

    public function marks()
    {
        return $this->hasMany(Marks::class, 'course_id', 'course_id');
    }

    public function colleges()
    {
        return $this->belongsToMany(CollegeInfo::class, 'college_course', 'course_id', 'college_id');
    }

    public function insertedBy()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active_status', true);
    }
}
