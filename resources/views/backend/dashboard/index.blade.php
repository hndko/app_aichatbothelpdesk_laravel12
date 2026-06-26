@extends('layouts.app-backend')

@section('content')
<div class="row g-3 mb-4">
    <!-- Total Tiket -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card primary animate-slide-up">
            <div class="stat-card-icon">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
            <div class="stat-card-value count-up" data-target="{{ $totalTickets }}">0</div>
            <div class="stat-card-label">Total Tiket</div>
        </div>
    </div>

    <!-- Open -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card warning animate-slide-up" style="animation-delay: 0.1s;">
            <div class="stat-card-icon">
                <i class="bi bi-clock-fill"></i>
            </div>
            <div class="stat-card-value count-up" data-target="{{ $openTickets }}">0</div>
            <div class="stat-card-label">Tiket Open</div>
        </div>
    </div>

    <!-- Progress -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card info animate-slide-up" style="animation-delay: 0.2s;">
            <div class="stat-card-icon">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <div class="stat-card-value count-up" data-target="{{ $progressTickets }}">0</div>
            <div class="stat-card-label">Tiket Progress</div>
        </div>
    </div>

    <!-- Closed -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card success animate-slide-up" style="animation-delay: 0.3s;">
            <div class="stat-card-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-card-value count-up" data-target="{{ $closedTickets }}">0</div>
            <div class="stat-card-label">Tiket Closed</div>
        </div>
    </div>
</div>

<!-- Tiket Terbaru -->
<div class="nd-card animate-fade-in">
    <div class="nd-card-header">
        <h5><i class="bi bi-clock-history me-2"></i>Tiket Terbaru</h5>
        <a href="{{ route('tiket.index') }}" class="btn-nd-outline btn-sm">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="nd-card-body p-0">
        <div class="table-responsive">
            <table class="table nd-table mb-0">
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Subject</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTickets as $ticket)
                        <tr>
                            <td>
                                <a href="{{ route('tiket.show', $ticket->id) }}" class="fw-semibold text-primary">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($ticket->subject, 40) }}</td>
                            <td>{{ $ticket->category->name ?? '-' }}</td>
                            <td>
                                <span class="badge-status badge-{{ $ticket->status }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-status badge-priority-{{ $ticket->priority }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem; opacity: 0.3;"></i>
                                Belum ada tiket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
