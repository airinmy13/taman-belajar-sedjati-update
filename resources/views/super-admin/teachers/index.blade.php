<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .badge-pending { background: #ffc107; }
        .badge-approved { background: #28a745; }
        .badge-rejected { background: #dc3545; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('super-admin.dashboard') }}">⭐ Super Admin</a>
            <a href="{{ route('admin.logout') }}" class="btn btn-light btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>👨‍🏫 Kelola Guru</h2>
            @if(session('admin_role') == 'super_admin')
            <a href="{{ route('super-admin.teachers.create') }}" class="btn btn-primary">+ Tambah Guru Manual</a>
            @endif
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tabs --}}
        <ul class="nav nav-tabs" id="teacherTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                    Guru Aktif ({{ $teachers->where('status', 'approved')->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                    Menunggu Konfirmasi 
                    @if($teachers->where('status', 'pending')->count() > 0)
                    <span class="badge bg-warning text-dark">{{ $teachers->where('status', 'pending')->count() }}</span>
                    @endif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                    Ditolak ({{ $teachers->where('status', 'rejected')->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="teacherTabsContent">
            {{-- Tab 1: Approved --}}
            <div class="tab-pane fade show active" id="approved" role="tabpanel">
                <div class="card mt-3">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers->where('status', 'approved') as $teacher)
                                <tr>
                                    <td>{{ $teacher->name }}</td>
                                    <td><strong>{{ $teacher->username }}</strong></td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ implode(', ', $teacher->subjects ?? []) }}</td>
                                    <td>
                                        @if(session('admin_role') == 'super_admin')
                                        <a href="{{ route('super-admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('super-admin.teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center">Belum ada guru aktif</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tab 2: Pending --}}
            <div class="tab-pane fade" id="pending" role="tabpanel">
                <div class="card mt-3">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Tgl Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers->where('status', 'pending') as $teacher)
                                <tr>
                                    <td>{{ $teacher->name }}</td>
                                    <td><strong>{{ $teacher->username }}</strong></td>
                                    <td>{{ $teacher->email }}</td>
                                    <td><small>{{ implode(', ', $teacher->subjects ?? []) }}</small></td>
                                    <td>{{ $teacher->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if(session('admin_role') == 'super_admin')
                                        <form action="{{ route('super-admin.teachers.approve', $teacher->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">✅ Terima</button>
                                        </form>
                                        <form action="{{ route('super-admin.teachers.reject', $teacher->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin tolak pendaftaran ini?')">❌ Tolak</button>
                                        </form>
                                        @else
                                        <span class="badge badge-pending">Menunggu Approval</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">Tidak ada pendaftar baru</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tab 3: Rejected --}}
            <div class="tab-pane fade" id="rejected" role="tabpanel">
                <div class="card mt-3">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Tgl Ditolak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers->where('status', 'rejected') as $teacher)
                                <tr>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->updated_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('super-admin.teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus permanent?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center">Tidak ada data ditolak</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
