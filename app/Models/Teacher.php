<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'subjects',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'subjects' => 'array',
    ];

    public function games()
    {
        return $this->hasMany(\App\Models\Game::class, 'teacher_id');
    }
}
