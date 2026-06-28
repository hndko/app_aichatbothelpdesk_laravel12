@extends('layouts.app-backend')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header Banner Premium -->
    <div class="bg-linear-to-r from-indigo-600 via-purple-600 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden border border-white/10">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col sm:flex-row items-center gap-5 z-10 text-center sm:text-left">
            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md text-white flex items-center justify-center text-3xl shadow-inner shrink-0 border border-white/20">
                🤖
            </div>
            <div>
                <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        AI Engine Aktif
                    </span>
                    <span class="text-xs text-indigo-200 font-semibold uppercase tracking-wider">{{ strtoupper($ai_provider) }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Konfigurasi AI Provider & Model</h1>
                <p class="text-indigo-100 text-sm mt-1 max-w-xl">Sesuaikan mesin kecerdasan buatan (*Large Language Model*) yang menjadi otak chatbot otomatis dalam membalas keluhan pelapor.</p>
            </div>
        </div>
    </div>

    <!-- Alert Success/Error -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 shadow-xs">
            <svg class="w-6 h-6 shrink-0 text-emerald-600 dark:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 shadow-xs">
            <div class="flex items-center gap-2 font-bold mb-2">
                <svg class="w-5 h-5 shrink-0 text-rose-600 dark:text-rose-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>
                <span>Terdapat kesalahan pengisian form:</span>
            </div>
            <ul class="list-disc list-inside text-sm space-y-1 ps-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Utama -->
    <form action="{{ route('ai-setting.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- STEP 1: Pilih Provider -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 space-y-6 transition-all">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4">
                <div>
                    <span class="text-xs font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest block mb-1">Langkah 1 dari 2</span>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Pilih Penyedia Layanan AI (LLM Provider)</h2>
                </div>
                <span class="text-xs font-semibold px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full">Wajib Dipilih</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- OpenRouter -->
                <label class="provider-card relative flex items-start p-5 rounded-2xl border-2 cursor-pointer transition-all hover:shadow-md {{ $ai_provider === 'openrouter' ? 'border-indigo-600 bg-indigo-50/60 dark:bg-indigo-900/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800' }}">
                    <input type="radio" name="ai_provider" value="openrouter" class="sr-only" {{ $ai_provider === 'openrouter' ? 'checked' : '' }}>
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300 flex items-center justify-center text-2xl shrink-0 me-4">
                        🌐
                    </div>
                    <div class="grow">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-extrabold text-gray-900 dark:text-white">OpenRouter AI</span>
                            <span class="provider-badge {{ $ai_provider === 'openrouter' ? 'inline-block' : 'hidden' }} w-2.5 h-2.5 rounded-full bg-indigo-600 shadow-sm"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Akses ke 100+ model AI (OpenAI GPT-4o, Claude 3.5, DeepSeek, Llama 3) hanya dengan 1 API Key.</p>
                        <span class="inline-block mt-3 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-indigo-100 dark:bg-indigo-900/60 text-indigo-800 dark:text-indigo-300">Rekomendasi Terbaik</span>
                    </div>
                </label>

                <!-- OpenAI Direct -->
                <label class="provider-card relative flex items-start p-5 rounded-2xl border-2 cursor-pointer transition-all hover:shadow-md {{ $ai_provider === 'openai' ? 'border-indigo-600 bg-indigo-50/60 dark:bg-indigo-900/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800' }}">
                    <input type="radio" name="ai_provider" value="openai" class="sr-only" {{ $ai_provider === 'openai' ? 'checked' : '' }}>
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-300 flex items-center justify-center text-2xl shrink-0 me-4">
                        ⚡
                    </div>
                    <div class="grow">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-extrabold text-gray-900 dark:text-white">OpenAI Direct</span>
                            <span class="provider-badge {{ $ai_provider === 'openai' ? 'inline-block' : 'hidden' }} w-2.5 h-2.5 rounded-full bg-indigo-600 shadow-sm"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Koneksi langsung ke server resmi OpenAI (GPT-3.5 Turbo, GPT-4o Mini, GPT-4o). Sangat stabil & cepat.</p>
                        <span class="inline-block mt-3 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300">Resmi & Stabil</span>
                    </div>
                </label>

                <!-- Google Gemini -->
                <label class="provider-card relative flex items-start p-5 rounded-2xl border-2 cursor-pointer transition-all hover:shadow-md {{ $ai_provider === 'gemini' ? 'border-indigo-600 bg-indigo-50/60 dark:bg-indigo-900/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800' }}">
                    <input type="radio" name="ai_provider" value="gemini" class="sr-only" {{ $ai_provider === 'gemini' ? 'checked' : '' }}>
                    <div class="w-12 h-12 rounded-xl bg-sky-100 dark:bg-sky-900/50 text-sky-600 dark:text-sky-300 flex items-center justify-center text-2xl shrink-0 me-4">
                        ✨
                    </div>
                    <div class="grow">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-extrabold text-gray-900 dark:text-white">Google Gemini</span>
                            <span class="provider-badge {{ $ai_provider === 'gemini' ? 'inline-block' : 'hidden' }} w-2.5 h-2.5 rounded-full bg-indigo-600 shadow-sm"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Model LLM generasi terbaru dari Google (Gemini 1.5 Flash / Pro) via endpoint kompatibel OpenAI.</p>
                        <span class="inline-block mt-3 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-sky-100 dark:bg-sky-900/60 text-sky-800 dark:text-sky-300">Kecepatan Tinggi</span>
                    </div>
                </label>

                <!-- Custom Base URL -->
                <label class="provider-card relative flex items-start p-5 rounded-2xl border-2 cursor-pointer transition-all hover:shadow-md {{ $ai_provider === 'custom' ? 'border-indigo-600 bg-indigo-50/60 dark:bg-indigo-900/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800' }}">
                    <input type="radio" name="ai_provider" value="custom" class="sr-only" {{ $ai_provider === 'custom' ? 'checked' : '' }}>
                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-300 flex items-center justify-center text-2xl shrink-0 me-4">
                        🔧
                    </div>
                    <div class="grow">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-extrabold text-gray-900 dark:text-white">Custom / Local LLM</span>
                            <span class="provider-badge {{ $ai_provider === 'custom' ? 'inline-block' : 'hidden' }} w-2.5 h-2.5 rounded-full bg-indigo-600 shadow-sm"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Hubungkan ke server LLM lokal (Ollama, LM Studio, vLLM) atau penyedia pihak ketiga lainnya.</p>
                        <span class="inline-block mt-3 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-amber-300">Self-Hosted</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- STEP 2: Parameter Konfigurasi (Muncul Dinamis Sesuai Pilihan) -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4 gap-2">
                <div>
                    <span class="text-xs font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest block mb-1">Langkah 2 dari 2</span>
                    <h2 id="section-title" class="text-lg font-bold text-gray-900 dark:text-white">Parameter Konfigurasi Model</h2>
                </div>
                <div id="provider-helper-badge" class="px-3 py-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-900/40 border border-indigo-100 dark:border-indigo-800 text-indigo-700 dark:text-indigo-300 text-xs font-bold flex items-center gap-2 w-fit">
                    <span>💡 Mengatur untuk:</span>
                    <span id="active-provider-label" class="underline decoration-2 underline-offset-2">OpenRouter AI</span>
                </div>
            </div>

            <!-- Dynamic Provider Info Box -->
            <div id="info-box" class="p-4 rounded-2xl bg-slate-50 dark:bg-gray-700/50 border border-slate-200 dark:border-gray-600 text-xs text-gray-600 dark:text-gray-300 flex items-start gap-3">
                <!-- Diisi via JS -->
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <!-- Nama Model -->
                <div class="space-y-2">
                    <label for="ai_model" class="block text-sm font-bold text-gray-900 dark:text-white">
                        Identifier Model AI <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="ai_model" name="ai_model" value="{{ old('ai_model', $ai_model) }}" placeholder="Contoh: openai/gpt-3.5-turbo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-mono" required>
                    </div>
                    
                    <!-- Quick Select Model Chips -->
                    <div class="pt-1">
                        <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 block mb-1.5 uppercase tracking-wider">⚡ Pilih Cepat Model Rekomendasi:</span>
                        <div id="model-chips-container" class="flex flex-wrap gap-1.5">
                            <!-- Diisi via JS -->
                        </div>
                    </div>
                </div>

                <!-- API Key -->
                <div class="space-y-2">
                    <label for="ai_api_key" class="block text-sm font-bold text-gray-900 dark:text-white">
                        API Key Rahasia
                    </label>
                    <div class="relative">
                        <input type="password" id="ai_api_key" name="ai_api_key" placeholder="{{ !empty($ai_api_key) ? '•••••••••••••••••••••••••••••••• (Tersimpan)' : 'Masukkan API Key baru...' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 pe-12 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-mono">
                        <button type="button" onclick="togglePasswordVisibility('ai_api_key')" class="absolute inset-y-0 inset-e-0 pe-3.5 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <svg id="eye-icon" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengubah kunci rahasia API Key yang saat ini aktif.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                <!-- Base URL -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="ai_base_url" class="block text-sm font-bold text-gray-900 dark:text-white">
                            Endpoint Base URL <span class="text-red-500">*</span>
                        </label>
                        <button type="button" id="btn-reset-url" class="text-[11px] font-bold text-blue-600 dark:text-blue-400 hover:underline cursor-pointer">
                            🔄 Reset ke URL Standar
                        </button>
                    </div>
                    <input type="url" id="ai_base_url" name="ai_base_url" value="{{ old('ai_base_url', $ai_base_url) }}" placeholder="https://openrouter.ai/api/v1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-mono" required>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Sistem otomatis menambahkan akhiran <code class="bg-gray-100 dark:bg-gray-700 px-1 py-0.5 rounded text-indigo-600 dark:text-indigo-400">/chat/completions</code>.</p>
                </div>

                <!-- Timeout -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="ai_timeout" class="block text-sm font-bold text-gray-900 dark:text-white">
                            Batas Waktu Tunggu (Timeout) <span class="text-red-500">*</span>
                        </label>
                        <span id="timeout-display" class="text-xs font-extrabold px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 rounded-md">{{ old('ai_timeout', $ai_timeout) }} Detik</span>
                    </div>
                    <input type="range" id="ai_timeout" name="ai_timeout" min="5" max="120" step="5" value="{{ old('ai_timeout', $ai_timeout) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-indigo-600">
                    <div class="flex justify-between text-[11px] text-gray-400">
                        <span>Cepat (5s)</span>
                        <span>Normal (30s)</span>
                        <span>Maksimal (120s)</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-amber-500 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>
                    <span>Perubahan akan langsung diterapkan pada interaksi Chatbot berikutnya.</span>
                </div>
                <button type="submit" class="w-full sm:w-auto text-white bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-8 py-3.5 text-center dark:focus:ring-indigo-800 flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/30 transition-all cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                    <span>Simpan & Terapkan Konfigurasi</span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const providerCards = document.querySelectorAll('.provider-card');
    const providerRadios = document.querySelectorAll('input[name="ai_provider"]');
    const activeProviderLabel = document.getElementById('active-provider-label');
    const infoBox = document.getElementById('info-box');
    const modelChipsContainer = document.getElementById('model-chips-container');
    const baseUrlInput = document.getElementById('ai_base_url');
    const btnResetUrl = document.getElementById('btn-reset-url');
    const timeoutInput = document.getElementById('ai_timeout');
    const timeoutDisplay = document.getElementById('timeout-display');
    const modelInput = document.getElementById('ai_model');

    const providerConfigs = {
        openrouter: {
            label: 'OpenRouter AI',
            defaultUrl: 'https://openrouter.ai/api/v1',
            infoHtml: `<span class="text-xl shrink-0">🌐</span><div><strong class="font-bold text-gray-900 dark:text-white">OpenRouter AI Active:</strong> Platform aggregator terbaik. Anda dapat menggunakan ratusan model LLM terkemuka dunia dengan satu API Key OpenRouter. Dapatkan kunci API di <a href="https://openrouter.ai/keys" target="_blank" class="text-blue-600 dark:text-blue-400 underline font-semibold">openrouter.ai</a>.</div>`,
            models: [
                { id: 'openai/gpt-3.5-turbo', name: 'GPT-3.5 Turbo' },
                { id: 'openai/gpt-4o-mini', name: 'GPT-4o Mini' },
                { id: 'google/gemini-2.0-flash-lite-preview-02-05:free', name: 'Gemini 2.0 Flash (Free)' },
                { id: 'meta-llama/llama-3-8b-instruct', name: 'Llama 3 8B' }
            ]
        },
        openai: {
            label: 'OpenAI Direct',
            defaultUrl: 'https://api.openai.com/v1',
            infoHtml: `<span class="text-xl shrink-0">⚡</span><div><strong class="font-bold text-gray-900 dark:text-white">OpenAI Direct Active:</strong> Menghubungkan langsung aplikasi dengan server resmi OpenAI. Dapatkan API Key di <a href="https://platform.openai.com/api-keys" target="_blank" class="text-blue-600 dark:text-blue-400 underline font-semibold">platform.openai.com</a>.</div>`,
            models: [
                { id: 'gpt-3.5-turbo', name: 'GPT-3.5 Turbo' },
                { id: 'gpt-4o-mini', name: 'GPT-4o Mini' },
                { id: 'gpt-4o', name: 'GPT-4o Omni' }
            ]
        },
        gemini: {
            label: 'Google Gemini',
            defaultUrl: 'https://generativelanguage.googleapis.com/v1beta/openai',
            infoHtml: `<span class="text-xl shrink-0">✨</span><div><strong class="font-bold text-gray-900 dark:text-white">Google Gemini Active:</strong> Menggunakan kompatibilitas endpoint OpenAI dari Google AI Studio. Dapatkan API Key gratis di <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-blue-600 dark:text-blue-400 underline font-semibold">aistudio.google.com</a>.</div>`,
            models: [
                { id: 'gemini-1.5-flash', name: 'Gemini 1.5 Flash' },
                { id: 'gemini-1.5-pro', name: 'Gemini 1.5 Pro' },
                { id: 'gemini-2.0-flash', name: 'Gemini 2.0 Flash' }
            ]
        },
        custom: {
            label: 'Custom / Local LLM',
            defaultUrl: 'http://localhost:11434/v1',
            infoHtml: `<span class="text-xl shrink-0">🔧</span><div><strong class="font-bold text-gray-900 dark:text-white">Custom Endpoint Active:</strong> Gunakan alamat IP / domain server AI lokal Anda (seperti Ollama pada port 11434 atau LM Studio). Pastikan server mendukung format API OpenAI.</div>`,
            models: [
                { id: 'llama3', name: 'Llama 3' },
                { id: 'mistral', name: 'Mistral 7B' },
                { id: 'deepseek-r1', name: 'DeepSeek R1' }
            ]
        }
    };

    function updateUiForProvider(providerKey, isUserClick = false) {
        const config = providerConfigs[providerKey] || providerConfigs['openrouter'];

        // Update card styles
        providerCards.forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            const badge = card.querySelector('.provider-badge');
            if (radio && radio.value === providerKey) {
                radio.checked = true;
                card.className = 'provider-card relative flex items-start p-5 rounded-2xl border-2 cursor-pointer transition-all border-indigo-600 bg-indigo-50/60 dark:bg-indigo-900/20 shadow-sm';
                if (badge) badge.classList.remove('hidden');
            } else if (radio) {
                card.className = 'provider-card relative flex items-start p-5 rounded-2xl border-2 cursor-pointer transition-all border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800';
                if (badge) badge.classList.add('hidden');
            }
        });

        // Update active label & info box
        if (activeProviderLabel) activeProviderLabel.textContent = config.label;
        if (infoBox) infoBox.innerHTML = config.infoHtml;

        // Auto update base URL ONLY if clicked by user OR input is empty
        if (isUserClick || !baseUrlInput.value.trim()) {
            baseUrlInput.value = config.defaultUrl;
        }

        // Render Quick Select Chips
        if (modelChipsContainer) {
            modelChipsContainer.innerHTML = '';
            config.models.forEach(m => {
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'px-3 py-1 text-xs font-bold rounded-lg bg-indigo-50 hover:bg-indigo-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-indigo-700 dark:text-indigo-300 border border-indigo-200/60 dark:border-gray-600 transition-all cursor-pointer flex items-center gap-1';
                chip.innerHTML = `<span>${m.name}</span> <code class="text-[10px] opacity-75 font-mono">(${m.id})</code>`;
                chip.addEventListener('click', () => {
                    modelInput.value = m.id;
                    modelInput.focus();
                    modelInput.classList.add('ring-2', 'ring-indigo-500');
                    setTimeout(() => modelInput.classList.remove('ring-2', 'ring-indigo-500'), 500);
                });
                modelChipsContainer.appendChild(chip);
            });
        }
    }

    // Radio change listeners
    providerRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            updateUiForProvider(e.target.value, true);
        });
    });

    // Reset URL button
    if (btnResetUrl) {
        btnResetUrl.addEventListener('click', () => {
            const activeRadio = document.querySelector('input[name="ai_provider"]:checked');
            if (activeRadio && providerConfigs[activeRadio.value]) {
                baseUrlInput.value = providerConfigs[activeRadio.value].defaultUrl;
                baseUrlInput.focus();
            }
        });
    }

    // Timeout slider display
    if (timeoutInput && timeoutDisplay) {
        timeoutInput.addEventListener('input', (e) => {
            timeoutDisplay.textContent = e.target.value + ' Detik';
        });
    }

    // Initialize with current selected provider
    const initialRadio = document.querySelector('input[name="ai_provider"]:checked') || providerRadios[0];
    if (initialRadio) {
        updateUiForProvider(initialRadio.value, false);
    }
});

function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        input.type = input.type === 'password' ? 'text' : 'password';
    }
}
</script>
@endpush
@endsection
