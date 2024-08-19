<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'school',
        'app_name',
        'address',
        'academic_year',
        'semester',
        'semester_start',
        'semester_end',
    ];

    protected $casts = [
        'semester_start' => 'date',
       'semester_end' => 'date',
    ];
}
