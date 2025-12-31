<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TeacherRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('teacher-registration.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:teachers',
            'email' => 'required|email|unique:teachers',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string',
            'subjects' => 'required|array|min:1',
        ]);

        Teacher::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'subjects' => $request->subjects,
            'status' => 'pending', // Menunggu approval super admin
        ]);

        return view('teacher-registration.success');
    }
}
