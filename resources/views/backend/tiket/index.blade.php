@extends('layouts.app-backend')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold">{{ $title }}</h4>
        <p class="text-muted small mb-0">Kelola dan pantau seluruh tiket kendala sistem</p>
    </div>

    @if(auth()->user()->isUser())
        <a href="{{ route('tiket.create') }}" class="btn btn-nd-primary">
            <i class="bi bi-plus-lg"></i> Buat Tiket Baru
        </a>
    @endif
</div>

<!-- Filter & Search Card -->
<div class="nd-card mb-4 animate-fade-in">
    <div class="nd-card-body py-3 px-4">
        <form action="{{ route('tiket.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari No. Tiket atau Subjek..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ ucfirst($cat->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="progress" {{ request('status') === 'progress' ? 'selected' : '' }}>Progress</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-nd-primary flex-grow-1">Filter</button>
                @if(request()->hasAny(['search', 'category_id', 'status']))
                    <a href="{{ route('tiket.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
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
                    <th>No. Tiket</th>
                    @if(auth()->user()->isAdmin())
                        <th>Pelapor</th>
                    @endif
                    <th>Subjek</th>
                    <th>Kategori</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Teknisi</th>
                    <th>Tanggal</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td class="fw-semibold">
                            <a href="{{ route('tiket.show', $ticket->id) }}" class="text-primary">
                                {{ $ticket->ticket_number }}
                            </a>
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td>
                                <div class="fw-medium text-dark">{{ $ticket->user->name ?? '-' }}</div>
                                <small class="text-muted">{{ $ticket->user->email ?? '' }}</small>
                            </td>
                        @endif
                        <td>{{ \Illuminate\Support\Str::limit($ticket->subject, 35) }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ strtoupper($ticket->category->name ?? '-') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status badge-priority-{{ $ticket->priority }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status badge-{{ $ticket->status }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>
                        <td>
                            @if($ticket->assignedAdmin)
                                <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                    <i class="bi bi-person-fill me-1"></i>{{ $ticket->assignedAdmin->name }}
                                </span>
                            @else
                                <span class="text-muted small">Belum di-assign</span>
                            @endif
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('tiket.show', $ticket->id) }}" class="btn btn-sm btn-nd-outline">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 9 : 8 }}" class="text-center py-5">
                            <i class="bi bi-ticket-perforated text-muted" style="font-size: 2.5rem; opacity: 0.4;"></i>
                            <p class="text-muted mt-2 mb-0">Tidak ada data tiket yang ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div class="p-3 border-top d-flex justify-content-end">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection
