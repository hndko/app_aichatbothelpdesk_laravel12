@extends('layouts.app-frontend')

@section('content')

<!-- Modern Hero Banner with Graphic Illustration -->
<section class="relative bg-linear-to-br from-slate-900 via-indigo-950 to-blue-950 py-16 lg:py-24 px-4 sm:px-6 lg:px-8 overflow-hidden border-b border-gray-800">
    <!-- Glowing background decorative circles -->
    <div class="absolute top-1/4 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Left Column: Typography & Search -->
        <div class="lg:col-span-7 text-center lg:text-left space-y-6">
            <div class="inline-flex items-center gap-2 bg-blue-500/10 dark:bg-blue-900/40 text-blue-300 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold border border-blue-400/20 shadow-inner">
                <span class="flex h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span>AI-Powered Helpdesk Knowledge Base</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Pusat Solusi & Layanan <br class="hidden sm:inline">
                <span class="bg-linear-to-r from-blue-400 via-indigo-300 to-teal-300 bg-clip-text text-transparent">IT Helpdesk Cerdas</span>
            </h1>

            <p class="text-base sm:text-lg text-blue-100/80 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                Temukan jawaban teknis akurat seketika yang ditenagai oleh Artificial Intelligence dari pangkalan pengetahuan resmi MariDesk sebelum Anda mengajukan tiket bantuan.
            </p>

            <!-- Search Card inside Hero for better desktop integration -->
            <div class="pt-2 max-w-xl mx-auto lg:mx-0">
                <div class="bg-white/95 dark:bg-gray-800/95 p-2 sm:p-2.5 rounded-2xl shadow-2xl border border-white/20 backdrop-blur-xl">
                    <form action="{{ route('portal') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                        @if(request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif

                        <div class="relative grow">
                            <div class="absolute inset-y-0 inset-s-0 flex items-center ps-4 pointer-events-none">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                            </div>
                            <input type="text" name="search"
                                class="bg-transparent border-0 text-gray-900 text-sm sm:text-base rounded-xl focus:ring-0 block w-full ps-12 p-3 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Cari masalah (cth: wifi lemot, printer)..."
                                value="{{ request('search') }}" autocomplete="off">
                        </div>

                        <button type="submit"
                            class="text-white bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-xl text-sm px-6 py-3 text-center transition-all shadow-md shrink-0 flex items-center justify-center gap-1.5">
                            <span>Cari Solusi</span>
                            <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Stats/Tags -->
            <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-blue-200/60 border-t border-white/10">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-green-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>Layanan 24/7 Aktif</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>Respon AI Instan</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>Eskalasi Tiket Mudah</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Modern Graphic Illustration -->
        <div class="lg:col-span-5 flex justify-center items-center relative">
            <div class="relative w-full max-w-md lg:max-w-none">
                <div class="absolute -inset-1 bg-linear-to-r from-blue-600 to-indigo-600 rounded-3xl blur-xl opacity-40 animate-pulse"></div>
                <img src="{{ asset('assets/images/hero-illustration.png') }}" 
                     alt="MariDesk AI Illustration" 
                     class="relative rounded-3xl shadow-2xl border border-white/10 w-full object-cover transform hover:scale-[1.02] transition-transform duration-500">
            </div>
        </div>
    </div>
</section>

<!-- Main FAQ Content Section -->
<section class="max-w-7xl mx-auto px-4 py-12">

    <!-- Category Pills Filter -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
        <a href="{{ route('portal', ['search' => request('search')]) }}"
            class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all flex items-center gap-2 {{ !request('category_id') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18"><path d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6 10H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Z"/></svg>
            <span>Semua Kategori</span>
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('portal', ['category_id' => $cat->id, 'search' => request('search')]) }}"
                class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all flex items-center gap-2 {{ request('category_id') == $cat->id ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                @if($cat->name === 'hardware')
                    <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10h-1V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4H2a1 1 0 0 0 0 2h1v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4h1a1 1 0 0 0 0-2ZM6 6h8v8H6V6Z"/></svg>
                @elseif($cat->name === 'software')
                    <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18 2H2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 6h16v12H2V6Z"/></svg>
                @elseif($cat->name === 'network')
                    <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v.01M16.5 7.5a6 6 0 0 0-9 0m12 3a9 9 0 0 0-15 0"/></svg>
                @else
                    <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/><path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/></svg>
                @endif
                <span>{{ ucfirst($cat->name) }}</span>
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
        <a href="{{ route('portal') }}"
            class="py-1.5 px-3 text-xs font-semibold text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 inline-flex items-center gap-1.5 transition-all">
            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>
            <span>Reset Pencarian</span>
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
                        <svg class="w-3.5 h-3.5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/></svg>
                        <span>{{ $article->updated_at->diffForHumans() }}</span>
                    </span>
                </div>

                <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 leading-snug">
                    {{ $article->question }}
                </h5>

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-3">
                    {{ strip_tags($article->answer) }}
                </p>
            </div>

            <button type="button" data-modal-target="faqModal{{ $article->id }}"
                data-modal-toggle="faqModal{{ $article->id }}"
                class="w-full py-2.5 px-4 text-sm font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-xl hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white flex items-center justify-center gap-1 transition-all mt-auto">
                <span>Baca Panduan Solusi</span>
                <svg class="w-4 h-4 shrink-0 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
            </button>
        </div>

        <!-- FAQ Detail Flowbite Modal -->
        <div id="faqModal{{ $article->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
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
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="faqModal{{ $article->id }}">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                            <span class="sr-only">Tutup modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                        <h4 class="text-base font-bold text-blue-600 dark:text-blue-400 flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                            <span>Langkah-Langkah Penyelesaian:</span>
                        </h4>
                        <div class="text-gray-700 dark:text-gray-300 text-sm sm:text-base leading-relaxed space-y-2">
                            {!! nl2br(e($article->answer)) !!}
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center justify-between p-6 border-t border-gray-200 rounded-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <span class="text-xs text-gray-400">Terakhir diperbarui: {{ $article->updated_at->format('d M Y, H:i') }}</span>
                        <button data-modal-hide="faqModal{{ $article->id }}" type="button"
                            class="py-2 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 transition-all">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 max-w-md mx-auto">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Artikel Tidak Ditemukan</h5>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Maaf, kami tidak menemukan artikel panduan yang sesuai dengan pencarian Anda.</p>
                <a href="{{ route('portal') }}"
                    class="py-2 px-5 text-sm font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 dark:bg-gray-700 dark:text-blue-400 dark:hover:bg-gray-600 inline-block transition-all">Lihat Semua FAQ</a>
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
    <div class="bg-linear-to-r from-slate-900 via-indigo-950 to-blue-900 text-white p-8 sm:p-12 rounded-3xl text-center shadow-xl relative overflow-hidden border border-white/10">
        <div class="relative z-10 max-w-xl mx-auto">
            <h3 class="text-2xl sm:text-3xl font-bold mb-3">Masalah Anda belum terselesaikan?</h3>
            <p class="text-blue-200/80 text-sm sm:text-base mb-8">
                Jangan khawatir! Tim IT Helpdesk dan asisten AI kami siap membantu mendiagnosis masalah Anda secara spesifik.
            </p>
            @auth
            <a href="{{ route('tiket.create') }}"
                class="inline-flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 font-semibold rounded-xl text-base px-6 py-3.5 shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm1 13a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 1 1 2 0v3h3a1 1 0 1 1 0 2h-3v3Z"/></svg>
                <span>Buat Tiket Kendala Baru</span>
            </a>
            @else
            <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 font-semibold rounded-xl text-base px-6 py-3.5 shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2Z"/></svg>
                <span>Login & Submit Tiket Kendala</span>
            </a>
            @endauth
        </div>
    </div>
</section>

@endsection
