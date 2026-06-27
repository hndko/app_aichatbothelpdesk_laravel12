<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal IT Helpdesk' }} — MariDesk AI</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Flowbite via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col justify-between">

    <!-- Header Navigation Flowbite -->
    <header class="bg-white/85 backdrop-blur-md dark:bg-gray-900/85 sticky top-0 z-50 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('portal') }}" class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-9 w-auto rounded-lg shadow-sm" alt="MariDesk AI Logo">
                    <div>
                        <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">MariDesk <span class="text-blue-600 dark:text-blue-400">AI</span></span>
                        <span class="block text-[10px] font-semibold text-gray-500 uppercase tracking-widest leading-none">Portal IT Helpdesk</span>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center gap-2 transition-all shadow-sm">
                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-6ZM4 16a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-6Z" clip-rule="evenodd"/></svg> Ke Dasbor Helpdesk
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center gap-2 transition-all shadow-sm">
                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m12 0-4 4m4-4-4-4m5-4v12a2 2 0 0 1-2 2h-3"/></svg> Login Helpdesk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Footer Flowbite -->
    <footer class="bg-gray-900 text-gray-400 border-t border-gray-800 mt-20 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-between mb-8">
                <div class="max-w-md">
                    <div class="flex items-center gap-2 mb-3">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-8 rounded-md">
                        <span class="text-lg font-bold text-white">MariDesk AI</span>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400">Solusi sistem IT Helpdesk cerdas berbasis Artificial Intelligence. Membantu karyawan menemukan jawaban teknis seketika dengan akurasi tinggi dari Knowledge Base perusahaan.</p>
                </div>
                <div class="md:text-right flex flex-col md:items-end justify-center">
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-2">Butuh Bantuan Langsung?</h3>
                    <p class="text-sm text-gray-400 mb-3">Jika kendala tidak ditemukan di FAQ ini, silakan login untuk membuat tiket baru.</p>
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium text-sm inline-flex items-center gap-1 transition-colors">
                        <span>Submit Tiket Kendala</span>
                        <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500 gap-4">
                <span>&copy; {{ date('Y') }} MariDesk AI Helpdesk. All rights reserved.</span>
                <span>🥇 Project #1 — Advanced Agentic Coding Portofolio</span>
            </div>
        </div>
    </footer>

    <!-- Flowbite Toast Notifications -->
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full">
        @if(session('success'))
            <div id="toast-success" class="flex items-center w-full p-4 text-gray-500 bg-white rounded-xl shadow-lg border border-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-medium text-gray-800 dark:text-gray-200">{{ session('success') }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="toast-error" class="flex items-center w-full p-4 text-gray-500 bg-white rounded-xl shadow-lg border border-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ms-3 text-sm font-medium text-gray-800 dark:text-gray-200">{{ session('error') }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-error" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Global JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
