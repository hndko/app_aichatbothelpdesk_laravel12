<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="NexusDesk AI — Sistem Helpdesk IT Cerdas">
    <title>{{ $title ?? 'Dashboard' }} — NexusDesk AI</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Flowbite via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <!-- Top Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18"/></svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24 items-center gap-3">
                        <img src="{{ asset('assets/images/logo.png') }}" class="h-8 me-1" alt="NexusDesk AI Logo" />
                        <div>
                            <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap bg-linear-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">NexusDesk AI</span>
                            <span class="hidden md:inline-block ms-2 text-xs font-semibold px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">Helpdesk</span>
                        </div>
                    </a>
                    <div class="hidden lg:block border-l border-gray-200 dark:border-gray-700 pl-4 ms-4">
                        <h1 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $title ?? 'Dashboard' }}</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button" class="flex items-center gap-2 text-sm bg-gray-100 dark:bg-gray-700 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 px-3 py-1.5 transition-all" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-inner">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden sm:block text-left">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white leading-tight">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-blue-600 dark:text-blue-400 capitalize">{{ auth()->user()->role }}</div>
                                </div>
                                <svg class="w-3 h-3 text-gray-500 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 border border-gray-100 dark:border-gray-600" id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white" role="none">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-500 truncate dark:text-gray-300" role="none">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600 dark:hover:text-white flex items-center gap-2" role="menuitem">
                                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Left Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700 flex flex-col justify-between shadow-sm" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-1 font-medium">
                <li>
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-gray-500">
                        Menu Utama
                    </div>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 font-semibold shadow-xs' : '' }}">
                        <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-6ZM4 16a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-6Z" clip-rule="evenodd"/></svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tiket.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('tiket.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 font-semibold shadow-xs' : '' }}">
                        <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('tiket.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 .586 1.414l2.828 2.828A2 2 0 0 0 6.828 20H18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm2 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Z" clip-rule="evenodd"/></svg>
                        <span class="ms-3">Tiket Saya</span>
                    </a>
                </li>

                @if(auth()->user()->role === 'admin')
                    <li class="pt-4">
                        <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-gray-500">
                            Kelola Admin
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('knowledge-base.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('knowledge-base.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 font-semibold shadow-xs' : '' }}">
                            <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('knowledge-base.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-1v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2H6Zm6 2v12H7a1 1 0 0 0-1 1v1h11V4h-5Z" clip-rule="evenodd"/></svg>
                            <span class="ms-3">Knowledge Base</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 font-semibold shadow-xs' : '' }}">
                            <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('users.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.764A5.998 5.998 0 0 1 19.5 18Z" clip-rule="evenodd"/></svg>
                            <span class="ms-3">Kelola User</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('report.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('report.*') ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 font-semibold shadow-xs' : '' }}">
                            <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('report.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H11Zm.5 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-5a1 1 0 0 0-1-1Zm-4 2a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1Zm8-4a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0v-7a1 1 0 0 0-1-1Z" clip-rule="evenodd"/></svg>
                            <span class="ms-3">Laporan</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        
        <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center p-2.5 text-red-600 rounded-lg hover:bg-red-50 dark:hover:bg-gray-700 dark:text-red-400 font-medium transition-all gap-3">
                    <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="p-4 sm:ml-64 pt-20 min-h-screen">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-xl dark:border-gray-700 bg-white dark:bg-gray-800 min-h-[calc(100vh-6rem)] shadow-sm">
            @yield('content')
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flash Messages -->
    @if(session('success'))
        <input type="hidden" id="flash-success" value="{{ session('success') }}">
    @endif
    @if(session('error'))
        <input type="hidden" id="flash-error" value="{{ session('error') }}">
    @endif
    @if(session('warning'))
        <input type="hidden" id="flash-warning" value="{{ session('warning') }}">
    @endif

    <!-- Custom Alerts JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
