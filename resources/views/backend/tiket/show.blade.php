@extends('layouts.app-backend')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="mb-0 fw-bold">{{ $title }}</h4>
            <span class="badge-status badge-{{ $ticket->status }}">{{ strtoupper($ticket->status) }}</span>
            <span class="badge-status badge-priority-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }} Priority</span>
        </div>
        <p class="text-muted small mb-0">Dibuat oleh {{ $ticket->user->name ?? '-' }} pada {{ $ticket->created_at->format('d M Y, H:i') }}</p>
    </div>

    <div class="d-flex gap-2">
        @if(auth()->user()->isAdmin())
            <form action="{{ route('tiket.update-status', $ticket->id) }}" method="POST" class="d-flex gap-1">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Status: OPEN</option>
                    <option value="progress" {{ $ticket->status === 'progress' ? 'selected' : '' }}>Status: PROGRESS</option>
                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Status: CLOSED</option>
                </select>
            </form>
        @endif

        <a href="{{ route('tiket.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Chat & Discussion -->
    <div class="col-lg-8">
        <div class="nd-card animate-fade-in mb-4">
            <div class="nd-card-header">
                <h5><i class="bi bi-chat-dots-fill text-primary me-2"></i>Riwayat Percakapan & Bantuan AI</h5>
            </div>
            
            <div class="chat-container bg-light-subtle p-4" id="chatArea">
                @foreach($ticket->chatHistories as $chat)
                    <div class="chat-bubble {{ $chat->sender_type }}">
                        <div class="chat-sender">
                            @if($chat->sender_type === 'bot')
                                <i class="bi bi-robot me-1"></i>NexusDesk AI Bot
                            @else
                                {{ $chat->user->name ?? ($chat->sender_type === 'admin' ? 'Teknisi IT' : 'Pelapor') }}
                            @endif
                        </div>
                        <div class="chat-text">{!! nl2br(e($chat->message)) !!}</div>
                        <div class="chat-time">{{ $chat->created_at->format('H:i') }}</div>
                    </div>
                @endforeach
            </div>

            <div class="p-3 border-top bg-white">
                <div class="alert alert-secondary py-2 px-3 small mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    <span>Balasan interaktif AI Chatbot akan aktif setelah integrasi layanan LLM di Fase 3.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Ticket Details Info -->
    <div class="col-lg-4">
        <div class="nd-card animate-slide-up mb-4">
            <div class="nd-card-header">
                <h5><i class="bi bi-info-circle me-2"></i>Informasi Tiket</h5>
            </div>
            <div class="nd-card-body p-4">
                <div class="mb-3">
                    <small class="text-muted d-block fw-medium">Subjek Kendala</small>
                    <span class="fw-semibold text-dark">{{ $ticket->subject }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block fw-medium">Kategori</small>
                    <span class="badge bg-secondary-subtle text-secondary-emphasis border">{{ strtoupper($ticket->category->name ?? '-') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block fw-medium">Teknisi IT Menangani</small>
                    @if($ticket->assignedAdmin)
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <div class="topbar-user-avatar" style="width:30px;height:30px;font-size:0.75rem;">
                                {{ substr($ticket->assignedAdmin->name, 0, 1) }}
                            </div>
                            <span class="fw-semibold text-dark">{{ $ticket->assignedAdmin->name }}</span>
                        </div>
                    @else
                        <span class="text-muted small italic">Belum di-assign</span>
                    @endif
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block fw-medium">Pelapor</small>
                    <div class="text-dark fw-medium">{{ $ticket->user->name ?? '-' }}</div>
                    <small class="text-muted">{{ $ticket->user->email ?? '' }}</small>
                </div>

                <div>
                    <small class="text-muted d-block fw-medium">Waktu Submit</small>
                    <span class="text-dark small">{{ $ticket->created_at->format('l, d F Y - H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
