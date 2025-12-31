<div class="game-card">
    <div class="game-thumb">
        @if($game->thumbnail)
            <img src="{{ asset($game->thumbnail) }}" alt="{{ $game->title }}">
        @else
            <span>{{ $lang == 'arab' ? '🕌' : '🏰' }}</span>
        @endif
    </div>
    <div class="game-info">
        <div class="game-title">{{ $game->title }}</div>
        <div class="game-meta">
            <span class="badge {{ $lang == 'arab' ? 'badge-arab' : 'badge-inggris' }}">
                {{ $lang == 'arab' ? 'Bahasa Arab' : 'Bahasa Inggris' }}
            </span>
            <span class="badge" style="background: #f1f5f9; color: #64748b;">
                {{ $game->questions->count() }} Soal
            </span>
        </div>
        <p style="color: #64748b; font-size: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            {{ $game->description }}
        </p>
    </div>
    <div style="display: flex;">
        <a href="{{ route('admin.questions', $game->id) }}" class="btn-manage" style="border-right: 1px solid #e2e8f0;">❓ Kelola Soal</a>
        <a href="{{ route('admin.official-games.edit', $game->id) }}" class="btn-manage" style="color: #f59e0b;">✏️ Edit</a>
        <form action="{{ route('admin.official-games.delete', $game->id) }}" method="POST" onsubmit="return confirm('Hapus game ini?')" style="flex: 1;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-manage" style="color: #ef4444; width: 100%; border: none; cursor: pointer;">🗑️ Hapus</button>
        </form>
    </div>
</div>
