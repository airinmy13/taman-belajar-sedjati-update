<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 24px; }
        .btn { padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; transition: all 0.3s; border: none; cursor: pointer; display: inline-block; }
        .btn-light { background: white; color: #667eea; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .container { max-width: 800px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #667eea; }
        .error { color: #ef4444; font-size: 12px; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>✏️ Edit Jadwal Les</h1>
        <a href="{{ route('admin.schedules') }}" class="btn btn-light">← Kembali</a>
    </div>

    <div class="container">
        <div class="card">
            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="student_id">Nama Anak *</label>
                    <select name="student_id" id="student_id" required>
                        <option value="">-- Pilih Anak --</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ ($schedule->student_id == $student->id) ? 'selected' : '' }}>
                            {{ $student->name }} (Kelas: {{ $student->level->name ?? '-' }})
                        </option>
                        @endforeach
                    </select>
                    @error('student_id')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject">Mata Pelajaran *</label>
                    <input type="text" name="subject" id="subject" value="{{ $schedule->subject }}" required>
                    @error('subject')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="day">Hari *</label>
                    <select name="day" id="day" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin" {{ $schedule->day == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ $schedule->day == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ $schedule->day == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ $schedule->day == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ $schedule->day == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ $schedule->day == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ $schedule->day == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                    @error('day')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="time">Jam *</label>
                    <input type="time" name="time" id="time" value="{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}" required>
                    @error('time')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mentor">Nama Mentor *</label>
                    <input type="text" name="mentor" id="mentor" value="{{ $schedule->mentor }}" required>
                    @error('mentor')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Catatan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3">{{ $schedule->notes }}</textarea>
                    @error('notes')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 16px;">
                    💾 Update Jadwal
                </button>
            </form>
        </div>
    </div>
</body>
</html>
