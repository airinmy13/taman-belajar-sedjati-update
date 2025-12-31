<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Pendaftaran Orang Tua - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 20px; }
        .card-header { padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .card-body { padding: 20px; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
        .info-item label { font-size: 12px; color: #666; display: block; margin-bottom: 5px; }
        .info-item div { font-weight: 500; color: #333; }
        .actions { display: flex; gap: 10px; justify-content: flex-end; }
        .btn { padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; border: none; cursor: pointer; color: white; transition: opacity 0.3s; }
        .btn:hover { opacity: 0.9; }
        .btn-success { background: #10b981; }
        .btn-danger { background: #ef4444; }
        .empty-state { text-align: center; padding: 60px; color: #666; }
        
        /* Modal Styles */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; opacity: 0; transition: opacity 0.3s; }
        .modal { background: white; padding: 30px; border-radius: 15px; width: 90%; max-width: 400px; text-align: center; transform: translateY(20px); transition: transform 0.3s; }
        .modal h3 { margin-bottom: 15px; color: #333; }
        .modal p { color: #666; margin-bottom: 25px; }
        .modal-actions { display: flex; gap: 10px; justify-content: center; }
        .modal.show { transform: translateY(0); }
        .modal-overlay.show { opacity: 1; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📝 Persetujuan Pendaftaran</h1>
        <div>
            <a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none;">Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h2>Daftar Pendaftaran Menunggu ({{ $registrations->count() }})</h2>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($registrations->count() > 0)
            @foreach($registrations as $reg)
                <div class="card">
                    <div class="card-header">
                        <div>
                            <strong>{{ $reg->parent_name }}</strong>
                            <span style="color: #666; font-size: 13px; margin-left: 10px;">{{ $reg->created_at->diffForHumans() }}</span>
                        </div>
                        <span style="background: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 15px; font-size: 12px; font-weight: bold;">Butuh Persetujuan</span>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Username Login</label>
                                <div>{{ $reg->username }}</div>
                            </div>
                            <div class="info-item">
                                <label>Email</label>
                                <div>{{ $reg->email }}</div>
                            </div>
                            <div class="info-item">
                                <label>No. HP</label>
                                <div>{{ $reg->phone }}</div>
                            </div>
                            <div class="info-item">
                                <label>Jenis Kelamin</label>
                                <div>{{ $reg->gender == 'L' ? '👨 Laki-laki' : '👩 Perempuan' }}</div>
                            </div>
                            <div class="info-item">
                                <label>Nama Anak</label>
                                <div>👶 {{ $reg->child_name }}</div>
                            </div>
                            <div class="info-item">
                                <label>Kelas Anak</label>
                                <div>📚 {{ $reg->child_class }}</div>
                            </div>
                        </div>
                        
                        <div class="actions">
                            <button type="button" onclick="showModal('reject', '{{ route('admin.parent-registrations.reject', $reg->id) }}')" class="btn btn-danger">Tolak</button>
                            <button type="button" onclick="showModal('approve', '{{ route('admin.parent-registrations.approve', $reg->id) }}')" class="btn btn-success">✅ Setujui & Buat Akun</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card empty-state">
                <div style="font-size: 48px; margin-bottom: 10px;">✨</div>
                <h3>Tidak ada pendaftaran menunggu</h3>
                <p>Semua pendaftaran telah diproses.</p>
            </div>
        @endif
    </div>

    <!-- Confirmation Modal -->
    <div class="modal-overlay" id="confirmModal">
        <div class="modal">
            <div id="modalIcon" style="font-size: 48px; margin-bottom: 15px;">❓</div>
            <h3 id="modalTitle">Konfirmasi</h3>
            <p id="modalMessage">Apakah Anda yakin?</p>
            
            <form id="modalForm" method="POST">
                @csrf
                <input type="hidden" name="rejection_reason" id="rejectionInput" value="Data tidak valid">
                <div class="modal-actions">
                    <button type="button" onclick="closeModal()" class="btn" style="background: #e2e8f0; color: #333;">Batal</button>
                    <button type="submit" id="modalSubmitBtn" class="btn btn-primary">Ya, Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('confirmModal');
        const modalForm = document.getElementById('modalForm');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalIcon = document.getElementById('modalIcon');
        const modalSubmitBtn = document.getElementById('modalSubmitBtn');
        const rejectionInput = document.getElementById('rejectionInput');

        function showModal(type, actionUrl) {
            modalForm.action = actionUrl;
            modal.style.display = 'flex';
            
            // Trigger reflow
            void modal.offsetWidth;
            
            modal.classList.add('show');
            modal.querySelector('.modal').classList.add('show');

            if (type === 'approve') {
                modalTitle.textContent = 'Setujui Pendaftaran?';
                modalMessage.textContent = 'Akun orang tua dan siswa akan otomatis dibuat. Email konfirmasi akan dikirim.';
                modalIcon.textContent = '✅';
                modalSubmitBtn.textContent = 'Ya, Setujui';
                modalSubmitBtn.className = 'btn btn-success';
                rejectionInput.disabled = true;
            } else {
                modalTitle.textContent = 'Tolak Pendaftaran?';
                modalMessage.textContent = 'Pendaftaran ini akan ditolak permanen.';
                modalIcon.textContent = '❌';
                modalSubmitBtn.textContent = 'Ya, Tolak';
                modalSubmitBtn.className = 'btn btn-danger';
                rejectionInput.disabled = false;
            }
        }

        function closeModal() {
            modal.classList.remove('show');
            modal.querySelector('.modal').classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Close on outside click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    </script>
</body>
</html>
