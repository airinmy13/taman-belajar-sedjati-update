<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Game;
use App\Models\GameSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function showLogin()
    {
        return view('teacher.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $teacher = Teacher::where('username', $request->username)->first();

        if ($teacher && Hash::check($request->password, $teacher->password)) {
            if ($teacher->status !== 'approved') {
                return back()->with('error', 'Akun Anda belum disetujui oleh Super Admin.');
            }


            // Clear any existing admin/parent/student sessions
            session()->forget(['admin_id', 'admin_role', 'parent_id', 'parent_name', 'student_id', 'student_name', 'student_class']);

            session([
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->name,
                'teacher_username' => $teacher->username,
            ]);

            return redirect()->route('teacher.dashboard');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function dashboard()
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::find($teacherId);

        // Get teacher's games
        $games = Game::where('created_by', $teacherId)->get();
        
        // Get student analytics
        $gameAnalytics = [];
        foreach ($games as $game) {
            $sessions = GameSession::where('game_id', $game->id)
                ->with(['student', 'student.orangTua'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            if ($sessions->count() > 0) {
                $gameAnalytics[$game->id] = [
                    'game' => $game,
                    'sessions' => $sessions
                ];
            }
        }

        $stats = [
            'total_games' => $games->count(),
            'total_questions' => $games->sum(function($game) {
                return $game->questions()->count();
            }),
            'templates_available' => 3, // Hardcoded for now (Multiple Choice, Fill in the Blank, etc.)
        ];

        return view('teacher.dashboard', compact('teacher', 'games', 'stats', 'gameAnalytics'));
    }

    public function logout()
    {
        session()->forget(['teacher_id', 'teacher_name', 'teacher_username']);
        return redirect()->route('teacher.login')->with('success', 'Berhasil logout!');
    }
}
