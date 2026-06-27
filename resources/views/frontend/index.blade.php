@extends('layouts.app-frontend')

@section('content')

<!-- Hero Banner & Search Section -->
<section class="hero-section">
    <div class="container position-relative z-2">
        <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-semibold mb-3 shadow-sm animate-fade-in">
            <i class="bi bi-robot me-1"></i> Knowledge Base AI Helpdesk
        </span>
        <h1 class="display-5 fw-bold mb-3 animate-slide-up" style="letter-spacing: -1px;">Apa yang bisa kami bantu hari ini?</h1>
        <p class="lead text-white-50 mx-auto mb-4 animate-slide-up" style="max-width: 600px; font-size: 1.1rem;">
            Temukan panduan teknis dan solusi cepat untuk kendala IT kantor Anda seketika sebelum membuat tiket layanan.
        </p>
    </div>
</section>

<!-- Floating Search Bar Card -->
<div class="container">
    <div class="hero-search-card">
        <div class="card border-0 shadow-lg p-2" style="border-radius: 16px;">
            <form action="{{ route('portal') }}" method="GET" class="d-flex gap-2">
                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
                <div class="input-group input-group-lg border-0">
                    <span class="input-group-text bg-transparent border-0 pe-1"><i class="bi bi-search text-primary fs-4"></i></span>
                    <input
                        type="text"
                        name="search"
                        class="form-control border-0 shadow-none fs-6 pe-3"
                        placeholder="Ketik kata kunci masalah (contoh: wifi lemot, printer macet, lupa password)..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >
                </div>
                <button type="submit" class="btn btn-nd-primary px-4 fw-semibold" style="border-radius: 12px; white-space: nowrap;">
                    Cari Solusi
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Main FAQ Content Section -->
<section class="container mb-5">

    <!-- Category Pills Filter -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <a href="{{ route('portal', ['search' => request('search')]) }}" class="category-pill {{ !request('category_id') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Semua Kategori
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('portal', ['category_id' => $cat->id, 'search' => request('search')]) }}" class="category-pill {{ request('category_id') == $cat->id ? 'active' : '' }}">
                @php
                    $icon = match($cat->name) {
                        'hardware' => 'bi-cpu',
                        'software' => 'bi-window',
                        'network'  => 'bi-wifi',
                        default    => 'bi-tag',
                    };
                @endphp
                <i class="bi {{ $icon }}"></i> {{ ucfirst($cat->name) }}
            </a>
        @endforeach
    </div>

    <!-- Active Filter Feedback -->
    @if(request('search') || request('category_id'))
        <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded-3 mb-4 border">
            <div class="small text-muted">
                Menampilkan hasil pencarian
                @if(request('search')) untuk <span class="fw-bold text-dark">"{{ request('search') }}"</span> @endif
                @if(request('category_id')) pada kategori <span class="fw-bold text-dark">{{ strtoupper($categories->firstWhere('id', request('category_id'))?->name ?? '') }}</span> @endif
            </div>
            <a href="{{ route('portal') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                <i class="bi bi-x-circle"></i> Reset Pencarian
            </a>
        </div>
    @endif

    <!-- FAQ Articles Grid -->
    <div class="row g-4">
        @forelse($articles as $article)
            <div class="col-md-6 col-lg-4">
                <div class="faq-card d-flex flex-column p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        @if($article->category)
                            <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle px-2 py-1" style="font-size: 0.7rem;">
                                {{ strtoupper($article->category->name) }}
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary-emphasis border px-2 py-1" style="font-size: 0.7rem;">UMUM</span>
                        @endif
                        <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>{{ $article->updated_at->diffForHumans() }}</small>
                    </div>

                    <h5 class="fw-bold text-dark mb-3 flex-grow-1" style="font-size: 1.05rem; line-height: 1.4;">
                        {{ $article->question }}
                    </h5>

                    <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ strip_tags($article->answer) }}
                    </p>

                    <button type="button" class="btn btn-nd-outline w-100 justify-content-center mt-auto" data-bs-toggle="modal" data-bs-target="#faqModal{{ $article->id }}">
                        Baca Panduan Solusi <i class="bi bi-arrow-right-short fs-5"></i>
                    </button>
                </div>
            </div>

            <!-- FAQ Detail Modal -->
            <div class="modal fade" id="faqModal{{ $article->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                        <div class="modal-header bg-light p-4 border-bottom">
                            <div>
                                <span class="badge bg-primary mb-2">{{ strtoupper($article->category->name ?? 'UMUM') }}</span>
                                <h5 class="modal-title fw-bold text-dark lh-base">{{ $article->question }}</h5>
                            </div>
                            <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4 p-md-5 bg-white">
                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-check2-circle me-2"></i>Langkah-Langkah Penyelesaian:</h6>
                            <div class="text-dark" style="line-height: 1.8; font-size: 0.95rem;">
                                {!! nl2br(e($article->answer)) !!}
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-3 d-flex justify-content-between align-items-center">
                            <small class="text-muted">Terakhir diperbarui: {{ $article->updated_at->format('d M Y, H:i') }}</small>
                            <button type="button" class="btn btn-secondary px-4 btn-sm" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card p-5 border-0 bg-light-subtle shadow-sm mx-auto" style="max-width: 500px; border-radius: 16px;">
                    <i class="bi bi-search text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                    <h5 class="fw-bold text-dark">Artikel Tidak Ditemukan</h5>
                    <p class="text-muted small mb-4">Maaf, kami tidak menemukan artikel panduan yang sesuai dengan pencarian Anda.</p>
                    <a href="{{ route('portal') }}" class="btn btn-nd-outline btn-sm mx-auto">Lihat Semua FAQ</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $articles->links() }}
        </div>
    @endif

</section>

<!-- Call to Action Banner -->
<section class="container mt-5">
    <div class="card border-0 text-white p-5 text-center shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 20px;">
        <div class="position-relative z-2">
            <h3 class="fw-bold mb-2">Masalah Anda belum terselesaikan?</h3>
            <p class="text-gray-light mb-4 mx-auto" style="max-width: 500px;">
                Jangan khawatir! Tim IT Helpdesk dan asisten AI kami siap membantu mendiagnosis masalah Anda secara spesifik.
            </p>
            @auth
                <a href="{{ route('tiket.create') }}" class="btn btn-nd-primary px-4 py-2 fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i> Buat Tiket Kendala Baru
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-nd-primary px-4 py-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right"></i> Login & Submit Tiket Kendala
                </a>
            @endauth
        </div>
    </div>
</section>

@endsection
