@extends('layouts.app-backend')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola artikel FAQ yang menjadi referensi jawaban AI Chatbot</p>
    </div>

    <a href="{{ route('knowledge-base.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center gap-2 shadow-md shadow-blue-500/20 transition-all">
        <svg class="w-5 h-5 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
        <span>Tambah Artikel</span>
    </a>
</div>

<!-- Filter & Search Flowbite Card -->
<div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
    <form action="{{ route('knowledge-base.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
        <div class="md:col-span-5 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
            </div>
            <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all" placeholder="Cari pertanyaan atau jawaban..." value="{{ request('search') }}">
        </div>

        <div class="md:col-span-4">
            <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ ucfirst($cat->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-3 flex items-center gap-2">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 w-full transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search', 'category_id']))
                <a href="{{ route('knowledge-base.index') }}" class="py-2.5 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 flex items-center justify-center" title="Reset">
                    <svg class="w-4 h-4 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Flowbite -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3.5 w-12">#</th>
                    <th scope="col" class="px-6 py-3.5">Pertanyaan (FAQ)</th>
                    <th scope="col" class="px-6 py-3.5">Kategori</th>
                    <th scope="col" class="px-6 py-3.5">Status</th>
                    <th scope="col" class="px-6 py-3.5">Diperbarui</th>
                    <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($articles as $idx => $article)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 text-gray-400 font-medium">{{ $articles->firstItem() + $idx }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white mb-1">{{ \Illuminate\Support\Str::limit($article->question, 60) }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit(strip_tags($article->answer), 80) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($article->category)
                                <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    {{ strtoupper($article->category->name) }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">Umum</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($article->is_active)
                                <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1 rounded dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/></svg>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9-3a1 1 0 1 0-2 0v6a1 1 0 1 0 2 0V9Zm4 0a1 1 0 1 0-2 0v6a1 1 0 1 0 2 0V9Z" clip-rule="evenodd"/></svg>
                                    <span>Nonaktif</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">{{ $article->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('knowledge-base.edit', $article->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/></svg>
                                </a>

                                <form action="{{ route('knowledge-base.destroy', $article->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-gray-700 transition-colors" title="Hapus" onclick="return confirm('Yakin ingin menghapus artikel FAQ ini?')">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 opacity-40 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z" clip-rule="evenodd"/></svg>
                            <p class="text-sm">Belum ada artikel knowledge base.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
