<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'hod',
        'faculty_id',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedules::class);
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%')
                    ->orWhere('hod', 'like', '%'.$search.'%')
                    ->orWhere('faculty', 'like', '%'.$search.'%');
            });
        });
    }
    public function scopeSearch($query, array $search)
    {
        $query->when($search['name'] ?? null, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($search['description'] ?? null, function ($query, $description) {
            $query->where('description', 'like', '%'.$description.'%');
        });
        $query->when($search['code'] ?? null, function ($query, $code) {
            $query->where('code', 'like', '%'.$code.'%');
        });
        $query->when($search['hod'] ?? null, function ($query, $hod) {
            $query->where('hod', 'like', '%'.$hod.'%');
        });
        $query->when($search['faculty'] ?? null, function ($query, $faculty) {
            $query->where('faculty', 'like', '%'.$faculty.'%');
        });
    }
}
