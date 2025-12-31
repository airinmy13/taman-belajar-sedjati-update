<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 24px; }
        .btn { padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; transition: all 0.3s; border: none; cursor: pointer; display: inline-block; }
        .btn-light { background: white; color: #667eea; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-success { background: #10b981; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #374151; }
        tr:hover { background: #f9fafb; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
        .empty-state-icon { font-size: 64px; margin-bottom: 20px; }
        .actions { display: flex; gap: 10px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📅 Kelola Jadwal Les</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">← Kembali ke Dashboard</a>
    </div>

    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Daftar Jadwal Les Anak</h2>
                <a href="{{ route('admin.schedules.create') }}" class="btn btn-success">+ Tambah Jadwal</a>
            </div>

            @if($schedules->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Nama Anak</th>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mentor</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                    <tr>
                        <td><strong>{{ $schedule->student->name }}</strong></td>
                        <td>{{ $schedule->subject }}</td>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</td>
                        <td>{{ $schedule->mentor }}</td>
                        <td>{{ $schedule->notes ?? '-' }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Edit</a>
                                <form action="{{ route('admin.schedules.delete', $schedule->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-state-icon">📅</div>
                <h3>Belum Ada Jadwal</h3>
                <p>Klik tombol "Tambah Jadwal" untuk membuat jadwal les pertama</p>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
