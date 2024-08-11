<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'index_number',
        'name',
        'email',
        'phone',
        'level',
        'group',
        'gender',
        'department_id',
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            $user = User::create([
                'name' => $student->name,
                'email' => $student->email,
                'password' => bcrypt('defaultpassword'), // Set a default password, or generate a random one
                'role' => 'student', // Set the role to lecturer
            ]);

            $student->user_id = $user->id;
        });


    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // public function enrollments()
    // {
    //     return $this->hasMany(Enrollment::class);
    // }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // public function getNameAttribute(){
    //     return $this->name;
    // }

    // public function name(){
    //     return $this->getNameAttribute();
    // }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function attendances()
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
                    ->orWhere('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('level', 'like', '%'.$search.'%')
                    ->orWhere('group', 'like', '%'.$search.'%');
            });
        });
    }

    //attendances relationship




}
