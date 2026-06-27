@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui konten artikel FAQ knowledge base</p>
        </div>
        <a href="{{ route('knowledge-base.index') }}" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center gap-1 transition-all">
            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('knowledge-base.update', $article->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.479-1.044ZM11 17a1 1 0 1 0 2 0 1 1 0 0 0-2 0Z" clip-rule="evenodd"/></svg>
                    <span>Pertanyaan (FAQ)</span> <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="question"
                    name="question"
                    value="{{ old('question', $article->question) }}"
                    placeholder="Contoh: Bagaimana cara reset password email kantor?"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all @error('question') border-red-500 @enderror"
                    required
                >
                @error('question')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="answer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"><path d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3.546l3.2 3.659a1 1 0 0 0 1.506 0L13.454 14H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-8 10H5a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Zm5-4H5a1 1 0 0 1 0-2h10a1 1 0 1 1 0 2Z"/></svg>
                    <span>Jawaban</span> <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="answer"
                    id="answer"
                    rows="8"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all @error('answer') border-red-500 @enderror"
                    placeholder="Tulis jawaban step-by-step yang jelas dan mudah diikuti oleh karyawan..."
                    required
                >{{ old('answer', $article->answer) }}</textarea>
                @error('answer')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/><path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/></svg>
                        <span>Kategori</span>
                    </label>
                    <select name="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all @error('category_id') border-red-500 @enderror">
                        <option value="">-- Umum (Tanpa Kategori) --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ ucfirst($cat->name) }} — {{ $cat->description ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M16 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-8 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm6-4a4 4 0 1 0 0 8h8a4 4 0 1 0 0-8H8Z" clip-rule="evenodd"/></svg>
                        <span>Status Artikel</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer mt-1">
                        <input type="checkbox" id="is_active" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $article->is_active) ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:inset-s-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">Aktif (tampil sebagai referensi AI)</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('knowledge-base.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-all">
                    Batal
                </a>
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center gap-2 shadow-md shadow-blue-500/20 transition-all">
                    <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18 1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5v-3h10v3Zm0-5H5V3h10v7Z"/></svg>
                    <span>Perbarui Artikel</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
