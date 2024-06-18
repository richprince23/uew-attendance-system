<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'index_number',
        'other_names',
        'surname',
        'email',
        'phone',
        'level',
        'group',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }



    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function recognitions()
    {
        return $this->hasOne(Recognitions::class);
    }

    public function face_encodings()
    {
        return $this->recognitions()->pluck('face_encodings')->first();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('index_number', 'like', '%'.$search.'%')
                    ->orWhere('other_names', 'like', '%'.$search.'%')
                    ->orWhere('surname', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('level', 'like', '%'.$search.'%')
                    ->orWhere('group', 'like', '%'.$search.'%');
            });
        });
    }

}
