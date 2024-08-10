<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'year',
        'semester'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function getStudents(){
        return $this->students();
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('student_id', 'like', '%'.$search.'%')
                    ->orWhere('course_id', 'like', '%'.$search.'%');
            });
        });
    }

    public function scopeStudent($query, $student)
    {
        $query->where('student_id', $student);
    }

    public function scopeCourse($query, $course)
    {
        $query->where('course_id', $course);
    }

    public function scopeStudentCourse($query, $student, $course)
    {
        $query->where('student_id', $student)->where('course_id', $course);
    }


}
