<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'questions';
    protected $primaryKey = 'question_id';
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'topic_id',
        'question_type',
        'question_text',
        'level',
        'pic_1',
        'pic_2',
        'pic_3',
        'choice_1',
        'choice_2',
        'choice_3',
        'choice_4',
        'choice_pic_1',
        'choice_pic_2',
        'choice_pic_3',
        'choice_pic_4',
        'right_answer',
        'reasoning',
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

    public function topic()
    {
        return $this->belongsTo(CourseTopic::class, 'topic_id', 'topic_id');
    }

    public function answers()
    {
        return $this->hasMany(Answered::class, 'question_id', 'question_id');
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
