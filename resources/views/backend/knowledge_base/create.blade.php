@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tambahkan pertanyaan umum beserta solusinya untuk memperkaya AI Chatbot</p>
        </div>
        <a href="{{ route('knowledge-base.index') }}" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center gap-1 transition-all">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('knowledge-base.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    <i class="bi bi-question-circle me-1 text-blue-600 dark:text-blue-400"></i> Pertanyaan (FAQ) <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="question"
                    name="question"
                    value="{{ old('question') }}"
                    placeholder="Contoh: Bagaimana cara reset password email kantor?"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all @error('question') border-red-500 @enderror"
                    required
                >
                @error('question')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="answer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    <i class="bi bi-chat-right-text me-1 text-blue-600 dark:text-blue-400"></i> Jawaban <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="answer"
                    id="answer"
                    rows="8"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all @error('answer') border-red-500 @enderror"
                    placeholder="Tulis jawaban step-by-step yang jelas dan mudah diikuti oleh karyawan..."
                    required
                >{{ old('answer') }}</textarea>
                @error('answer')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        <i class="bi bi-tags me-1 text-blue-600 dark:text-blue-400"></i> Kategori
                    </label>
                    <select name="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all @error('category_id') border-red-500 @enderror">
                        <option value="">-- Umum (Tanpa Kategori) --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ ucfirst($cat->name) }} — {{ $cat->description ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        <i class="bi bi-toggle-on me-1 text-blue-600 dark:text-blue-400"></i> Status Artikel
                    </label>
                    <label class="inline-flex items-center cursor-pointer mt-1">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="sr-only peer" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">Aktif (tampil sebagai referensi AI)</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('knowledge-base.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-all">
                    Batal
                </a>
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center gap-2 shadow-md shadow-blue-500/20 transition-all">
                    <i class="bi bi-save"></i> Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
