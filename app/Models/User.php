<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }
    /**
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
{
    if ($this->role == 'admin' && $panel->getId() == 'admin') {
        return true;
    }

    if ($this->role == 'lecturer' && $panel->getId() == 'lecturer') {
        return true;
    }

    if ($this->role == 'student' && $panel->getId() == 'student') {
        return true;
    }

    return false;
}

    public function lecturedCourses()
    {
        return $this->hasMany(Course::class, 'lecturer_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
    public function role(){
        return $this->role;
    }

    public function session(){
        return $this->hasMany(Session::class);
    }

}
