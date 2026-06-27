@extends('layouts.app-backend')

@section('content')
<style>
    .chat-bubble {
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
        max-width: 80%;
    }
    .chat-bubble.user {
        margin-left: auto;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: white;
        border-radius: 1.25rem 1.25rem 0.25rem 1.25rem;
    }
    .chat-bubble.bot {
        margin-right: auto;
        background: white;
        color: #1f2937;
        border: 1px solid #e5e7eb;
        border-radius: 1.25rem 1.25rem 1.25rem 0.25rem;
    }
    .dark .chat-bubble.bot {
        background: #374151;
        color: #f3f4f6;
        border-color: #4b5563;
    }
    .chat-bubble.admin {
        margin-right: auto;
        background: #eef2ff;
        color: #312e81;
        border: 1px solid #c7d2fe;
        border-radius: 1.25rem 1.25rem 1.25rem 0.25rem;
    }
    .dark .chat-bubble.admin {
        background: #312e81;
        color: #e0e7ff;
        border-color: #4338ca;
    }
    .chat-sender {
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
        opacity: 0.85;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .chat-text { font-size: 0.9375rem; line-height: 1.5; word-break: break-word; }
    .chat-time { font-size: 0.6875rem; opacity: 0.7; text-align: right; margin-top: 0.35rem; }
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
    .dark .chat-typing { background: #374151; border-color: #4b5563; }
    .chat-typing span {
        width: 8px; height: 8px; background: #3b82f6; border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out both;
    }
    .chat-typing span:nth-child(1) { animation-delay: -0.32s; }
    .chat-typing span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes typing { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }
</style>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center flex-wrap gap-2 mb-1">
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
            @php
                $statusBadge = match($ticket->status) {
                    'open' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border-red-200',
                    'progress' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 border-amber-200',
                    'closed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border-emerald-200',
                    default => 'bg-gray-100 text-gray-800',
                };
                $prioBadge = match($ticket->priority) {
                    'high' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300',
                    'medium' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300',
                    default => 'bg-slate-100 text-slate-800',
                };
            @endphp
            <span class="text-xs font-bold px-2.5 py-1 rounded border {{ $statusBadge }}">{{ strtoupper($ticket->status) }}</span>
            <span class="text-xs font-semibold px-2.5 py-1 rounded {{ $prioBadge }}">{{ ucfirst($ticket->priority) }} Priority</span>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Dibuat oleh <strong class="text-gray-700 dark:text-gray-300">{{ $ticket->user->name ?? '-' }}</strong> pada {{ $ticket->created_at->translatedFormat('d F Y, H:i:s WIB') }}</p>
    </div>

    <div class="flex items-center gap-2">
        @if(auth()->user()->isAdmin())
            <form action="{{ route('tiket.update-status', $ticket->id) }}" method="POST" class="flex items-center gap-1">
                @csrf
                @method('PATCH')
                <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 py-1.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-medium shadow-sm" onchange="this.form.submit()">
                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Status: OPEN</option>
                    <option value="progress" {{ $ticket->status === 'progress' ? 'selected' : '' }}>Status: PROGRESS</option>
                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Status: CLOSED</option>
                </select>
            </form>
        @endif

        <a href="{{ route('tiket.index') }}" class="py-1.5 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center gap-1 transition-all">
            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: Chat & Discussion -->
    <div class="lg:col-span-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/50">
                <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"><path d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3.546l3.2 3.659a1 1 0 0 0 1.506 0L13.454 14H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-8 10H5a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Zm5-4H5a1 1 0 0 1 0-2h10a1 1 0 1 1 0 2Z"/></svg>
                    <span>Riwayat Percakapan & Bantuan AI</span>
                </h5>
                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/></svg>
                    <span>AI Aktif</span>
                </span>
            </div>

            <div class="p-6 overflow-y-auto bg-slate-50/60 dark:bg-gray-900/50 grow" id="chatArea" style="min-height: 380px; max-height: 550px;">
                @foreach($ticket->chatHistories as $chat)
                    <div class="chat-bubble {{ $chat->sender_type }}">
                        <div class="chat-sender">
                            @if($chat->sender_type === 'bot')
                                <svg class="w-3.5 h-3.5 text-blue-500 inline-block shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/></svg> MariDesk AI Bot
                            @else
                                <svg class="w-3.5 h-3.5 inline-block shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/></svg> {{ $chat->user->name ?? ($chat->sender_type === 'admin' ? 'Teknisi IT' : 'Pelapor') }}
                            @endif
                        </div>
                        <div class="chat-text">{!! nl2br(e($chat->message)) !!}</div>
                        <div class="chat-time">{{ $chat->created_at->translatedFormat('H:i:s WIB') }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Chat Input Form -->
            @if($ticket->status !== 'closed')
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <form id="chatForm" autocomplete="off">
                        <div class="flex gap-2">
                            <input
                                type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-inner"
                                id="chatMessage"
                                placeholder="{{ auth()->user()->isAdmin() ? 'Balas sebagai Teknisi IT...' : 'Ketik pesan atau tanyakan kendala IT Anda...' }}"
                                maxlength="2000"
                                required
                            >
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-3 text-center flex items-center justify-center transition-all shadow-md shrink-0" id="btnSendChat">
                                <svg class="w-5 h-5 shrink-0 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="m17.914 8.594-16-8.5A1 1 0 0 0 .658.347l2.853 8.358a1 1 0 0 0 .943.695h7.24a1 1 0 0 1 0 2h-7.24a1 1 0 0 0-.944.695L.658 20.453a1 1 0 0 0 1.256 1.257l16-8.5a1 1 0 0 0 0-1.761Z"/></svg>
                            </button>
                        </div>
                        <div class="flex justify-between items-center mt-2 px-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1" id="chatHint">
                                @if(auth()->user()->isUser())
                                    <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/></svg>
                                    <span>AI akan otomatis merespons pesan Anda</span>
                                @else
                                    <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/></svg>
                                    <span>Balas langsung sebagai teknisi (tanpa AI)</span>
                                @endif
                            </span>
                            <span class="text-xs text-gray-400"><span id="charCount">0</span>/2000</span>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 text-center">
                    <div class="inline-flex items-center gap-2 p-3 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 font-medium">
                        <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/></svg>
                        <span>Tiket ini sudah ditutup. Tidak dapat mengirim pesan baru.</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Ticket Details Info Flowbite -->
    <div class="lg:col-span-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-24">
            <h5 class="font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/></svg>
                <span>Informasi Tiket</span>
            </h5>

            <div class="space-y-4 text-sm">
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Subjek Kendala</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $ticket->subject }}</span>
                </div>

                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Kategori</span>
                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                        {{ strtoupper($ticket->category->name ?? '-') }}
                    </span>
                </div>

                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Analisis Sentimen AI</span>
                    @php
                        $sentBadge = match($ticket->sentiment) {
                            'positive' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border-emerald-200',
                            'negative' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 border-rose-200',
                            default    => 'bg-sky-100 text-sky-800 dark:bg-sky-900/40 dark:text-sky-300 border-sky-200',
                        };
                        $sentLabel = match($ticket->sentiment) {
                            'positive' => '😊 Puas / Positif',
                            'negative' => '😠 Tidak Puas / Urgent',
                            default    => '😐 Netral / Normal',
                        };
                    @endphp
                    <span class="inline-block font-semibold text-xs px-2.5 py-1 rounded border {{ $sentBadge }} mt-0.5">{{ $sentLabel }}</span>
                </div>

                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Teknisi IT Menangani</span>
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('tiket.update-assignee', $ticket->id) }}" method="POST" class="flex items-center gap-1 mt-1">
                            @csrf
                            @method('PATCH')
                            <select name="assigned_admin_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-medium">
                                <option value="">-- Belum di-assign --</option>
                                @foreach($admins as $adm)
                                    <option value="{{ $adm->id }}" {{ $ticket->assigned_admin_id == $adm->id ? 'selected' : '' }}>
                                        {{ $adm->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 p-2 rounded-lg text-xs transition-all shrink-0" title="Simpan Penugasan">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                            </button>
                        </form>
                    @else
                        @if($ticket->assignedAdmin)
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                                    {{ substr($ticket->assignedAdmin->name, 0, 1) }}
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $ticket->assignedAdmin->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">Belum di-assign</span>
                        @endif
                    @endif
                </div>

                <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Pelapor</span>
                    <div class="font-medium text-gray-900 dark:text-white">{{ $ticket->user->name ?? '-' }}</div>
                    <div class="text-xs text-gray-500">{{ $ticket->user->email ?? '' }}</div>
                </div>

                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Waktu Submit</span>
                    <span class="text-xs text-gray-600 dark:text-gray-300">{{ $ticket->created_at->translatedFormat('l, d F Y - H:i:s WIB') }}</span>
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

        let senderIcon = '<svg class="w-3.5 h-3.5 inline-block shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/></svg> ';
        if (data.sender_type === 'bot') {
            senderIcon = '<svg class="w-3.5 h-3.5 text-blue-500 inline-block shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/></svg> ';
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

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        chatInput.disabled = true;
        btnSend.disabled = true;
        btnSend.innerHTML = '<span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>';

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
            if (data.user_chat) {
                chatArea.appendChild(createBubble(data.user_chat));
            }

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
            btnSend.innerHTML = '<svg class="w-5 h-5 shrink-0 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="m17.914 8.594-16-8.5A1 1 0 0 0 .658.347l2.853 8.358a1 1 0 0 0 .943.695h7.24a1 1 0 0 1 0 2h-7.24a1 1 0 0 0-.944.695L.658 20.453a1 1 0 0 0 1.256 1.257l16-8.5a1 1 0 0 0 0-1.761Z"/></svg>';
            chatInput.focus();
        });
    });
});
</script>
@endsection
