<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use App\Models\Admin;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Dashboard admin
     */
    public function index()
    {
        $totalGames = Game::count();
        $totalQuestions = Question::count();
        $activeGames = Game::where('is_active', true)->count();
        
        return view('admin.dashboard', compact('totalGames', 'totalQuestions', 'activeGames'));
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 1. Cek tabel admins (Super Admin & Admin Biasa)
        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_role' => $admin->role,
            ]);
            
            return redirect()->route('admin.dashboard');
        }

        // 2. Cek tabel teachers (Guru) - Unifikasi Login
        $teacher = Teacher::where('username', $request->username)->first();

        if ($teacher && Hash::check($request->password, $teacher->password)) {
            // Cek status approval
            if ($teacher->status !== 'approved') {
                return back()->with('error', 'Akun Guru Anda belum disetujui oleh Super Admin.');
            }

            session([
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->name,
                'teacher_username' => $teacher->username,
            ]);

            return redirect()->route('teacher.dashboard');
        }
        
        return back()->with('error', 'Username atau password salah!');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        session()->forget([
            'admin_logged_in', 'admin_id', 'admin_name', 'admin_role',
            'teacher_id', 'teacher_name', 'teacher_username'
        ]);
        return redirect()->route('admin.login')->with('success', 'Berhasil logout!');
    }

    // ==================== GAMES MANAGEMENT ====================


    /**
     * Show create game form
     */
    public function createGame()
    {
        return view('admin.games.create');
    }

    /**
     * Store new game
     */
    public function storeGame(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'class_level' => 'required|integer|min:0|max:6',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'game_type' => 'required|string|in:matching,multiple_choice,fill_blank,custom_code',
        ]);


        $data = $request->all();
        
        // Generate unique slug
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Game::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $data['slug'] = $slug;
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/games'), $filename);
            $data['thumbnail'] = 'images/games/' . $filename;
        }

        // Track who created the game (teacher or admin)
        $data['created_by'] = session('teacher_id') ?? session('admin_id') ?? null;
        
        // If teacher created the game, set teacher_id
        if (session('teacher_id')) {
            $data['teacher_id'] = session('teacher_id');
        }

        Game::create($data);

        // Redirect based on who created the game
        $redirectRoute = request()->is('teacher/*') ? 'teacher.games' : 'admin.games';
        return redirect()->route($redirectRoute)->with('success', 'Game berhasil ditambahkan!');
    }

    /**
     * Show edit game form
     */
    public function editGame($id)
    {
        $game = Game::findOrFail($id);
        
        // Teacher can only edit their own games
        if (session('teacher_id') && $game->created_by != session('teacher_id')) {
            abort(403, 'Anda tidak memiliki akses ke game ini.');
        }
        
        return view('admin.games.edit', compact('game'));
    }

    /**
     * Update game
     */
    public function updateGame(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        
        // Teacher can only update their own games
        if (session('teacher_id') && $game->created_by != session('teacher_id')) {
            abort(403, 'Anda tidak memiliki akses ke game ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'game_type' => 'required|string|in:matching,multiple_choice,fill_blank,custom_code',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Auto-save teacher_id if teacher is creating the game
        if (session('teacher_id')) {
            $data['teacher_id'] = session('teacher_id');
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
                unlink(public_path($game->thumbnail));
            }
            
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/games'), $filename);
            $data['thumbnail'] = 'images/games/' . $filename;
        }

        $game->update($data);

        return redirect()->route('admin.games')->with('success', 'Game berhasil diupdate!');
    }

    /**
     * Delete game
     */
    public function deleteGame($id)
    {
        $game = Game::findOrFail($id);
        
        // Teacher can only delete their own games
        if (session('teacher_id') && $game->created_by != session('teacher_id')) {
            abort(403, 'Anda tidak memiliki akses ke game ini.');
        }
        
        // Delete thumbnail
        if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
            unlink(public_path($game->thumbnail));
        }
        
        $game->delete();

        return redirect()->route('admin.games')->with('success', 'Game berhasil dihapus!');
    }

    // ==================== QUESTIONS MANAGEMENT ====================

    /**
     * List questions for a specific game
     */
    public function questions($gameId)
    {
        $game = Game::findOrFail($gameId);
        $questions = Question::where('game_id', $gameId)->get();
        
        return view('admin.questions.index', compact('game', 'questions'));
    }

    /**
     * Show create question form
     */
    public function createQuestion($gameId)
    {
        $game = Game::findOrFail($gameId);
        return view('admin.questions.create', compact('game'));
    }

    /**
     * Store new question
     */
    public function storeQuestion(Request $request, $gameId)
    {
        // Check if this is matching game with multiple pairs
        if ($request->has('pairs')) {
            // Matching game with multiple pairs
            $request->validate([
                'game_id' => 'required|exists:games,id',
                'pairs' => 'required|array|min:3|max:10',
                'pairs.*.word1' => 'required|string',
                'pairs.*.word2' => 'required|string',
                'points' => 'nullable|integer|min:1',
                'difficulty' => 'nullable|in:easy,medium,hard',
            ]);

            // Create multiple questions from pairs
            foreach ($request->pairs as $pair) {
                Question::create([
                    'game_id' => $request->game_id,
                    'question_text' => $pair['word1'],
                    'correct_answer' => $pair['word2'],
                    'points' => $request->points ?? 10,
                    'difficulty' => $request->difficulty ?? 'medium',
                ]);
            }

            return redirect()->route('admin.questions', $request->game_id)
                ->with('success', count($request->pairs) . ' pasangan kata berhasil ditambahkan!');
        }

        // Standard question (non-matching game)
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'question_text' => 'required|string',
            'correct_answer' => 'required|string',
            'points' => 'nullable|integer|min:1',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/questions'), $imageName);
            $data['image'] = 'images/questions/' . $imageName;
        }
        
        // Handle question_data (untuk data tambahan seperti gambar, grid TTS, dll)
        if ($request->has('question_data')) {
            $data['question_data'] = $request->question_data;
        }

        // Handle options (untuk multiple choice)
        if ($request->has('options')) {
            $data['options'] = $request->options;
        }

        Question::create($data);

        return redirect()->route('admin.questions', $request->game_id)
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Show edit question form
     */
    public function editQuestion($id)
    {
        $question = Question::with('game')->findOrFail($id);
        return view('admin.questions.edit', compact('question'));
    }

    /**
     * Update question
     */
    public function updateQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string',
            'points' => 'nullable|integer|min:1',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($question->image && file_exists(public_path($question->image))) {
                unlink(public_path($question->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/questions'), $imageName);
            $data['image'] = 'images/questions/' . $imageName;
        }
        
        if ($request->has('question_data')) {
            $data['question_data'] = $request->question_data;
        }

        if ($request->has('options')) {
            $data['options'] = $request->options;
        }

        $question->update($data);

        return redirect()->route('admin.questions', $question->game_id)
            ->with('success', 'Soal berhasil diupdate!');
    }

    /**
     * Delete question
     */
    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $gameId = $question->game_id;
        
        // Delete image if exists
        if ($question->image && file_exists(public_path($question->image))) {
            unlink(public_path($question->image));
        }
        
        $question->delete();

        return redirect()->route('admin.questions', $gameId)
            ->with('success', 'Soal berhasil dihapus!');
    }

    // ==================== PARENTS MANAGEMENT ====================

    /**
     * Show games list (admin sees teachers list, teacher sees only their own)
     */
    public function games()
    {
        // Check if this is a teacher route (not admin)
        $isTeacherRoute = request()->is('teacher/*');
        
        if ($isTeacherRoute && session('teacher_id')) {
            // Teacher: show only their own games
            $games = Game::with('teacher')
                ->where('teacher_id', session('teacher_id'))
                ->orderBy('created_at', 'desc')
                ->get();
            $isTeacher = true;
            return view('admin.games.index', compact('games', 'isTeacher'));
        } else {
            // Super Admin: show list of teachers with game counts
            $teachers = Teacher::where('status', 'approved')
                ->get()
                ->map(function($teacher) {
                    $teacher->games_count = Game::where('teacher_id', $teacher->id)->count();
                    $teacher->active_games_count = Game::where('teacher_id', $teacher->id)
                        ->where('is_active', true)
                        ->count();
                    return $teacher;
                })
                ->filter(function($teacher) {
                    return $teacher->games_count > 0;
                })
                ->sortBy('name');
            
            return view('admin.games.teachers-list', compact('teachers'));
        }
    }

    // Official Games Methods
    public function officialGames()
    {
        $activeTab = request('tab', 'arab');
        
        $arabicGames = Game::where('is_official', true)
            ->where('language', 'arab')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $englishGames = Game::where('is_official', true)
            ->where('language', 'inggris')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.official-games.index', compact('arabicGames', 'englishGames', 'activeTab'));
    }

    public function createOfficialGame()
    {
        return view('admin.official-games.create');
    }

    public function storeOfficialGame(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category' => 'required|string',
            'language' => 'required|in:arab,inggris',
            'class_level' => 'nullable|integer|min:1|max:6',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);

        $game = new Game();
        $game->title = $request->title;
        $game->slug = Str::slug($request->title);
        $game->description = $request->description;
        $game->category = $request->category;
        $game->language = $request->language;
        $game->class_level = $request->class_level;
        $game->is_official = true;
        $game->is_active = true;

        if ($request->hasFile('thumbnail')) {
            $imageName = time().'.'.$request->thumbnail->extension();
            $request->thumbnail->move(public_path('images/games'), $imageName);
            $game->thumbnail = 'images/games/'.$imageName;
        }

        $game->save();

        return redirect()->route('admin.official-games', ['tab' => $request->language])
            ->with('success', 'Game Official berhasil ditambahkan!');
    }

    public function editOfficialGame($id)
    {
        $game = Game::where('is_official', true)->findOrFail($id);
        return view('admin.official-games.edit', compact('game'));
    }

    public function updateOfficialGame(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category' => 'required|string',
            'language' => 'required|in:arab,inggris',
            'class_level' => 'nullable|integer|min:1|max:6',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);

        $game = Game::where('is_official', true)->findOrFail($id);
        $game->title = $request->title;
        $game->slug = Str::slug($request->title);
        $game->description = $request->description;
        $game->category = $request->category;
        $game->language = $request->language;
        $game->class_level = $request->class_level;
        
        if ($request->hasFile('thumbnail')) {
            // Delete old image
            if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
                unlink(public_path($game->thumbnail));
            }
            
            $imageName = time().'.'.$request->thumbnail->extension();
            $request->thumbnail->move(public_path('images/games'), $imageName);
            $game->thumbnail = 'images/games/'.$imageName;
        }

        $game->save();

        return redirect()->route('admin.official-games', ['tab' => $request->language])
            ->with('success', 'Game Official berhasil diupdate!');
    }

    public function deleteOfficialGame($id)
    {
        $game = Game::where('is_official', true)->findOrFail($id);
        
        // Delete thumbnail if exists
        if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
            unlink(public_path($game->thumbnail));
        }
        
        $game->delete();

        return redirect()->route('admin.official-games')
            ->with('success', 'Game Official berhasil dihapus!');
    }

    /**
     * Show games by specific teacher (admin only)
     */
    public function gamesByTeacher($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $games = Game::with('teacher')
            ->where('teacher_id', $teacherId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.games.by-teacher', compact('teacher', 'games'));
    }

    /**
     * List all parents
     */
    public function parents()
    {
        $parents = \App\Models\OrangTua::withCount('students')->get();
        return view('admin.parents.index', compact('parents'));
    }

    /**
     * Show create parent form
     */
    public function createParent()
    {
        return view('admin.parents.create');
    }

    /**
     * Store new parent
     */
    public function storeParent(Request $request)
    {
        $request->validate([
            'parent_name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'email' => 'required|email|unique:parents,email',
            'password' => 'required|string|min:6',
        ]);

        \App\Models\OrangTua::create([
            'parent_name' => $request->parent_name,
            'gender' => $request->gender,
            'child_name' => $request->child_name ?? '',
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route('admin.parents')->with('success', 'Orang tua berhasil ditambahkan!');
    }

    /**
     * Show edit parent form
     */
    public function editParent($id)
    {
        $parent = \App\Models\OrangTua::findOrFail($id);
        return view('admin.parents.edit', compact('parent'));
    }

    /**
     * Update parent
     */
    public function updateParent(Request $request, $id)
    {
        $parent = \App\Models\OrangTua::findOrFail($id);

        $request->validate([
            'parent_name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'parent_name' => $request->parent_name,
            'child_name' => $request->child_name ?? '',
            'email' => $request->email,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $parent->update($data);

        return redirect()->route('admin.parents')->with('success', 'Orang tua berhasil diupdate!');
    }

    /**
     * Delete parent
     */
    public function deleteParent($id)
    {
        $parent = \App\Models\OrangTua::findOrFail($id);
        $parent->delete();

        return redirect()->route('admin.parents')->with('success', 'Orang tua berhasil dihapus!');
    }

    // ==================== POSTERS MANAGEMENT ====================

    public function posters()
    {
        $activeTab = request('tab', 'arab');
        
        $posters = \App\Models\Poster::orderBy('created_at', 'desc')->get();
        $arabPosters = $posters->where('category', 'arab');
        $englishPosters = $posters->where('category', 'inggris');
        
        return view('admin.posters.index', compact('arabPosters', 'englishPosters', 'activeTab'));
    }

    public function createPoster()
    {
        return view('admin.posters.create');
    }

    public function storePoster(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:arab,inggris',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/posters'), $imageName);

        \App\Models\Poster::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image' => 'images/posters/' . $imageName,
            'is_active' => true,
        ]);

        return redirect()->route('admin.posters', ['tab' => $request->category])
            ->with('success', 'Poster berhasil diupload!');
    }

    public function deletePoster($id)
    {
        $poster = \App\Models\Poster::findOrFail($id);
        
        if (file_exists(public_path($poster->image))) {
            unlink(public_path($poster->image));
        }

        $poster->delete();

        return redirect()->route('admin.posters')
            ->with('success', 'Poster berhasil dihapus!');
    }

    // ==================== STUDENTS MANAGEMENT ====================

    /**
     * List all students
     */
    public function students()
    {
        $students = \App\Models\Student::with('orangtua')->get();
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show create student form
     */
    public function createStudent()
    {
        $parents = \App\Models\OrangTua::all();
        return view('admin.students.create', compact('parents'));
    }

    /**
     * Store new student
     */
    public function storeStudent(Request $request)
    {
        $request->validate([
            'nama_anak' => 'required|string|max:255',
            'kelas' => 'required|integer|min:1|max:6',
            'parent_id' => 'required|exists:parents,id',
        ]);

        \App\Models\Student::create($request->all());

        return redirect()->route('admin.students')->with('success', 'Anak berhasil ditambahkan!');
    }

    /**
     * Show edit student form
     */
    public function editStudent($id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $parents = \App\Models\OrangTua::all();
        return view('admin.students.edit', compact('student', 'parents'));
    }

    /**
     * Update student
     */
    public function updateStudent(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);

        $request->validate([
            'nama_anak' => 'required|string|max:255',
            'kelas' => 'required|integer|min:1|max:6',
            'parent_id' => 'required|exists:parents,id',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students')->with('success', 'Data anak berhasil diupdate!');
    }

    /**
     * Delete student
     */
    public function deleteStudent($id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $student->delete();

    }

}
