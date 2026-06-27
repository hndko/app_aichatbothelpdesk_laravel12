@extends('layouts.app-backend')

@section('content')
<style>
    .chat-bubble {
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
        max-width: 82%;
    }
    .chat-bubble.user {
        margin-left: auto;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: white;
        border-radius: 1.25rem 1.25rem 0.25rem 1.25rem;
    }
    .chat-bubble.bot {
        margin-right: auto;
        background: white;
        color: #1f2937;
        border: 1px solid #f1f5f9;
        border-radius: 1.25rem 1.25rem 1.25rem 0.25rem;
    }
    .dark .chat-bubble.bot {
        background: #1e293b;
        color: #f8fafc;
        border-color: #334155;
    }
    .chat-bubble.admin {
        margin-right: auto;
        background: #f0fdf4;
        color: #14532d;
        border: 1px solid #bbf7d0;
        border-radius: 1.25rem 1.25rem 1.25rem 0.25rem;
    }
    .dark .chat-bubble.admin {
        background: #064e3b;
        color: #ecfdf5;
        border-color: #047857;
    }
    .chat-sender {
        font-size: 0.75rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .chat-text { font-size: 0.9375rem; line-height: 1.6; word-break: break-word; }
    .chat-time { font-size: 0.6875rem; opacity: 0.75; text-align: right; margin-top: 0.35rem; }
    .chat-typing {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 12px 18px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        margin-bottom: 1rem;
    }
    .dark .chat-typing { background: #1e293b; border-color: #334155; }
    .chat-typing span {
        width: 8px; height: 8px; background: #3b82f6; border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out both;
    }
    .chat-typing span:nth-child(1) { animation-delay: -0.32s; }
    .chat-typing span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes typing { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }
</style>

<div class="space-y-6">
    <!-- Top Header Banner -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center flex-wrap gap-2.5 mb-2">
                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">{{ $title }}</h1>
                <span class="text-xs font-bold px-3 py-1 rounded-lg {{ $ticket->status_badge }}">
                    {{ strtoupper($ticket->status) }}
                </span>
                <span class="text-xs font-bold px-3 py-1 rounded-lg {{ $ticket->priority_badge }}">
                    ⚡ {{ ucfirst($ticket->priority) }} Priority
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Dibuat oleh <strong class="text-gray-800 dark:text-gray-200">{{ $ticket->user->name ?? '-' }}</strong> pada {{ $ticket->formatted_date }}
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            @if(auth()->user()->isStaff())
                <form action="{{ route('tiket.toggle-ai', $ticket->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="py-1.5 px-3 text-xs font-bold rounded-xl border {{ $ticket->is_ai_active ? 'bg-amber-50 text-amber-800 border-amber-300 hover:bg-amber-100 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-800' : 'bg-blue-50 text-blue-700 border-blue-300 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800' }} inline-flex items-center gap-1.5 transition-all shadow-2xs cursor-pointer">
                        <span>{{ $ticket->is_ai_active ? '⏸️ Jeda AI (Takeover)' : '▶️ Aktifkan AI Kembali' }}</span>
                    </button>
                </form>

                <form action="{{ route('tiket.update-status', $ticket->id) }}" method="POST" class="flex items-center gap-1 bg-gray-50 dark:bg-gray-700/50 p-1 rounded-xl border border-gray-200 dark:border-gray-600">
                    @csrf
                    @method('PATCH')
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 px-2">Ubah Status:</span>
                    <select name="status" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-xs font-bold rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 px-3 shadow-2xs cursor-pointer" onchange="this.form.submit()">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>🔴 OPEN</option>
                        <option value="progress" {{ $ticket->status === 'progress' ? 'selected' : '' }}>🟡 PROGRESS</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>🟢 CLOSED</option>
                    </select>
                </form>
            @endif

            <a href="{{ route('tiket.index') }}" class="py-2 px-4 text-xs font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 hover:text-blue-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 inline-flex items-center gap-1.5 transition-all shadow-2xs">
                <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left Column: Chat Area -->
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/75 dark:bg-gray-700/50">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="text-lg">💬</span>
                        <span>Ruang Diskusi & Bantuan AI</span>
                    </h3>
                    @if($ticket->is_ai_active)
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span>
                            <span>AI Otomatis Aktif</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                            <span>Diambil Alih Teknisi (AI Jeda)</span>
                        </span>
                    @endif
                </div>

                <!-- Chat Messages Area -->
                <div class="p-6 overflow-y-auto bg-slate-50/70 dark:bg-gray-900/40 grow space-y-4" id="chatArea" style="min-height: 420px; max-height: 580px;">
                    @foreach($ticket->chatHistories as $chat)
                        <div class="chat-bubble {{ $chat->sender_type }}">
                            <div class="chat-sender">
                                @if($chat->sender_type === 'bot')
                                    <span>🤖 MariDesk AI Assistant</span>
                                @elseif($chat->sender_type === 'admin')
                                    <span>🛡️ {{ $chat->user->name ?? 'Teknisi IT Helpdesk' }}</span>
                                @else
                                    <span>👤 {{ $chat->user->name ?? 'Pelapor' }}</span>
                                @endif
                            </div>
                            <div class="chat-text">{!! nl2br(e($chat->message)) !!}</div>
                            <div class="chat-time">{{ $chat->created_at->translatedFormat('H:i WIB') }}</div>
                        </div>
                    @endforeach
                </div>

                <!-- Chat Input Box -->
                @if($ticket->status !== 'closed')
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                        @if(auth()->user()->isStaff())
                            <div class="mb-2.5 flex items-center justify-between">
                                <button type="button" id="btnSuggestReply" class="text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:hover:bg-indigo-900/50 py-1.5 px-3 rounded-lg border border-indigo-200 dark:border-indigo-800 inline-flex items-center gap-1.5 transition-all shadow-2xs cursor-pointer">
                                    <span>✨ Rekomendasi Balasan AI (Draf Teknisi)</span>
                                </button>
                                <span class="text-[11px] text-indigo-500 dark:text-indigo-400 italic hidden animate-pulse" id="suggestLoading">⏳ Merumuskan saran balasan...</span>
                            </div>
                        @endif
                        <form id="chatForm" autocomplete="off">
                            <div class="flex gap-2.5">
                                <input
                                    type="text"
                                    class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-inner"
                                    id="chatMessage"
                                    placeholder="{{ auth()->user()->isStaff() ? 'Ketik balasan resmi sebagai Teknisi IT...' : 'Tanyakan sesuatu atau balas pesan...' }}"
                                    maxlength="2000"
                                    required
                                >
                                <button type="submit" class="text-white bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-6 py-3.5 text-center flex items-center justify-center transition-all shadow-md shrink-0 active:scale-95 cursor-pointer" id="btnSendChat">
                                    <svg class="w-5 h-5 shrink-0 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="m17.914 8.594-16-8.5A1 1 0 0 0 .658.347l2.853 8.358a1 1 0 0 0 .943.695h7.24a1 1 0 0 1 0 2h-7.24a1 1 0 0 0-.944.695L.658 20.453a1 1 0 0 0 1.256 1.257l16-8.5a1 1 0 0 0 0-1.761Z"/></svg>
                                </button>
                            </div>
                            <div class="flex justify-between items-center mt-2 px-1">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1.5" id="chatHint">
                                    @if(auth()->user()->isUser())
                                        <span>✨ AI akan otomatis menganalisis dan membalas pesan Anda</span>
                                    @else
                                        <span>🛡️ Balasan resmi teknisi (tidak memicu bot AI)</span>
                                    @endif
                                </span>
                                <span class="text-xs font-bold text-gray-400"><span id="charCount">0</span>/2000</span>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="p-5 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-center">
                        <div class="inline-flex items-center gap-2 p-3 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 font-bold border border-emerald-200 dark:border-emerald-800 shadow-2xs">
                            <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/></svg>
                            <span>Tiket ini telah selesai & ditutup. Ruang obrolan dinonaktifkan.</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Ticket Sidebar Info -->
        <div class="lg:col-span-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-24 space-y-5">
                <h3 class="font-bold text-gray-900 dark:text-white pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <span>📌</span>
                    <span>Informasi Rincian Tiket</span>
                </h3>

                <!-- Subjek -->
                <div>
                    <span class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Subjek Kendala</span>
                    <p class="font-bold text-gray-900 dark:text-white leading-snug">{{ $ticket->subject }}</p>
                </div>

                <!-- Kategori -->
                <div>
                    <span class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Kategori Masalah</span>
                    <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-lg dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 inline-block">
                        {{ $ticket->category_name }}
                    </span>
                </div>

                <!-- Analisis Sentimen AI -->
                <div>
                    <span class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Sentimen AI Terdeteksi</span>
                    <span class="inline-block font-bold text-xs px-3 py-1 rounded-lg border {{ $ticket->sentiment_badge }}">
                        {{ $ticket->sentiment_label }}
                    </span>
                </div>

                <!-- Penugasan Teknisi -->
                <div>
                    <span class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Teknisi Penanggung Jawab</span>
                    @if(auth()->user()->isAdmin() || auth()->user()->isServiceDesk())
                        <form action="{{ route('tiket.update-assignee', $ticket->id) }}" method="POST" class="flex items-center gap-1.5">
                            @csrf
                            @method('PATCH')
                            <select name="assigned_admin_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-xs font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-2xs">
                                <option value="">-- Belum Di-assign --</option>
                                @foreach($admins as $adm)
                                    <option value="{{ $adm->id }}" {{ $ticket->assigned_admin_id == $adm->id ? 'selected' : '' }}>
                                        {{ $adm->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 p-2.5 rounded-xl text-xs transition-all shrink-0 shadow-2xs" title="Simpan Penugasan">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                            </button>
                        </form>
                    @else
                        @if($ticket->assignedAdmin)
                            <div class="inline-flex items-center gap-2 bg-blue-50 dark:bg-blue-900/30 px-3 py-1.5 rounded-xl border border-blue-200 dark:border-blue-800">
                                <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($ticket->assignedAdmin->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-xs text-blue-900 dark:text-blue-200">{{ $ticket->assignedAdmin->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs block">Belum ditugaskan ke teknisi</span>
                        @endif
                    @endif
                </div>

                <!-- Info Pelapor -->
                <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                    <span class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Informasi Pelapor</span>
                    <div class="font-bold text-gray-900 dark:text-white">{{ $ticket->user->name ?? '-' }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->user->email ?? '' }}</div>
                </div>

                <!-- Waktu Submit -->
                <div>
                    <span class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Waktu Submit</span>
                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $ticket->formatted_date }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AJAX Chat Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm  = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatMessage');
    const chatArea  = document.getElementById('chatArea');
    const btnSend   = document.getElementById('btnSendChat');
    const charCount = document.getElementById('charCount');
    const ticketId  = {{ $ticket->id }};
    const csrfToken = '{{ csrf_token() }}';

    if (!chatForm) return;

    function scrollToBottom() {
        chatArea.scrollTop = chatArea.scrollHeight;
    }
    scrollToBottom();

    chatInput.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });

    function createBubble(data) {
        const div = document.createElement('div');
        div.className = 'chat-bubble ' + data.sender_type;

        let senderName = '';
        if (data.sender_type === 'bot') {
            senderName = '🤖 MariDesk AI Assistant';
        } else if (data.sender_type === 'admin') {
            senderName = '🛡️ ' + (data.sender_name || 'Teknisi IT Helpdesk');
        } else {
            senderName = '👤 ' + (data.sender_name || 'Pelapor');
        }

        div.innerHTML = `
            <div class="chat-sender">${senderName}</div>
            <div class="chat-text">${data.message}</div>
            <div class="chat-time">${data.created_at}</div>
        `;
        return div;
    }

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;

        chatInput.disabled = true;
        btnSend.disabled = true;

        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
        const userBubble = createBubble({
            sender_type: '{{ auth()->user()->isStaff() ? "admin" : "user" }}',
            sender_name: '{{ auth()->user()->name }}',
            message: msg.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, "<br>"),
            created_at: timeStr
        });
        chatArea.appendChild(userBubble);
        chatInput.value = '';
        charCount.textContent = '0';
        scrollToBottom();

        let typingIndicator = null;
        if ('{{ auth()->user()->isUser() }}' === '1') {
            typingIndicator = document.createElement('div');
            typingIndicator.className = 'chat-typing';
            typingIndicator.innerHTML = '<span></span><span></span><span></span>';
            chatArea.appendChild(typingIndicator);
            scrollToBottom();
        }

        fetch(`/chatbot/${ticketId}/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: msg })
        })
        .then(response => response.json())
        .then(data => {
            if (typingIndicator) typingIndicator.remove();
            if (data.bot_chat) {
                const botBubble = createBubble({
                    sender_type: 'bot',
                    message: data.bot_chat.message.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, "<br>"),
                    created_at: data.bot_chat.time
                });
                chatArea.appendChild(botBubble);
                scrollToBottom();
            }
        })
        .catch(err => {
            if (typingIndicator) typingIndicator.remove();
            console.error('Error:', err);
        })
        .finally(() => {
            chatInput.disabled = false;
            btnSend.disabled = false;
            chatInput.focus();
        });
    });

    const btnSuggest = document.getElementById('btnSuggestReply');
    const suggestLoading = document.getElementById('suggestLoading');
    if (btnSuggest) {
        btnSuggest.addEventListener('click', function() {
            btnSuggest.disabled = true;
            if (suggestLoading) suggestLoading.classList.remove('hidden');

            fetch(`/chatbot/${ticketId}/suggest`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.suggestion) {
                    chatInput.value = data.suggestion;
                    charCount.textContent = chatInput.value.length;
                    chatInput.focus();
                } else {
                    alert(data.error || 'Gagal merumuskan saran balasan.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat memanggil AI.');
            })
            .finally(() => {
                btnSuggest.disabled = false;
                if (suggestLoading) suggestLoading.classList.add('hidden');
            });
        });
    }
});
</script>
@endsection
