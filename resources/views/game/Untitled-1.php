<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Middleware\CheckStudentLogin;

// Route home
Route::get('/', function () {
    return view('home');
})->name('home');

// Route halaman pilihan game (tidak perlu login)
Route::get('/games', function () {
    return view('game.index');
})->name('games.index');

// Route login student
Route::post('/student/login', [StudentController::class, 'login'])->name('student.login');
Route::get('/student/logout', [StudentController::class, 'logout'])->name('student.logout');

// Route login parent
Route::post('/parent/login', [ParentController::class, 'login'])->name('parent.login');

// Route games - HARUS LOGIN DULU
Route::middleware([CheckStudentLogin::class])->group(function () {
    Route::get('/games/game1', function () {
        return view('game.game1');
    })->name('games.game1');
    
    // Nanti tambahkan game2, game3, game4 di sini
});