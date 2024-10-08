<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recognitions extends Model
{
    use HasFactory;

    protected $fillable = [
        'face_encodings',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
