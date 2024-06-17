<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'venue',
        'room_number',
        'day_of_week',
        'lecturer_id',
        'start_time',
        'end_time',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function scopeFilterCourse($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('course', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
            });
        });
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('venue', 'like', '%'.$search.'%')
                    ->orWhere('room_number', 'like', '%'.$search.'%')
                    ->orWhere('day_of_week', 'like', '%'.$search.'%')
                    ->orWhere('start_time', 'like', '%'.$search.'%')
                    ->orWhere('end_time', 'like', '%'.$search.'%');
            });
        });
    }
}
