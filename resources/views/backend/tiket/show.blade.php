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
                <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                    <i class="bi bi-robot me-1"></i>AI Aktif
                </span>
            </div>

            <div class="chat-container bg-light-subtle p-4" id="chatArea" style="min-height: 350px;">
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

            <!-- Chat Input Form -->
            @if($ticket->status !== 'closed')
                <div class="p-3 border-top bg-white" style="border-radius: 0 0 var(--border-radius) var(--border-radius);">
                    <form id="chatForm" autocomplete="off">
                        <div class="d-flex gap-2">
                            <input
                                type="text"
                                class="form-control"
                                id="chatMessage"
                                placeholder="{{ auth()->user()->isAdmin() ? 'Balas sebagai Teknisi IT...' : 'Ketik pesan atau tanyakan kendala IT Anda...' }}"
                                maxlength="2000"
                                required
                            >
                            <button type="submit" class="btn btn-nd-primary px-3" id="btnSendChat">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted" id="chatHint">
                                @if(auth()->user()->isUser())
                                    <i class="bi bi-robot me-1"></i>AI akan otomatis merespons pesan Anda
                                @else
                                    <i class="bi bi-person-badge me-1"></i>Balas langsung sebagai teknisi (tanpa AI)
                                @endif
                            </small>
                            <small class="text-muted"><span id="charCount">0</span>/2000</small>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-3 border-top bg-white text-center">
                    <div class="alert alert-success py-2 px-3 small mb-0 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Tiket ini sudah ditutup. Tidak dapat mengirim pesan baru.</span>
                    </div>
                </div>
            @endif
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
                    <small class="text-muted d-block fw-medium">Analisis Sentimen AI</small>
                    @php
                        $sentBadge = match($ticket->sentiment) {
                            'positive' => 'bg-success-subtle text-success border-success',
                            'negative' => 'bg-danger-subtle text-danger border-danger',
                            default    => 'bg-info-subtle text-info border-info',
                        };
                        $sentLabel = match($ticket->sentiment) {
                            'positive' => '😊 Puas / Positif',
                            'negative' => '😠 Tidak Puas / Urgent',
                            default    => '😐 Netral / Normal',
                        };
                    @endphp
                    <span class="badge border {{ $sentBadge }} px-2 py-1 mt-1">{{ $sentLabel }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block fw-medium">Teknisi IT Menangani</small>
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('tiket.update-assignee', $ticket->id) }}" method="POST" class="d-flex gap-1 mt-1">
                            @csrf
                            @method('PATCH')
                            <select name="assigned_admin_id" class="form-select form-select-sm border-secondary-subtle">
                                <option value="">-- Belum di-assign --</option>
                                @foreach($admins as $adm)
                                    <option value="{{ $adm->id }}" {{ $ticket->assigned_admin_id == $adm->id ? 'selected' : '' }}>
                                        {{ $adm->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-nd-primary px-2" title="Simpan Penugasan">
                                <i class="bi bi-check2"></i>
                            </button>
                        </form>
                    @else
                        @if($ticket->assignedAdmin)
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <div class="topbar-user-avatar" style="width:30px;height:30px;font-size:0.75rem;">
                                    {{ substr($ticket->assignedAdmin->name, 0, 1) }}
                                </div>
                                <span class="fw-semibold text-dark">{{ $ticket->assignedAdmin->name }}</span>
                            </div>
                        @else
                            <span class="text-muted small fst-italic">Belum di-assign</span>
                        @endif
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

<!-- AJAX Chat Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm    = document.getElementById('chatForm');
    const chatInput   = document.getElementById('chatMessage');
    const chatArea    = document.getElementById('chatArea');
    const btnSend     = document.getElementById('btnSendChat');
    const charCount   = document.getElementById('charCount');
    const ticketId    = {{ $ticket->id }};
    const csrfToken   = '{{ csrf_token() }}';

    if (!chatForm) return;

    // Scroll ke bawah
    function scrollToBottom() {
        chatArea.scrollTop = chatArea.scrollHeight;
    }
    scrollToBottom();

    // Character counter
    chatInput.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });

    // Buat chat bubble DOM element
    function createBubble(data) {
        const div = document.createElement('div');
        div.className = 'chat-bubble ' + data.sender_type;

        let senderIcon = '';
        if (data.sender_type === 'bot') {
            senderIcon = '<i class="bi bi-robot me-1"></i>';
        }

        const escapedMsg = data.message
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\n/g, '<br>');

        div.innerHTML = `
            <div class="chat-sender">${senderIcon}${data.sender_name}</div>
            <div class="chat-text">${escapedMsg}</div>
            <div class="chat-time">${data.time}</div>
        `;
        return div;
    }

    // Typing indicator
    function showTyping() {
        const typing = document.createElement('div');
        typing.className = 'chat-typing';
        typing.id = 'typingIndicator';
        typing.innerHTML = '<span></span><span></span><span></span>';
        chatArea.appendChild(typing);
        scrollToBottom();
    }

    function hideTyping() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) indicator.remove();
    }

    // Submit handler
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        // Disable input
        chatInput.disabled = true;
        btnSend.disabled = true;
        btnSend.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        // Kirim pesan via AJAX
        fetch('/chatbot/' + ticketId + '/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: message })
        })
        .then(function(response) {
            if (!response.ok) throw new Error('Network response error');
            return response.json();
        })
        .then(function(data) {
            // Tampilkan pesan user
            if (data.user_chat) {
                chatArea.appendChild(createBubble(data.user_chat));
            }

            // Tampilkan pesan bot (jika ada)
            if (data.bot_chat) {
                showTyping();
                setTimeout(function() {
                    hideTyping();
                    chatArea.appendChild(createBubble(data.bot_chat));
                    scrollToBottom();
                }, 800);
            }

            scrollToBottom();
            chatInput.value = '';
            charCount.textContent = '0';
        })
        .catch(function(err) {
            console.error('Chat error:', err);
            if (typeof Swal !== 'undefined') {
                Swal.fire('Error', 'Gagal mengirim pesan. Silakan coba lagi.', 'error');
            } else {
                alert('Gagal mengirim pesan. Silakan coba lagi.');
            }
        })
        .finally(function() {
            chatInput.disabled = false;
            btnSend.disabled = false;
            btnSend.innerHTML = '<i class="bi bi-send-fill"></i>';
            chatInput.focus();
        });
    });
});
</script>
@endsection
