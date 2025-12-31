<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    // Kita kasih tahu Laravel kalau tabelnya bernama 'parents'
    protected $table = 'parents';

    protected $fillable = [
        'parent_name',
        'child_name', // NOTE: Kolom ini mungkin akan kosong kalau child dipindah ke tabel students, tapi biarkan dulu
        'email',
        'password',
        'username',
        'phone',
        'gender'
    ];

    protected $hidden = [
        'password'
    ];

    // Orang tua bisa punya banyak anak
    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}