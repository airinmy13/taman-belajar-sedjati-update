<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\Student;
use App\Models\GameSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('parent.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        // Find parent by username
        $parent = OrangTua::where('username', $request->username)->first();

        // Check if parent exists and password matches
        if ($parent && Hash::check($request->password, $parent->password)) {
            session([
                'parent_id' => $parent->id,
                'parent_name' => $parent->parent_name
            ]);

            return redirect()->route('parent.dashboard');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    /**
     * Show parent dashboard
     */
    public function dashboard()
    {
        if (!session('parent_id')) {
            return redirect()->route('parent.login');
        }

        $parent = OrangTua::with('students')->findOrFail(session('parent_id'));
        
        // Get all children of this parent
        $students = $parent->students;

        // Get game sessions for all children
        $allSessions = [];
        $totalGamesPlayed = 0;
        $totalScore = 0;
        $totalQuestions = 0;
        $totalCorrect = 0;

        foreach ($students as $student) {
            $sessions = GameSession::with('game')
                ->where('student_id', $student->id)
                ->where('completed_at', '!=', null)
                ->orderBy('completed_at', 'desc')
                ->get();

            $allSessions[$student->id] = $sessions;
            
            // Calculate totals
            $totalGamesPlayed += $sessions->count();
            $totalScore += $sessions->sum('total_score');
            $totalQuestions += $sessions->sum('total_questions');
            $totalCorrect += $sessions->sum('correct_answers');
        }

        // Get schedules for all children
        $studentIds = $students->pluck('id')->toArray();
        $schedules = \App\Models\Schedule::whereIn('student_id', $studentIds)
            ->with('student')
            ->orderBy('day', 'asc')
            ->orderBy('time', 'asc')
            ->get();
        $overallAccuracy = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100) : 0;

        return view('parent.dashboard', compact(
            'parent',
            'students',
            'allSessions',
            'totalGamesPlayed',
            'totalScore',
            'overallAccuracy',
            'schedules'
        ));
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->forget(['parent_id', 'parent_name']);
        return redirect()->route('parent.login')->with('success', 'Berhasil logout');
    }
}