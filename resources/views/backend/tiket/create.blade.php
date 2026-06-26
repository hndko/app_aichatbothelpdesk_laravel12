@extends('layouts.app-backend')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ $title }}</h4>
                <p class="text-muted small mb-0">Laporkan kendala IT yang Anda alami secara detail</p>
            </div>
            <a href="{{ route('tiket.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="nd-card animate-slide-up">
            <div class="nd-card-body p-4 p-md-5">
                <form action="{{ route('tiket.store') }}" method="POST">
                    @csrf

                    <div class="nd-form-group">
                        <label for="subject"><i class="bi bi-chat-left-text me-1"></i>Subjek Kendala <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control @error('subject') is-invalid @enderror"
                            id="subject"
                            name="subject"
                            value="{{ old('subject') }}"
                            placeholder="Contoh: Laptop mati total saat charge atau Koneksi Wi-Fi putus-putus"
                            required
                        >
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="nd-form-group">
                                <label for="category_id"><i class="bi bi-tags me-1"></i>Kategori Masalah <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ strtoupper($cat->name) }} — {{ $cat->description ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="nd-form-group">
                                <label for="priority"><i class="bi bi-exclamation-triangle me-1"></i>Tingkat Prioritas <span class="text-danger">*</span></label>
                                <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low (Rendah)</option>
                                    <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium (Sedang)</option>
                                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High (Darurat / Mendesak)</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="nd-form-group">
                        <label for="description"><i class="bi bi-file-earmark-text me-1"></i>Deskripsi Detail Kendala <span class="text-danger">*</span></label>
                        <textarea
                            name="description"
                            id="description"
                            rows="6"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Jelaskan secara kronologis kapan kendala terjadi, pesan error yang muncul, atau langkah yang sudah Anda coba..."
                            required
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-robot fs-5 text-primary"></i>
                        <span>AI Chatbot kami akan langsung menganalisis laporan Anda dan memberikan solusi FAQ instan setelah tiket ini dikirim.</span>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('tiket.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-nd-primary px-4">
                            <i class="bi bi-send-fill"></i> Kirim Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
