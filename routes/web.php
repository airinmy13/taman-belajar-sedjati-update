<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeacherRegistrationController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\CheckStudentLogin;
use App\Http\Middleware\CheckAdminLogin;
use App\Http\Middleware\CheckParentLogin;

// Route home
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    
    Route::middleware(['CheckAdminLogin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // ==================== SUPER ADMIN ONLY ====================
        Route::middleware(['CheckSuperAdmin'])->group(function () {
            // Teacher Games management (SUPER ADMIN ONLY)
            Route::get('/games', [AdminController::class, 'games'])->name('admin.games');
            Route::get('/games/teacher/{teacherId}', [AdminController::class, 'gamesByTeacher'])->name('admin.games.by-teacher');
            Route::get('/games/create', [AdminController::class, 'createGame'])->name('admin.games.create');
            Route::post('/games', [AdminController::class, 'storeGame'])->name('admin.games.store');
            Route::get('/games/{id}/edit', [AdminController::class, 'editGame'])->name('admin.games.edit');
            Route::put('/games/{id}', [AdminController::class, 'updateGame'])->name('admin.games.update');
            Route::delete('/games/{id}', [AdminController::class, 'deleteGame'])->name('admin.games.delete');
        });
        
        // ==================== BOTH SUPER ADMIN & REGULAR ADMIN ====================
        
        // Official Games management
        Route::get('/official-games', [AdminController::class, 'officialGames'])->name('admin.official-games');
        Route::get('/official-games/create', [AdminController::class, 'createOfficialGame'])->name('admin.official-games.create');
        Route::post('/official-games', [AdminController::class, 'storeOfficialGame'])->name('admin.official-games.store');
        Route::get('/official-games/{id}/edit', [AdminController::class, 'editOfficialGame'])->name('admin.official-games.edit');
        Route::put('/official-games/{id}', [AdminController::class, 'updateOfficialGame'])->name('admin.official-games.update');
        Route::delete('/official-games/{id}', [AdminController::class, 'deleteOfficialGame'])->name('admin.official-games.delete');

        // Questions management (For Official Games & Teacher Games if Super Admin)
        Route::get('/games/{gameId}/questions', [AdminController::class, 'questions'])->name('admin.questions');
        Route::get('/games/{gameId}/questions/create', [AdminController::class, 'createQuestion'])->name('admin.questions.create');
        Route::post('/games/{gameId}/questions', [AdminController::class, 'storeQuestion'])->name('admin.questions.store');
        Route::get('/questions/{id}/edit', [AdminController::class, 'editQuestion'])->name('admin.questions.edit');
        Route::put('/questions/{id}', [AdminController::class, 'updateQuestion'])->name('admin.questions.update');
        Route::delete('/questions/{id}', [AdminController::class, 'deleteQuestion'])->name('admin.questions.delete');

        // Posters Management
        Route::get('/posters', [AdminController::class, 'posters'])->name('admin.posters');
        Route::get('/posters/create', [AdminController::class, 'createPoster'])->name('admin.posters.create');
        Route::post('/posters', [AdminController::class, 'storePoster'])->name('admin.posters.store');
        Route::delete('/posters/{id}', [AdminController::class, 'deletePoster'])->name('admin.posters.delete');

        // Parents management
        Route::get('/parents', [AdminController::class, 'parents'])->name('admin.parents');
        Route::get('/parents/create', [AdminController::class, 'createParent'])->name('admin.parents.create');
        Route::post('/parents', [AdminController::class, 'storeParent'])->name('admin.parents.store');
        Route::get('/parents/{id}/edit', [AdminController::class, 'editParent'])->name('admin.parents.edit');
        Route::put('/parents/{id}', [AdminController::class, 'updateParent'])->name('admin.parents.update');
        Route::delete('/parents/{id}', [AdminController::class, 'deleteParent'])->name('admin.parents.delete');
        
        // Parent Registration Approval
        Route::get('/parent-registrations', [\App\Http\Controllers\ParentRegistrationController::class, 'index'])->name('admin.parent-registrations');
        Route::post('/parent-registrations/{id}/approve', [\App\Http\Controllers\ParentRegistrationController::class, 'approve'])->name('admin.parent-registrations.approve');
        Route::post('/parent-registrations/{id}/reject', [\App\Http\Controllers\ParentRegistrationController::class, 'reject'])->name('admin.parent-registrations.reject');
        
        // Students management
        Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
        Route::get('/students/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('admin.students.store');
        Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
        Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
        Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('admin.students.delete');
        
        // Posters management
        Route::get('/posters', [AdminController::class, 'posters'])->name('admin.posters');
        Route::get('/posters/create', [AdminController::class, 'createPoster'])->name('admin.posters.create');
        Route::post('/posters', [AdminController::class, 'storePoster'])->name('admin.posters.store');
        Route::get('/posters/{id}/edit', [AdminController::class, 'editPoster'])->name('admin.posters.edit');
        Route::put('/posters/{id}', [AdminController::class, 'updatePoster'])->name('admin.posters.update');
        Route::delete('/posters/{id}', [AdminController::class, 'deletePoster'])->name('admin.posters.delete');
        
        // Schedules management
        Route::get('/schedules', [\App\Http\Controllers\ScheduleController::class, 'index'])->name('admin.schedules');
        Route::get('/schedules/create', [\App\Http\Controllers\ScheduleController::class, 'create'])->name('admin.schedules.create');
        Route::post('/schedules', [\App\Http\Controllers\ScheduleController::class, 'store'])->name('admin.schedules.store');
        Route::get('/schedules/{id}/edit', [\App\Http\Controllers\ScheduleController::class, 'edit'])->name('admin.schedules.edit');
        Route::put('/schedules/{id}', [\App\Http\Controllers\ScheduleController::class, 'update'])->name('admin.schedules.update');
        Route::delete('/schedules/{id}', [\App\Http\Controllers\ScheduleController::class, 'destroy'])->name('admin.schedules.delete');
    });
});

// ==================== STUDENT ROUTES ====================
// Route login student
Route::post('/student/login', [StudentController::class, 'login'])->name('student.login');
Route::get('/student/logout', [StudentController::class, 'logout'])->name('student.logout');

// Route start game - bisa diakses sebelum login (akan redirect ke home jika belum login)
Route::get('/games/{slug}/start', function($slug) {
    // Fallback jika user akses via GET, redirect ke POST
    return redirect()->route('games.show', $slug);
});
Route::post('/games/{slug}/start', [GameController::class, 'start'])->name('games.start');

// Route games - HARUS LOGIN DULU
Route::middleware(['CheckStudentLogin'])->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/all', [GameController::class, 'all'])->name('games.all');
    Route::get('/games/{slug}', [GameController::class, 'show'])->name('games.show');
    Route::get('/session/{id}/question', [GameController::class, 'getQuestion'])->name('games.question');
    Route::post('/session/{id}/answer', [GameController::class, 'submitAnswer'])->name('games.answer');
    Route::get('/session/{id}/finish', [GameController::class, 'finish'])->name('games.finish');
    Route::post('/session/{id}/retry', [GameController::class, 'retry'])->name('games.retry');
});

// ==================== PARENT ROUTES ====================
// Parent Registration (Public)
Route::get('/parent/register', [\App\Http\Controllers\ParentRegistrationController::class, 'showRegistrationForm'])->name('parent.register');
Route::post('/parent/register', [\App\Http\Controllers\ParentRegistrationController::class, 'register'])->name('parent.register.submit');
Route::get('/parent/register/success', [\App\Http\Controllers\ParentRegistrationController::class, 'showSuccessPage'])->name('parent.register.success');

// Parent Login
Route::get('/parent/login', [ParentController::class, 'showLoginForm'])->name('parent.login');
Route::post('/parent/login', [ParentController::class, 'login'])->name('parent.login.post');

Route::middleware(['CheckParentLogin'])->group(function () {
    Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
    Route::get('/parent/logout', [ParentController::class, 'logout'])->name('parent.logout');
});

// ==================== TEACHER REGISTRATION ROUTES ====================
Route::get('/teacher/register', [TeacherRegistrationController::class, 'showRegistrationForm'])->name('teacher.register');
Route::post('/teacher/register', [TeacherRegistrationController::class, 'register'])->name('teacher.register.post');

// ==================== TEACHER ROUTES ====================
Route::get('/teacher/login', [TeacherController::class, 'showLogin'])->name('teacher.login');
Route::post('/teacher/login', [TeacherController::class, 'login'])->name('teacher.login.post');

Route::middleware(['CheckTeacherLogin'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/teacher/logout', [TeacherController::class, 'logout'])->name('teacher.logout');
    
    // Teacher Game Management (Own games only - filtered in controller)
    Route::get('/teacher/games', [AdminController::class, 'games'])->name('teacher.games');
    Route::get('/teacher/games/create', [AdminController::class, 'createGame'])->name('teacher.games.create');
    Route::post('/teacher/games', [AdminController::class, 'storeGame'])->name('teacher.games.store');
    Route::get('/teacher/games/{id}/edit', [AdminController::class, 'editGame'])->name('teacher.games.edit');
    Route::put('/teacher/games/{id}', [AdminController::class, 'updateGame'])->name('teacher.games.update');
    Route::delete('/teacher/games/{id}', [AdminController::class, 'deleteGame'])->name('teacher.games.delete');
    
    // Teacher Question Management (Own questions only)
    Route::get('/teacher/games/{gameId}/questions', [AdminController::class, 'questions'])->name('teacher.questions');
    Route::get('/teacher/games/{gameId}/questions/create', [AdminController::class, 'createQuestion'])->name('teacher.questions.create');
    Route::post('/teacher/games/{gameId}/questions', [AdminController::class, 'storeQuestion'])->name('teacher.questions.store');
    Route::get('/teacher/questions/{id}/edit', [AdminController::class, 'editQuestion'])->name('teacher.questions.edit');
    Route::put('/teacher/questions/{id}', [AdminController::class, 'updateQuestion'])->name('teacher.questions.update');
    Route::delete('/teacher/questions/{id}', [AdminController::class, 'deleteQuestion'])->name('teacher.questions.delete');
});

// ==================== SUPER ADMIN ROUTES ====================
Route::prefix('super-admin')->middleware(['CheckAdminLogin'])->group(function () {
    // Teacher View - Both Super Admin & Regular Admin can view
    Route::get('/teachers', [SuperAdminController::class, 'teachers'])->name('super-admin.teachers');
    
    // Super Admin ONLY routes
    Route::middleware(['CheckSuperAdmin'])->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
        
        // Teacher Management (Super Admin ONLY)
        Route::post('/teachers/{id}/approve', [SuperAdminController::class, 'approve'])->name('super-admin.teachers.approve');
        Route::post('/teachers/{id}/reject', [SuperAdminController::class, 'reject'])->name('super-admin.teachers.reject');
        Route::get('/teachers/create', [SuperAdminController::class, 'create'])->name('super-admin.teachers.create');
        Route::post('/teachers', [SuperAdminController::class, 'store'])->name('super-admin.teachers.store');
        Route::get('/teachers/{id}/edit', [SuperAdminController::class, 'edit'])->name('super-admin.teachers.edit');
        Route::put('/teachers/{id}', [SuperAdminController::class, 'update'])->name('super-admin.teachers.update');
        Route::delete('/teachers/{id}', [SuperAdminController::class, 'destroy'])->name('super-admin.teachers.destroy');
    });
});

// ==================== PUBLIC POSTER ROUTE ====================
Route::get('/posters', [App\Http\Controllers\PosterController::class, 'index'])->name('posters.index');