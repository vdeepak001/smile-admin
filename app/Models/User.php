<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_COLLEGE = 'college';
    const ROLE_STUDENT = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
        'first_name',
        'last_name',
        'phone_number',
        'avatar',
        'active_status',
        'college_id',
        'created_by',
        'updated_by',
        'college_rights',
        'course_rights',
        'students_rights',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active_status' => 'boolean',
            'college_rights' => 'boolean',
            'course_rights' => 'boolean',
            'students_rights' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    // Relationships
    public function college()
    {
        return $this->belongsTo(CollegeInfo::class, 'college_id', 'college_id');
    }

    public function collegeAccount()
    {
        return $this->hasOne(CollegeInfo::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function usersCreated()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function assignedCourses()
    {
        return $this->hasMany(AssignedCourse::class, 'student_id');
    }

    public function marks()
    {
        return $this->hasMany(Marks::class, 'student_id');
    }

    public function answers()
    {
        return $this->hasMany(Answered::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCollege(): bool
    {
        return $this->role === self::ROLE_COLLEGE;
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function dashboardRouteName(): ?string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'admin.dashboard',
            self::ROLE_COLLEGE => 'college.dashboard',
            self::ROLE_STUDENT => 'student.dashboard',
            default => null,
        };
    }

    public function dashboardUrl(bool $absolute = false): ?string
    {
        $routeName = $this->dashboardRouteName();

        return $routeName ? route($routeName, absolute: $absolute) : null;
    }

    public function canUpdateRights(): bool
    {
        return $this->isAdmin();
    }

    // public function getAvatarUrl(): ?string
    // {
    //     return $this->avatar
    //         ? Storage::disk('public')->url('avatars/' . $this->avatar)
    //         : null;
    // }

    public function getAvatarUrl(): ?string
{
    return $this->avatar
        ? asset('storage/avatars/'.$this->avatar)
        : null;
}

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
