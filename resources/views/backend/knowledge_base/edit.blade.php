@extends('layouts.app-backend')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ $title }}</h4>
                <p class="text-muted small mb-0">Perbarui konten artikel FAQ knowledge base</p>
            </div>
            <a href="{{ route('knowledge-base.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="nd-card animate-slide-up">
            <div class="nd-card-body p-4 p-md-5">
                <form action="{{ route('knowledge-base.update', $article->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="nd-form-group">
                        <label for="question"><i class="bi bi-question-circle me-1"></i>Pertanyaan (FAQ) <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control @error('question') is-invalid @enderror"
                            id="question"
                            name="question"
                            value="{{ old('question', $article->question) }}"
                            placeholder="Contoh: Bagaimana cara reset password email kantor?"
                            required
                        >
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="nd-form-group">
                        <label for="answer"><i class="bi bi-chat-right-text me-1"></i>Jawaban <span class="text-danger">*</span></label>
                        <textarea
                            name="answer"
                            id="answer"
                            rows="8"
                            class="form-control @error('answer') is-invalid @enderror"
                            placeholder="Tulis jawaban step-by-step yang jelas dan mudah diikuti oleh karyawan..."
                            required
                        >{{ old('answer', $article->answer) }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="nd-form-group">
                                <label for="category_id"><i class="bi bi-tags me-1"></i>Kategori</label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">-- Umum (Tanpa Kategori) --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ ucfirst($cat->name) }} — {{ $cat->description ?? '' }}
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
                                <label><i class="bi bi-toggle-on me-1"></i>Status Artikel</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $article->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktif (tampil sebagai referensi AI)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('knowledge-base.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-nd-primary px-4">
                            <i class="bi bi-save"></i> Perbarui Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
