<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Poster;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // 1. Get Posters (active & ordered) - Only 3 latest per category
    $arabPosters = Poster::where('is_active', true)
        ->where('category', 'arab')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
    
    $englishPosters = Poster::where('is_active', true)
        ->where('category', 'inggris')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

        // Check if student is logged in and has a class
        $studentClass = session('student_class');

        // 2. Get Official Games
        $officialGamesQuery = Game::where('is_active', true)
            ->where('is_official', true)
            ->orderBy('created_at', 'desc');

        if ($studentClass) {
            $officialGamesQuery->where(function($q) use ($studentClass) {
                $q->where('class_level', $studentClass)
                  ->orWhere('class_level', 0) // Show "Semua Kelas" games
                  ->orWhereNull('class_level'); // Show old games without class_level
            });
        }
            
        $officialGames = $officialGamesQuery->take(6)->get();
            
        // 3. Get Mentor Games (Non-Official)
        $mentorGamesQuery = Game::with('teacher')->where('is_active', true)
            ->where(function($q) {
                $q->where('is_official', false)
                  ->orWhereNull('is_official');
            })
            ->whereNotNull('teacher_id')
            ->orderBy('created_at', 'desc');

        if ($studentClass) {
            $mentorGamesQuery->where(function($q) use ($studentClass) {
                $q->where('class_level', $studentClass)
                  ->orWhere('class_level', 0) // Show "Semua Kelas" games
                  ->orWhereNull('class_level'); // Show old games without class_level
            });
        }

        $mentorGames = $mentorGamesQuery->take(8)->get();

        return view('home', compact('arabPosters', 'englishPosters', 'officialGames', 'mentorGames'));
    }
}
