@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Banner -->
    <div class="bg-linear-to-r from-indigo-600 via-purple-600 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg flex flex-col sm:flex-row items-center gap-6 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-3xl shadow-xl shrink-0 border border-white/30">
            🤖
        </div>
        <div class="text-center sm:text-left z-10">
            <h2 class="text-2xl font-bold">Konfigurasi AI Provider & Model</h2>
            <p class="text-indigo-100 text-sm mt-1">Kelola dan pilih penyedia layanan AI (LLM) serta model yang digunakan oleh Chatbot Helpdesk agar tetap fleksibel jika terjadi kendala pada layanan tertentu.</p>
        </div>
    </div>

    <!-- AI Setting Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        @if($errors->any())
            <div class="p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 dark:bg-gray-700 dark:text-red-400 border border-red-200 dark:border-red-800">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ai-setting.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Pilih Provider -->
            <div>
                <label class="block mb-3 text-sm font-bold text-gray-900 dark:text-white">Pilih Penyedia Layanan AI (Provider) <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative flex items-center p-4 rounded-xl border cursor-pointer transition-all hover:bg-gray-50 dark:hover:bg-gray-700 {{ $ai_provider === 'openrouter' ? 'border-indigo-600 bg-indigo-50/50 dark:bg-indigo-900/20 ring-2 ring-indigo-600' : 'border-gray-200 dark:border-gray-700' }}">
                        <input type="radio" name="ai_provider" value="openrouter" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $ai_provider === 'openrouter' ? 'checked' : '' }}>
                        <div class="ms-3">
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">🌐 OpenRouter AI</span>
                            <span class="block text-xs text-gray-500 dark:text-gray-400">Akses ke 100+ model AI (GPT-4o, Claude, DeepSeek, Llama) via 1 API</span>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-xl border cursor-pointer transition-all hover:bg-gray-50 dark:hover:bg-gray-700 {{ $ai_provider === 'openai' ? 'border-indigo-600 bg-indigo-50/50 dark:bg-indigo-900/20 ring-2 ring-indigo-600' : 'border-gray-200 dark:border-gray-700' }}">
                        <input type="radio" name="ai_provider" value="openai" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $ai_provider === 'openai' ? 'checked' : '' }}>
                        <div class="ms-3">
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">⚡ OpenAI Direct</span>
                            <span class="block text-xs text-gray-500 dark:text-gray-400">Koneksi langsung ke server resmi OpenAI (GPT-3.5, GPT-4o)</span>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-xl border cursor-pointer transition-all hover:bg-gray-50 dark:hover:bg-gray-700 {{ $ai_provider === 'gemini' ? 'border-indigo-600 bg-indigo-50/50 dark:bg-indigo-900/20 ring-2 ring-indigo-600' : 'border-gray-200 dark:border-gray-700' }}">
                        <input type="radio" name="ai_provider" value="gemini" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $ai_provider === 'gemini' ? 'checked' : '' }}>
                        <div class="ms-3">
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">✨ Google Gemini</span>
                            <span class="block text-xs text-gray-500 dark:text-gray-400">Model LLM berkecepatan tinggi dari Google (Gemini 1.5 Flash / Pro)</span>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-xl border cursor-pointer transition-all hover:bg-gray-50 dark:hover:bg-gray-700 {{ $ai_provider === 'custom' ? 'border-indigo-600 bg-indigo-50/50 dark:bg-indigo-900/20 ring-2 ring-indigo-600' : 'border-gray-200 dark:border-gray-700' }}">
                        <input type="radio" name="ai_provider" value="custom" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $ai_provider === 'custom' ? 'checked' : '' }}>
                        <div class="ms-3">
                            <span class="block text-sm font-bold text-gray-900 dark:text-white">🔧 Custom Base URL</span>
                            <span class="block text-xs text-gray-500 dark:text-gray-400">Gunakan server lokal (Ollama / LocalAI) atau endpoint kompatibel OpenAI lainnya</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                <!-- Nama Model -->
                <div>
                    <label for="ai_model" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Nama Model AI <span class="text-red-500">*</span></label>
                    <input type="text" id="ai_model" name="ai_model" value="{{ old('ai_model', $ai_model) }}" placeholder="Contoh: openai/gpt-3.5-turbo atau gpt-4o-mini" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs" required>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Pastikan identifier model sesuai dengan dokumentasi provider yang Anda pilih.</p>
                </div>

                <!-- API Key -->
                <div>
                    <label for="ai_api_key" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">API Key Rahasia</label>
                    <input type="password" id="ai_api_key" name="ai_api_key" placeholder="{{ !empty($ai_api_key) ? '••••••••••••••••••••••••••••••••' : 'Masukkan API Key baru...' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Kosongkan jika tidak ingin mengubah kunci API yang saat ini tersimpan.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Base URL -->
                <div>
                    <label for="ai_base_url" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Endpoint Base URL <span class="text-red-500">*</span></label>
                    <input type="url" id="ai_base_url" name="ai_base_url" value="{{ old('ai_base_url', $ai_base_url) }}" placeholder="https://openrouter.ai/api/v1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs" required>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Tanpa akhiran <code>/chat/completions</code>.</p>
                </div>

                <!-- Timeout -->
                <div>
                    <label for="ai_timeout" class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Batas Waktu Tunggu (Timeout Detik) <span class="text-red-500">*</span></label>
                    <input type="number" id="ai_timeout" name="ai_timeout" value="{{ old('ai_timeout', $ai_timeout) }}" min="5" max="120" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs" required>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Rekomendasi: 30 - 60 detik agar aplikasi tidak crash saat server AI sibuk.</p>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="text-white bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-6 py-3 text-center dark:focus:ring-indigo-800 flex items-center gap-2 shadow-lg shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                    <span>Simpan Konfigurasi AI</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
