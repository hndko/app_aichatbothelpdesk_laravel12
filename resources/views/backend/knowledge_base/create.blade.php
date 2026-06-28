@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Nav -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 flex items-center justify-center text-2xl shrink-0 border border-indigo-100 dark:border-indigo-800 shadow-2xs">
                📝
            </div>
            <div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">{{ $title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tambahkan referensi tanya jawab untuk melatih wawasan AI Chatbot</p>
            </div>
        </div>
        <a href="{{ route('knowledge-base.index') }}" class="py-2.5 px-4 text-sm font-bold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center justify-center gap-2 transition-all shadow-2xs shrink-0">
            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- AI Tips Banner -->
    <div class="p-4 rounded-2xl bg-indigo-50/80 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800/60 flex items-start gap-3 text-indigo-900 dark:text-indigo-200">
        <span class="text-xl shrink-0">💡</span>
        <div class="text-xs leading-relaxed">
            <strong class="font-bold block text-sm mb-0.5">Tips Penulisan FAQ untuk AI:</strong>
            Gunakan kalimat pertanyaan yang natural (seolah-olah ditanyakan langsung oleh pelapor). Pada kolom jawaban, tulis instruksi solutif secara rinci atau *step-by-step* agar asisten AI dapat menyimpulkannya dengan akurat saat menjawab percakapan.
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('knowledge-base.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Pertanyaan -->
            <div class="space-y-2">
                <label for="question" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    <span>Pertanyaan (FAQ)</span> <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="question"
                    name="question"
                    value="{{ old('question') }}"
                    placeholder="Contoh: Bagaimana cara reset password akun email kantor?"
                    class="bg-gray-50 border @error('question') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-semibold"
                    required
                >
                @error('question')
                    <p class="text-xs font-bold text-rose-600 dark:text-rose-400 flex items-center gap-1 mt-1">
                        <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Jawaban -->
            <div class="space-y-2">
                <label for="answer" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>Solusi / Jawaban Lengkap</span> <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="answer"
                    id="answer"
                    rows="8"
                    class="bg-gray-50 border @error('answer') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-medium leading-relaxed"
                    placeholder="Tulis jawaban solutif, detail langkah demi langkah yang mudah diikuti oleh karyawan..."
                    required
                >{{ old('answer') }}</textarea>
                @error('answer')
                    <p class="text-xs font-bold text-rose-600 dark:text-rose-400 flex items-center gap-1 mt-1">
                        <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Kategori & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-gray-100 dark:border-gray-700">
                <div class="space-y-2">
                    <label for="category_id" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>🏷️ Kategori Masalah</span>
                    </label>
                    <select name="category_id" id="category_id" class="bg-gray-50 border @error('category_id') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all font-semibold">
                        <option value="">-- Umum (Tanpa Kategori Khusus) --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ ucfirst($cat->name) }} {{ $cat->description ? '— '.$cat->description : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>⚡ Status Publikasi AI</span>
                    </label>
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Aktifkan sebagai referensi bot</span>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_active" name="is_active" value="1" class="sr-only peer" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:inset-s-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('knowledge-base.index') }}" class="w-full sm:w-auto py-3 px-6 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-extrabold rounded-xl text-sm px-6 py-3 text-center inline-flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20 transition-all cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18 1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5v-3h10v3Zm0-5H5V3h10v7Z"/></svg>
                    <span>Simpan ke Knowledge Base</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
