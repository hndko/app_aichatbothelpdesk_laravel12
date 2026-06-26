@extends('layouts.app-backend')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold">{{ $title }}</h4>
        <p class="text-muted small mb-0">Kelola artikel FAQ yang menjadi referensi jawaban AI Chatbot</p>
    </div>

    <a href="{{ route('knowledge-base.create') }}" class="btn btn-nd-primary">
        <i class="bi bi-plus-lg"></i> Tambah Artikel
    </a>
</div>

<!-- Filter & Search -->
<div class="nd-card mb-4 animate-fade-in">
    <div class="nd-card-body py-3 px-4">
        <form action="{{ route('knowledge-base.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari pertanyaan atau jawaban..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ ucfirst($cat->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-nd-primary flex-grow-1">Filter</button>
                @if(request()->hasAny(['search', 'category_id']))
                    <a href="{{ route('knowledge-base.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="nd-table animate-slide-up">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Pertanyaan (FAQ)</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Diperbarui</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $idx => $article)
                    <tr>
                        <td class="text-muted">{{ $articles->firstItem() + $idx }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($article->question, 60) }}</div>
                            <small class="text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($article->answer), 80) }}</small>
                        </td>
                        <td>
                            @if($article->category)
                                <span class="badge bg-light text-dark border">{{ strtoupper($article->category->name) }}</span>
                            @else
                                <span class="text-muted small">Umum</span>
                            @endif
                        </td>
                        <td>
                            @if($article->is_active)
                                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary-emphasis border"><i class="bi bi-pause-circle me-1"></i>Nonaktif</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $article->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('knowledge-base.edit', $article->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('knowledge-base.destroy', $article->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus artikel FAQ ini?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-book text-muted" style="font-size: 2.5rem; opacity: 0.4;"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada artikel knowledge base.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
        <div class="p-3 border-top d-flex justify-content-end">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
