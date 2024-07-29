<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department_id',
        'phone',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($lecturer) {
            User::create([
                'name' => $lecturer->name,
                'email' => $lecturer->email,
                'password' => bcrypt('defaultpassword'), // Set a default password, or generate a random one
                'role' => 'lecturer', // Set the role to lecturer
            ]);
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedules::class);
    }
    // courses
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('address', 'like', '%'.$search.'%');
            });
        });
    }
}
