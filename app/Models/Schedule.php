<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'student_id',
        'subject',
        'day',
        'time',
        'mentor',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }
}
