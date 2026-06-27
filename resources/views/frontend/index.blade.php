@extends('layouts.app-frontend')

@section('content')

<!-- Hero Banner & Search Section -->
<section class="relative bg-gradient-to-r from-blue-700 via-indigo-800 to-slate-900 py-20 px-4 text-center overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-400/10 via-transparent to-transparent pointer-events-none"></div>
    
    <div class="max-w-4xl mx-auto relative z-10">
        <span class="inline-flex items-center gap-1.5 bg-white/10 dark:bg-white/5 text-blue-200 dark:text-blue-300 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-semibold mb-6 border border-white/20 shadow-sm animate-fade-in">
            <i class="bi bi-robot text-sm"></i> Knowledge Base AI Helpdesk
        </span>
        
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 tracking-tight leading-tight">
            Apa yang bisa kami bantu hari ini?
        </h1>
        
        <p class="text-lg text-blue-100/80 max-w-2xl mx-auto mb-8 font-normal">
            Temukan panduan teknis dan solusi cepat untuk kendala IT kantor Anda seketika sebelum membuat tiket layanan.
        </p>
    </div>
</section>

<!-- Floating Search Bar Flowbite Card -->
<div class="max-w-3xl mx-auto px-4 -mt-8 relative z-20">
    <div class="bg-white dark:bg-gray-800 p-2 sm:p-3 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700">
        <form action="{{ route('portal') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-blue-600 dark:text-blue-400 text-lg">
                    <i class="bi bi-search"></i>
                </div>
                <input
                    type="text"
                    name="search"
                    class="bg-transparent border-0 text-gray-900 text-base rounded-xl focus:ring-0 block w-full ps-12 p-3 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Ketik kata kunci masalah (contoh: wifi lemot, printer macet)..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
            </div>
            
            <button type="submit" class="text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-sm px-6 py-3 text-center transition-all shadow-md flex-shrink-0">
                Cari Solusi
            </button>
        </form>
    </div>
</div>

<!-- Main FAQ Content Section -->
<section class="max-w-7xl mx-auto px-4 py-12">

    <!-- Category Pills Filter -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
        <a href="{{ route('portal', ['search' => request('search')]) }}" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all flex items-center gap-2 {{ !request('category_id') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <i class="bi bi-grid-fill"></i> Semua Kategori
        </a>
        @foreach($categories as $cat)
            @php
                $icon = match($cat->name) {
                    'hardware' => 'bi-cpu',
                    'software' => 'bi-window',
                    'network'  => 'bi-wifi',
                    default    => 'bi-tag',
                };
            @endphp
            <a href="{{ route('portal', ['category_id' => $cat->id, 'search' => request('search')]) }}" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all flex items-center gap-2 {{ request('category_id') == $cat->id ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <i class="bi {{ $icon }}"></i> {{ ucfirst($cat->name) }}
            </a>
        @endforeach
    </div>

    <!-- Active Filter Feedback -->
    @if(request('search') || request('category_id'))
        <div class="flex flex-col sm:flex-row items-center justify-between bg-blue-50/60 dark:bg-gray-800/80 p-4 rounded-2xl mb-8 border border-blue-100 dark:border-gray-700 text-sm">
            <div class="text-gray-600 dark:text-gray-300 mb-2 sm:mb-0">
                Menampilkan hasil pencarian
                @if(request('search')) untuk <span class="font-bold text-gray-900 dark:text-white">"{{ request('search') }}"</span> @endif
                @if(request('category_id')) pada kategori <span class="font-bold text-gray-900 dark:text-white">{{ strtoupper($categories->firstWhere('id', request('category_id'))?->name ?? '') }}</span> @endif
            </div>
            <a href="{{ route('portal') }}" class="py-1.5 px-3 text-xs font-semibold text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 inline-flex items-center gap-1.5 transition-all">
                <i class="bi bi-x-circle"></i> Reset Pencarian
            </a>
        </div>
    @endif

    <!-- FAQ Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-lg transition-all transform hover:-translate-y-1">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        @if($article->category)
                            <span class="bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-xs font-bold px-3 py-1 rounded-full border border-blue-200 dark:border-blue-800">
                                {{ strtoupper($article->category->name) }}
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 text-xs font-bold px-3 py-1 rounded-full">UMUM</span>
                        @endif
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="bi bi-clock"></i> {{ $article->updated_at->diffForHumans() }}
                        </span>
                    </div>

                    <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 leading-snug">
                        {{ $article->question }}
                    </h5>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-3">
                        {{ strip_tags($article->answer) }}
                    </p>
                </div>

                <button type="button" data-modal-target="faqModal{{ $article->id }}" data-modal-toggle="faqModal{{ $article->id }}" class="w-full py-2.5 px-4 text-sm font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-xl hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white flex items-center justify-center gap-1 transition-all mt-auto">
                    <span>Baca Panduan Solusi</span> <i class="bi bi-arrow-right text-base"></i>
                </button>
            </div>

            <!-- FAQ Detail Flowbite Modal -->
            <div id="faqModal{{ $article->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-3xl max-h-full">
                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-6 border-b rounded-t dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                            <div>
                                <span class="inline-block bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded mb-2">
                                    {{ strtoupper($article->category->name ?? 'UMUM') }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-relaxed">
                                    {{ $article->question }}
                                </h3>
                            </div>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="faqModal{{ $article->id }}">
                                <i class="bi bi-x-lg text-lg"></i>
                                <span class="sr-only">Tutup modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-4">
                            <h4 class="text-base font-bold text-blue-600 dark:text-blue-400 flex items-center gap-2">
                                <i class="bi bi-check2-circle text-lg"></i> Langkah-Langkah Penyelesaian:
                            </h4>
                            <div class="text-gray-700 dark:text-gray-300 text-sm sm:text-base leading-relaxed space-y-2">
                                {!! nl2br(e($article->answer)) !!}
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center justify-between p-6 border-t border-gray-200 rounded-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            <span class="text-xs text-gray-400">Terakhir diperbarui: {{ $article->updated_at->format('d M Y, H:i') }}</span>
                            <button data-modal-hide="faqModal{{ $article->id }}" type="button" class="py-2 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 transition-all">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 max-w-md mx-auto">
                    <i class="bi bi-search text-5xl text-gray-300 dark:text-gray-600 block mb-4"></i>
                    <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Artikel Tidak Ditemukan</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Maaf, kami tidak menemukan artikel panduan yang sesuai dengan pencarian Anda.</p>
                    <a href="{{ route('portal') }}" class="py-2 px-5 text-sm font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 dark:bg-gray-700 dark:text-blue-400 dark:hover:bg-gray-600 inline-block transition-all">Lihat Semua FAQ</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="flex justify-center mt-12">
            {{ $articles->links() }}
        </div>
    @endif

</section>

<!-- Call to Action Banner -->
<section class="max-w-7xl mx-auto px-4 mb-16">
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-900 text-white p-8 sm:p-12 rounded-3xl text-center shadow-xl relative overflow-hidden border border-white/10">
        <div class="relative z-10 max-w-xl mx-auto">
            <h3 class="text-2xl sm:text-3xl font-bold mb-3">Masalah Anda belum terselesaikan?</h3>
            <p class="text-blue-200/80 text-sm sm:text-base mb-8">
                Jangan khawatir! Tim IT Helpdesk dan asisten AI kami siap membantu mendiagnosis masalah Anda secara spesifik.
            </p>
            @auth
                <a href="{{ route('tiket.create') }}" class="inline-flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 font-semibold rounded-xl text-base px-6 py-3.5 shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-0.5">
                    <i class="bi bi-plus-circle text-lg"></i> Buat Tiket Kendala Baru
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 font-semibold rounded-xl text-base px-6 py-3.5 shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-0.5">
                    <i class="bi bi-box-arrow-in-right text-lg"></i> Login & Submit Tiket Kendala
                </a>
            @endauth
        </div>
    </div>
</section>

@endsection
