@extends('layouts.app-auth')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <img src="{{ asset('assets/images/logo.png') }}" alt="NexusDesk AI">
        <h1>NexusDesk AI</h1>
        <p>Masuk ke akun Helpdesk Anda</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show py-2 px-3" role="alert" style="font-size: 0.8125rem; border-radius: var(--border-radius-sm);">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.625rem; padding: 0.75rem;"></button>
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST" autocomplete="off">
        @csrf

        <div class="nd-form-group">
            <label for="email">
                <i class="bi bi-envelope me-1"></i>Email
            </label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email Anda"
                required
                autofocus
            >
        </div>

        <div class="nd-form-group">
            <label for="password">
                <i class="bi bi-lock me-1"></i>Password
            </label>
            <div class="input-group">
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-color: #dee2e6;">
                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </button>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember" style="font-size: 0.8125rem; color: var(--gray);">
                    Ingat saya
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-nd-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right"></i>
            Masuk
        </button>
    </form>

    <div class="text-center mt-4">
        <small style="color: var(--gray); font-size: 0.75rem;">
            &copy; {{ date('Y') }} NexusDesk AI — ND AI Helpdesk System
        </small>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endsection
