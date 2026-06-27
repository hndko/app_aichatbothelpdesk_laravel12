@extends('layouts.app-backend')

@section('content')

<!-- Header & Action Buttons -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 animate-slide-up">
    <div>
        <h4 class="mb-1 fw-bold text-dark"><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Rekapitulasi Laporan Helpdesk</h4>
        <p class="text-muted small mb-0">Pantau statistik penyelesaian kendala, kepuasan sentimen AI, dan unduh berkas laporan.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('report.export-pdf') }}" class="btn btn-danger d-inline-flex align-items-center gap-2 shadow-sm" style="border-radius: 10px;">
            <i class="bi bi-file-earmark-pdf-fill fs-5"></i> Export PDF
        </a>
        <a href="{{ route('report.export-excel') }}" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm" style="border-radius: 10px;">
            <i class="bi bi-file-earmark-excel-fill fs-5"></i> Export Excel
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4 animate-slide-up">
    <div class="col-md-3">
        <div class="nd-card p-3 d-flex align-items-center gap-3">
            <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-ticket-detailed-fill"></i></div>
            <div>
                <small class="text-muted d-block">Total Tiket</small>
                <h4 class="mb-0 fw-bold">{{ $total }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="nd-card p-3 d-flex align-items-center gap-3">
            <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <small class="text-muted d-block">Sedang Diproses</small>
                <h4 class="mb-0 fw-bold">{{ $progress }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="nd-card p-3 d-flex align-items-center gap-3">
            <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <small class="text-muted d-block">Selesai (Closed)</small>
                <h4 class="mb-0 fw-bold">{{ $closed }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="nd-card p-3 d-flex align-items-center gap-3">
            <div class="stat-icon bg-info-subtle text-info"><i class="bi bi-emoji-smile-fill"></i></div>
            <div>
                <small class="text-muted d-block">Sentimen Positif AI</small>
                <h4 class="mb-0 fw-bold">{{ $positive }}</h4>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Table Preview -->
<div class="nd-card animate-slide-up">
    <div class="nd-card-header d-flex justify-content-between align-items-center">
        <h5><i class="bi bi-table me-2"></i>Pratinjau Data Laporan</h5>
        <span class="badge bg-light text-dark border">Total Menampilkan: {{ $tickets->total() }}</span>
    </div>

    <div class="nd-table">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Pelapor</th>
                        <th>Subjek Masalah</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Sentimen AI</th>
                        <th>Teknisi Assignee</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td class="fw-semibold">{{ $ticket->ticket_number }}</td>
                            <td>{{ $ticket->user->name ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($ticket->subject, 30) }}</td>
                            <td><span class="badge bg-light text-dark border">{{ strtoupper($ticket->category->name ?? '-') }}</span></td>
                            <td><span class="badge-status badge-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span></td>
                            <td>
                                @php
                                    $sBadge = match($ticket->sentiment) {
                                        'positive' => 'bg-success-subtle text-success border-success',
                                        'negative' => 'bg-danger-subtle text-danger border-danger',
                                        default    => 'bg-info-subtle text-info border-info',
                                    };
                                    $sIcon = match($ticket->sentiment) {
                                        'positive' => '😊 Puas',
                                        'negative' => '😠 Urgent',
                                        default    => '😐 Netral',
                                    };
                                @endphp
                                <span class="badge border {{ $sBadge }}">{{ $sIcon }}</span>
                            </td>
                            <td>{{ $ticket->assignedAdmin->name ?? 'Belum di-assign' }}</td>
                            <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Tidak ada data tiket untuk laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($tickets->hasPages())
        <div class="p-3 border-top d-flex justify-content-end">
            {{ $tickets->links() }}
        </div>
    @endif
</div>

@endsection
