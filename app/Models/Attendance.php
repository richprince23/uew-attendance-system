<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'course_id',
        'student_id',
        'schedules_id',
        'date',
        'time_in',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        // return $this->enrollment()->student();
        return $this->belongsTo(Student::class);
    }
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
    public function course()
    {
        // return $this->enrollment()->course();
        return $this->belongsTo(Course::class);
    }
    // public function enrollment()
    // {
    //     return $this->belongsTo(Enrollment::class);
    // }
    public function schedule(){
        return $this->belongsTo(Schedules::class);
    }

    // public function scopeFilterCourse($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? null, function ($query, $search) {
    //         $query->where(function ($query) use ($search) {
    //             $query->whereHas('course', function ($query) use ($search) {
    //                 $query->where('name', 'like', '%'.$search.'%');
    //             });
    //         });
    //     });
    // }
    // public function scopeFilter($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? null, function ($query, $search) {
    //         $query->where(function ($query) use ($search) {
    //             $query->whereHas('user', function ($query) use ($search) {
    //                 $query->where('name', 'like', '%'.$search.'%');
    //             });
    //         });
    //     });
    // }
    // public function scopeFilterStudent($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? null, function ($query, $search) {
    //         $query->where(function ($query) use ($search) {
    //             $query->whereHas('student', function ($query) use ($search) {
    //                 $query->where('name', 'like', '%'.$search.'%');
    //             });
    //         });
    //     });
    // }
    // public function scopeFilterTeacher($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? null, function ($query, $search) {
    //         $query->where(function ($query) use ($search) {
    //             $query->whereHas('lecturer', function ($query) use ($search) {
    //                 $query->where('name', 'like', '%'.$search.'%');
    //             });
    //         });
    //     });
    // }
    // public function scopeFilterDate($query, array $filters)
    // {
    //     $query->when($filters['date'] ?? null, function ($query, $date) {
    //         $query->whereDate('date', $date);
    //     });
    // }
    // public function scopeFilterTimeIn($query, array $filters)
    // {
    //     $query->when($filters['time_in'] ?? null, function ($query, $time_in) {
    //         $query->whereTime('time_in', $time_in);
    //     });
    // }
}
