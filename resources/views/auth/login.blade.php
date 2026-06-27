@extends('layouts.app-auth')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-12 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700 w-full min-h-[560px]">
    <!-- Kolom 1 (Kiri - 5 Columns): Branding Showcase -->
    <div class="md:col-span-5 bg-linear-to-br from-blue-600 via-indigo-700 to-slate-900 text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
        <!-- Ambient Glowing Effects -->
        <div class="absolute -top-16 -left-16 w-48 h-48 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -right-16 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <a href="{{ route('portal') }}" class="inline-flex items-center gap-3 mb-6 group">
                <img src="{{ asset('assets/images/logo.png') }}" alt="MariDesk AI Logo" class="w-12 h-12 rounded-2xl shadow-lg bg-white/10 p-1 backdrop-blur-md group-hover:scale-105 transition-transform">
                <div>
                    <span class="text-2xl font-extrabold tracking-tight block">MariDesk <span class="text-cyan-300">AI</span></span>
                    <span class="text-[10px] font-bold tracking-widest text-blue-200 uppercase block">Portal IT Helpdesk</span>
                </div>
            </a>

            <h2 class="text-2xl sm:text-3xl font-bold leading-tight mb-4">
                Layanan Support IT Cerdas & Cepat ⚡
            </h2>
            <p class="text-blue-100 text-sm leading-relaxed mb-6">
                Platform terintegrasi AI Chatbot 24/7 untuk mendiagnosis kendala hardware, software, dan network secara otomatis dan akurat.
            </p>

            <!-- Feature Bullet Points -->
            <div class="space-y-3 pt-4 border-t border-white/15 text-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-cyan-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </div>
                    <span>Asisten Virtual AI 24 Jam Non-stop</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 9h2a1 1 0 1 0 0-2h-2a1 1 0 1 0 0 2Zm-4 4h8a1 1 0 1 0 0-2H7a1 1 0 1 0 0 2Zm0 4h8a1 1 0 1 0 0-2H7a1 1 0 1 0 0 2Z"/></svg>
                    </div>
                    <span>Sentimen Analisis Tiket Otomatis</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-amber-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <span>Resolusi Masalah Ekstra Cepat</span>
                </div>
            </div>
        </div>

        <div class="relative z-10 mt-8 pt-4 border-t border-white/15 flex items-center justify-between text-xs text-blue-200">
            <span>&copy; {{ date('Y') }} MariDesk AI</span>
            <a href="{{ route('portal') }}" class="hover:text-white underline transition-colors">Kembali ke Portal &rarr;</a>
        </div>
    </div>

    <!-- Kolom 2 (Kanan - 7 Columns): Form Login -->
    <div class="md:col-span-7 p-8 sm:p-12 flex flex-col justify-center relative">
        <div class="max-w-md mx-auto w-full">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang Kembali 👋</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Silakan masuk menggunakan email dan kata sandi Anda.</p>
            </div>

            @if($errors->any())
                <div class="flex items-center p-4 mb-6 text-sm text-red-800 border border-red-300 rounded-xl bg-red-50 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800 animate-pulse" role="alert">
                    <svg class="w-5 h-5 me-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>
                    <div>
                        <span class="font-bold">Gagal Masuk!</span> {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" autocomplete="off" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="flex items-center gap-1.5 mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/><path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/></svg>
                        <span>Alamat Email</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all shadow-xs"
                        required
                        autofocus
                    >
                </div>

                <div>
                    <label for="password" class="flex items-center gap-1.5 mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20"><path d="M14 7h-1.5V4.5a4.5 4.5 0 1 0-9 0V7H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-8.5-2.5a2.5 2.5 0 1 1 5 0V7h-5V4.5ZM10 13.5a2 2 0 1 1-4 0v-1a2 2 0 1 1 4 0v1Z"/></svg>
                        <span>Kata Sandi</span>
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 pe-11 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all shadow-xs"
                            required
                        >
                        <button type="button" id="togglePassword" class="absolute inset-y-0 inset-e-0 flex items-center pe-3.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white focus:outline-none">
                            <svg id="eyeIcon" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <svg id="eyeSlashIcon" class="hidden w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-600 dark:text-gray-400">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="w-full text-white bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-5 py-3 text-center dark:focus:ring-blue-800 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m12 0-4 4m4-4-4-4m5-4v12a2 2 0 0 1-2 2h-3"/></svg>
                    <span>Masuk ke Sistem</span>
                </button>
            </form>

            <!-- Demo Hint Box -->
            <div class="mt-8 p-4 bg-blue-50/70 dark:bg-gray-700/50 rounded-xl border border-blue-100 dark:border-gray-600">
                <span class="text-xs font-bold text-blue-800 dark:text-blue-300 uppercase tracking-wider block mb-1">Akun Demo Pengujian:</span>
                <div class="text-xs text-gray-600 dark:text-gray-300 space-y-1">
                    <div>👑 Admin: <code class="font-mono bg-white dark:bg-gray-800 px-1.5 py-0.5 rounded text-blue-600 dark:text-blue-400">admin@example.com</code> / <code class="font-mono">password</code></div>
                    <div>👤 Karyawan: <code class="font-mono bg-white dark:bg-gray-800 px-1.5 py-0.5 rounded text-indigo-600 dark:text-indigo-400">user@example.com</code> / <code class="font-mono">password</code></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    });
</script>
@endsection
