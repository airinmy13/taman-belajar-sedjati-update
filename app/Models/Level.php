<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_world',
        'minggu_ke',
        'data_soal'
    ];

    protected $casts = [
        'data_soal' => 'array',
    ];

    /**
     * Relasi ke scores (backward compatibility)
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
