<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'question_text',
        'question_data',
        'correct_answer',
        'options',
        'points',
        'difficulty',
        'is_active',
        'image'
    ];

    protected $casts = [
        'question_data' => 'array',
        'options' => 'array',
        'is_active' => 'boolean',
    ];

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
     * Check if answer is correct
     */
    public function checkAnswer($answer)
    {
        return strtolower(trim($answer)) === strtolower(trim($this->correct_answer));
    }
}
