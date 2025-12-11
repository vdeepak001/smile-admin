<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollegeInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'college_info';
    protected $primaryKey = 'college_id';
    public $timestamps = true;

    protected $fillable = [
        'college_name',
        'college_code',
        'user_id',
        'contact_person',
        // 'course_id', // Removed
        'max_students',
        'valid_from',
        'valid_until',
        'active_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active_status' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'college_id', 'college_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'college_id', 'college_id')->where('role', User::ROLE_STUDENT);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'college_course', 'college_id', 'course_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
