@extends('layouts.app-auth')

@section('content')
<div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl border border-white/20 dark:border-gray-700 rounded-2xl shadow-2xl p-8 w-full transition-all">
    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('assets/images/logo.png') }}" alt="NexusDesk AI" class="w-16 h-16 rounded-xl shadow-md mb-3">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">NexusDesk AI</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Masuk ke akun Helpdesk Anda</p>
    </div>

    @if($errors->any())
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <i class="bi bi-exclamation-circle me-2 text-lg flex-shrink-0"></i>
            <div>
                <span class="font-medium">Gagal Masuk!</span> {{ $errors->first() }}
            </div>
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST" autocomplete="off" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                <i class="bi bi-envelope me-1 text-blue-600 dark:text-blue-400"></i> Email
            </label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="name@nexusdesk.com"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all"
                required
                autofocus
            >
        </div>

        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                <i class="bi bi-lock me-1 text-blue-600 dark:text-blue-400"></i> Password
            </label>
            <div class="relative">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pe-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all"
                    required
                >
                <button type="button" id="togglePassword" class="absolute inset-y-0 end-0 flex items-center pe-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white focus:outline-none">
                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-500 dark:text-gray-400">Ingat saya</label>
            </div>
        </div>

        <button type="submit" class="w-full text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-800 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
            <i class="bi bi-box-arrow-in-right text-lg"></i>
            <span>Masuk ke Sistem</span>
        </button>
    </form>

    <div class="text-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
        <p class="text-xs text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} NexusDesk AI — ND AI Helpdesk System
        </p>
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
