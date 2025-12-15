<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTopic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'course_topics';
    protected $primaryKey = 'topic_id';
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'topic_name',
        'description',
        'attachment',
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
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'topic_id', 'topic_id');
    }

    public function insertedBy()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
