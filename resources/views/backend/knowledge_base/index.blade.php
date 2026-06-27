@extends('layouts.app-backend')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola artikel FAQ yang menjadi referensi jawaban AI Chatbot</p>
    </div>

    <a href="{{ route('knowledge-base.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center gap-2 shadow-md shadow-blue-500/20 transition-all">
        <i class="bi bi-plus-lg text-lg"></i> Tambah Artikel
    </a>
</div>

<!-- Filter & Search Flowbite Card -->
<div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
    <form action="{{ route('knowledge-base.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
        <div class="md:col-span-5 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-400">
                <i class="bi bi-search"></i>
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
                    <i class="bi bi-x-lg"></i>
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
                                    <i class="bi bi-check-circle"></i> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200">
                                    <i class="bi bi-pause-circle"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">{{ $article->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('knowledge-base.edit', $article->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                    <i class="bi bi-pencil-square text-base"></i>
                                </a>

                                <form action="{{ route('knowledge-base.destroy', $article->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-gray-700 transition-colors" title="Hapus" onclick="return confirm('Yakin ingin menghapus artikel FAQ ini?')">
                                        <i class="bi bi-trash3 text-base"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-book text-4xl block mb-2 opacity-40"></i>
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
