<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'game_id',
        'started_at',
        'completed_at',
        'total_questions',
        'correct_answers',
        'total_score'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relasi ke student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke game
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Relasi ke scores
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Calculate accuracy percentage
     */
    public function getAccuracyAttribute()
    {
        if ($this->total_questions == 0) {
            return 0;
        }
        return round(($this->correct_answers / $this->total_questions) * 100, 2);
    }

    /**
     * Check if session is completed
     */
    public function isCompleted()
    {
        return !is_null($this->completed_at);
    }
}
