@extends('layouts.app-backend')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Banner Premium -->
    <div class="bg-linear-to-r from-blue-600 via-indigo-600 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden border border-white/10">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col sm:flex-row items-center gap-5 z-10 text-center sm:text-left">
            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md text-white flex items-center justify-center text-3xl shadow-inner shrink-0 border border-white/20">
                📚
            </div>
            <div>
                <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-blue-400/20 text-blue-200 border border-blue-400/30 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        AI Knowledge Source
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $title }}</h1>
                <p class="text-blue-100 text-sm mt-1 max-w-xl">Pusat pangkalan pengetahuan dan referensi solusi otomatis untuk AI Chatbot dalam menjawab pertanyaan pelapor.</p>
            </div>
        </div>

        <div class="z-10 shrink-0 w-full sm:w-auto">
            <a href="{{ route('knowledge-base.create') }}" class="w-full sm:w-auto px-5 py-3.5 rounded-2xl bg-white text-indigo-900 font-extrabold text-sm shadow-lg hover:bg-blue-50 transition-all flex items-center justify-center gap-2 hover:scale-105 active:scale-95">
                <svg class="w-5 h-5 text-indigo-600 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h14m-7 7V5"/></svg>
                <span>Tambah Artikel FAQ</span>
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 shadow-xs">
            <svg class="w-6 h-6 shrink-0 text-emerald-600 dark:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter & Search Card -->
    <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <form action="{{ route('knowledge-base.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <div class="md:col-span-5 relative">
                <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                </div>
                <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full ps-10 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-medium" placeholder="Cari pertanyaan atau jawaban FAQ..." value="{{ request('search') }}">
            </div>

            <div class="md:col-span-4">
                <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all font-medium">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ ucfirst($cat->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-3 w-full transition-all shadow-sm cursor-pointer flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2.586a1 1 0 0 1-.293.707l-6.414 6.414a1 1 0 0 0-.293.707V17l-4 4v-6.586a1 1 0 0 0-.293-.707L3.293 7.293A1 1 0 0 1 3 6.586V4Z"/></svg>
                    <span>Filter</span>
                </button>
                @if(request()->hasAny(['search', 'category_id']))
                    <a href="{{ route('knowledge-base.index') }}" class="p-3 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl hover:bg-gray-200 hover:text-indigo-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white transition-all flex items-center justify-center shrink-0" title="Reset Filter">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 dark:bg-gray-700/80 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 font-extrabold">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-12 text-center">#</th>
                        <th scope="col" class="px-6 py-4 min-w-75">Pertanyaan & Solusi FAQ</th>
                        <th scope="col" class="px-6 py-4">Kategori</th>
                        <th scope="col" class="px-6 py-4 text-center">Status AI</th>
                        <th scope="col" class="px-6 py-4">Diperbarui</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($articles as $idx => $article)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-indigo-50/30 dark:hover:bg-gray-700/40 transition-colors">
                            <td class="px-6 py-5 text-center font-bold text-gray-400">
                                {{ $articles->firstItem() + $idx }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-extrabold text-gray-900 dark:text-white text-base mb-1.5 flex items-start gap-2">
                                    <span class="text-indigo-600 dark:text-indigo-400 shrink-0">Q:</span>
                                    <span>{{ $article->question }}</span>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl border border-gray-200/60 dark:border-gray-600/60 flex items-start gap-2">
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400 shrink-0">A:</span>
                                    <span class="line-clamp-2">{{ strip_tags($article->answer) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($article->category)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                        {{ strtoupper($article->category->name) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                        Umum
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @if($article->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-2xs">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-600">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    <span>{{ $article->updated_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('knowledge-base.edit', $article->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl dark:text-indigo-400 dark:hover:bg-gray-700 transition-all font-bold flex items-center gap-1 text-xs border border-transparent hover:border-indigo-200 dark:hover:border-gray-600" title="Edit Artikel">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/></svg>
                                        <span class="hidden sm:inline">Edit</span>
                                    </a>

                                    <form action="{{ route('knowledge-base.destroy', $article->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl dark:text-rose-400 dark:hover:bg-gray-700 transition-all font-bold flex items-center gap-1 text-xs border border-transparent hover:border-rose-200 dark:hover:border-gray-600 cursor-pointer" title="Hapus Artikel" onclick="return confirm('Yakin ingin menghapus artikel FAQ ini dari pangkalan pengetahuan?')">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/></svg>
                                            <span class="hidden sm:inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                </div>
                                <h5 class="text-base font-bold text-gray-800 dark:text-gray-200 mb-1">Belum Ada Artikel FAQ</h5>
                                <p class="text-xs max-w-sm mx-auto mb-4">Tambahkan referensi tanya jawab untuk membuat AI Chatbot semakin pintar dalam membantu kendala pelapor.</p>
                                <a href="{{ route('knowledge-base.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm inline-flex items-center gap-1.5 transition-all">
                                    <span>+ Buat Artikel Pertama</span>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($articles->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
