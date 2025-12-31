<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Student;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules
     */
    public function index()
    {
        $schedules = Schedule::with('student')->orderBy('day')->orderBy('time')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create()
    {
        $students = Student::orderBy('nama_anak')->get();
        return view('admin.schedules.create', compact('students'));
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'day' => 'required|string',
            'time' => 'required',
            'mentor' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['subject'] = '-'; // Default value since field removed from form

        Schedule::create($data);

        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified schedule
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $students = Student::orderBy('nama_anak')->get();
        return view('admin.schedules.edit', compact('schedule', 'students'));
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'day' => 'required|string',
            'time' => 'required',
            'mentor' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil diupdate!');
    }

    /**
     * Remove the specified schedule
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil dihapus!');
    }
}
