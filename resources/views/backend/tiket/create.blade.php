@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">Laporkan kendala IT yang Anda alami secara detail</p>
        </div>
        <a href="{{ route('tiket.index') }}" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center gap-1 transition-all">
            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('tiket.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"><path d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3.546l3.2 3.659a1 1 0 0 0 1.506 0L13.454 14H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-8 10H5a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Zm5-4H5a1 1 0 0 1 0-2h10a1 1 0 1 1 0 2Z"/></svg>
                    <span>Subjek Kendala</span> <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    placeholder="Contoh: Laptop mati total saat charge atau Koneksi Wi-Fi putus-putus"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('subject') border-red-500 @enderror"
                    required
                >
                @error('subject')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/><path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/></svg>
                        <span>Kategori Masalah</span> <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all @error('category_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ strtoupper($cat->name) }} — {{ $cat->description ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>
                        <span>Tingkat Prioritas</span> <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" id="priority" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all @error('priority') border-red-500 @enderror" required>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low (Rendah)</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium (Sedang)</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High (Darurat / Mendesak)</option>
                    </select>
                    @error('priority')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"/></svg>
                    <span>Deskripsi Detail Kendala</span> <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="6"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('description') border-red-500 @enderror"
                    placeholder="Jelaskan secara kronologis kapan kendala terjadi, pesan error yang muncul, atau langkah yang sudah Anda coba..."
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center p-4 text-sm text-blue-800 border border-blue-300 rounded-xl bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800 gap-3" role="alert">
                <svg class="w-7 h-7 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/></svg>
                <div>
                    <span class="font-semibold">Asisten AI Otomatis:</span> AI Chatbot kami akan langsung menganalisis laporan Anda dan memberikan solusi FAQ instan setelah tiket ini dikirim.
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('tiket.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-all">
                    Batal
                </a>
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center gap-2 shadow-md shadow-blue-500/20 transition-all">
                    <svg class="w-4 h-4 shrink-0 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="m17.914 8.594-16-8.5A1 1 0 0 0 .658.347l2.853 8.358a1 1 0 0 0 .943.695h7.24a1 1 0 0 1 0 2h-7.24a1 1 0 0 0-.944.695L.658 20.453a1 1 0 0 0 1.256 1.257l16-8.5a1 1 0 0 0 0-1.761Z"/></svg>
                    <span>Kirim Tiket</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
