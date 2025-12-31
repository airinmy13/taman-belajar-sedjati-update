<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentRegistration extends Model
{
    protected $fillable = [
        'parent_name',
        'username',
        'password',
        'email',
        'phone',
        'gender',
        'child_name',
        'child_class',
        'status',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];
}
