@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 dark:bg-indigo-900/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="z-10">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span>✨</span>
                <span>{{ $title }}</span>
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sampaikan kendala teknis yang Anda alami. AI kami akan menganalisis dan memberikan saran awal secara instan.</p>
        </div>

        <div class="z-10 shrink-0">
            <a href="{{ route('tiket.index') }}" class="py-2.5 px-4 text-xs font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 hover:text-blue-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 inline-flex items-center gap-1.5 transition-all shadow-2xs">
                <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- AI Banner Tip -->
    <div class="bg-linear-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 shadow-md text-white flex items-start gap-4 relative overflow-hidden">
        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shrink-0 text-2xl">
            🤖
        </div>
        <div>
            <h4 class="font-bold text-base">Asisten AI Cerdas Siap Membantu!</h4>
            <p class="text-xs text-blue-100 mt-1 leading-relaxed">
                Begitu tiket dikirim, sistem kami akan langsung mengklasifikasikan urgensi masalah dan AI Chatbot akan menjawab FAQ atau memberikan panduan *troubleshooting* awal sebelum teknisi IT kami mengambil alih penanganan.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('tiket.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Subjek -->
            <div>
                <label for="subject" class="mb-2 text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.583 8.445h.01M10.86 19.71l-6.573-6.63a.993.993 0 0 1 0-1.4l7.329-7.394A.98.98 0 0 1 12.31 4l5.734.007A1.968 1.968 0 0 1 20 5.983v5.5a.992.992 0 0 1-.316.727l-7.44 7.5a.974.974 0 0 1-1.384.001Z"/></svg>
                    <span>Subjek Kendala</span> <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    placeholder="Contoh: Laptop mati total saat terhubung charger atau Wi-Fi ruangan lantai 2 tidak stabil"
                    @class([
                        'bg-gray-50 border text-gray-900 text-sm rounded-xl block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-2xs',
                        'border-red-500 focus:ring-red-500' => $errors->has('subject'),
                        'border-gray-200 focus:ring-blue-500 focus:border-blue-500' => !$errors->has('subject'),
                    ])
                    required
                >
                @error('subject')
                    <p class="mt-2 text-xs font-bold text-red-600 dark:text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Kategori Masalah -->
                <div>
                    <label for="category_id" class="mb-2 text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2m14 0V9a2 2 0 0 0-2-2M5 11V9a2 2 0 0 1 2-2m0 0V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 7h10"/></svg>
                        <span>Kategori Masalah</span> <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" @class([
                        'bg-gray-50 border text-gray-900 text-sm rounded-xl block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all shadow-2xs',
                        'border-red-500 focus:ring-red-500' => $errors->has('category_id'),
                        'border-gray-200 focus:ring-blue-500 focus:border-blue-500' => !$errors->has('category_id'),
                    ]) required>
                        <option value="">-- Pilih Kategori Kendala --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ strtoupper($cat->name) }} — {{ $cat->description ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-xs font-bold text-red-600 dark:text-red-500 flex items-center gap-1">
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Prioritas -->
                <div>
                    <label for="priority" class="mb-2 text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/></svg>
                        <span>Perkiraan Tingkat Urgensi</span> <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" id="priority" @class([
                        'bg-gray-50 border text-gray-900 text-sm rounded-xl block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all shadow-2xs',
                        'border-red-500 focus:ring-red-500' => $errors->has('priority'),
                        'border-gray-200 focus:ring-blue-500 focus:border-blue-500' => !$errors->has('priority'),
                    ]) required>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low — Tidak mengganggu pekerjaan utama</option>
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>🔵 Medium — Mengganggu sebagian aktivitas kerja</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High / Urgent — Pekerjaan lumpuh total / membutuhkan penanganan segera</option>
                    </select>
                    @error('priority')
                        <p class="mt-2 text-xs font-bold text-red-600 dark:text-red-500 flex items-center gap-1">
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi Detail -->
            <div>
                <label for="description" class="mb-2 text-sm font-bold text-gray-900 dark:text-white flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 9h5m3 0h2M7 12h2m3 0h5M5 5h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm0 10v5l4-5h10"/></svg>
                        <span>Deskripsi Detail Kendala</span> <span class="text-red-500">*</span>
                    </span>
                    <span class="text-xs font-normal text-gray-400">Jelaskan kronologi & pesan error jika ada</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Jelaskan secara rinci permasalahan Anda. Misalnya: 'Sejak jam 08.00 pagi, aplikasi akuntansi tidak bisa dibuka dan memunculkan error Database Connection Timeout...'"
                    @class([
                        'bg-gray-50 border text-gray-900 text-sm rounded-xl block w-full p-4 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-2xs',
                        'border-red-500 focus:ring-red-500' => $errors->has('description'),
                        'border-gray-200 focus:ring-blue-500 focus:border-blue-500' => !$errors->has('description'),
                    ])
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-xs font-bold text-red-600 dark:text-red-500 flex items-center gap-1">
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Submit Button Area -->
            <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('tiket.index') }}" class="w-full sm:w-auto py-3 px-6 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 text-center dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-all">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto text-white bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-8 py-3 text-center inline-flex items-center justify-center gap-2 shadow-lg shadow-blue-500/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                    <span>🚀 Kirim Tiket & Hubungkan dengan AI</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
