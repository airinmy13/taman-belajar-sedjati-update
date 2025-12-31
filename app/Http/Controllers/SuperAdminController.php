<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('super-admin.dashboard');
    }

    public function teachers()
    {
        $teachers = Teacher::all();
        return view('super-admin.teachers.index', compact('teachers'));
    }

    public function approve($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->status = 'approved';
        $teacher->save();

        // Send approval email
        try {
            Mail::send('emails.teacher-approved', ['teacher' => $teacher], function($message) use ($teacher) {
                $message->to($teacher->email)
                        ->subject('Akun Guru Disetujui - Platform Game Edukasi');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the approval
        }

        return redirect()->route('super-admin.teachers')->with('success', 'Guru berhasil disetujui! Email notifikasi telah dikirim.');
    }

    public function reject($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->status = 'rejected';
        $teacher->save();

        // Send rejection email
        try {
            Mail::send('emails.teacher-rejected', ['teacher' => $teacher], function($message) use ($teacher) {
                $message->to($teacher->email)
                        ->subject('Pemberitahuan Pendaftaran Guru');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the rejection
        }

        return redirect()->route('super-admin.teachers')->with('success', 'Pendaftaran guru ditolak.');
    }

    public function create()
    {
        return view('super-admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:teachers',
            'email' => 'required|email|unique:teachers',
            'password' => 'required|string|min:6',
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
            'status' => 'approved', // Manual creation = auto approved
        ]);

        return redirect()->route('super-admin.teachers')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('super-admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:teachers,username,' . $id,
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'required|string',
            'subjects' => 'required|array|min:1',
        ]);

        $teacher->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'subjects' => $request->subjects,
        ]);

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->password);
            $teacher->save();
        }

        return redirect()->route('super-admin.teachers')->with('success', 'Data guru berhasil diupdate!');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('super-admin.teachers')->with('success', 'Guru berhasil dihapus!');
    }
}
