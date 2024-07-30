<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code',
        'semester',
        'level',
        'lecturer_id',
        'year',
        'department_id',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedules::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    // enrollments
    public function enrollment()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('course_name', 'like', '%'.$search.'%')
                    ->orWhere('course_code', 'like', '%'.$search.'%')
                    ->orWhere('semester', 'like', '%'.$search.'%')
                    ->orWhere('year', 'like', '%'.$search.'%')
                    ->orWhere('department', 'like', '%'.$search.'%');
            });
        });
    }

    public function scopeByLecturer($query, $lecturerId)
    {
        return $query->where('lecturer_id', $lecturerId);
    }
}
