<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';
    
    protected $fillable = [
        'student_id',
        'game_session_id',
        'question_id',
        'level_id',
        'answer',
        'is_correct',
        'points_earned',
        'nilai',
        'game_name'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Relasi ke student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke game session
     */
    public function session()
    {
        return $this->belongsTo(GameSession::class, 'game_session_id');
    }

    /**
     * Relasi ke question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relasi ke level (backward compatibility)
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}