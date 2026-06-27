@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">Laporkan kendala IT yang Anda alami secara detail</p>
        </div>
        <a href="{{ route('tiket.index') }}" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center gap-1 transition-all">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('tiket.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    <i class="bi bi-chat-left-text me-1 text-blue-600 dark:text-blue-400"></i> Subjek Kendala <span class="text-red-500">*</span>
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
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        <i class="bi bi-tags me-1 text-blue-600 dark:text-blue-400"></i> Kategori Masalah <span class="text-red-500">*</span>
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
                    <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        <i class="bi bi-exclamation-triangle me-1 text-blue-600 dark:text-blue-400"></i> Tingkat Prioritas <span class="text-red-500">*</span>
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
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    <i class="bi bi-file-earmark-text me-1 text-blue-600 dark:text-blue-400"></i> Deskripsi Detail Kendala <span class="text-red-500">*</span>
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
                <i class="bi bi-robot text-2xl text-blue-600 dark:text-blue-400 flex-shrink-0"></i>
                <div>
                    <span class="font-semibold">Asisten AI Otomatis:</span> AI Chatbot kami akan langsung menganalisis laporan Anda dan memberikan solusi FAQ instan setelah tiket ini dikirim.
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('tiket.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-all">
                    Batal
                </a>
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center gap-2 shadow-md shadow-blue-500/20 transition-all">
                    <i class="bi bi-send-fill"></i> Kirim Tiket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
