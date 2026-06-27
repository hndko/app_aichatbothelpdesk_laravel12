<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="MariDesk AI — Sistem Helpdesk IT Cerdas">
    <title>{{ $title ?? 'Dashboard' }} — MariDesk AI</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Flowbite via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 dark:bg-slate-900 text-gray-800 dark:text-gray-200 min-h-screen">

    <!-- Top Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-gray-200 dark:bg-gray-800/95 dark:border-gray-700 shadow-xs transition-all">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end gap-3">
                    <!-- Hamburger Toggle Button (Works on Desktop & Mobile) -->
                    <button id="sidebarToggleBtn" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-colors" aria-controls="logo-sidebar" aria-label="Toggle sidebar">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18"/></svg>
                    </button>

                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/logo.png') }}" class="h-9 w-9 rounded-xl shadow-sm" alt="MariDesk AI Logo" />
                        <div class="flex items-center gap-2">
                            <span class="self-center text-xl font-extrabold sm:text-2xl whitespace-nowrap tracking-tight bg-linear-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-300">MariDesk AI</span>
                            <span class="hidden sm:inline-block text-[11px] font-bold tracking-wider uppercase px-2 py-0.5 bg-blue-100 text-blue-800 rounded-md dark:bg-blue-900/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">Platform</span>
                        </div>
                    </a>

                    <div class="hidden lg:flex items-center border-l border-gray-200 dark:border-gray-700 pl-4 ms-2">
                        <span class="text-base font-semibold text-gray-700 dark:text-gray-200">{{ $title ?? 'Dashboard' }}</span>
                    </div>
                </div>

                <!-- Right Side Profile Menu -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('portal') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 bg-blue-50 hover:bg-blue-100 dark:bg-gray-700 dark:hover:bg-gray-600 px-3 py-2 rounded-xl transition-all">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778"/></svg>
                        <span>Lihat Portal</span>
                    </a>

                    <div class="relative">
                        <button type="button" class="flex items-center gap-2.5 text-sm bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 rounded-full focus:ring-4 focus:ring-blue-100 dark:focus:ring-gray-600 px-3 py-1.5 transition-all shadow-2xs" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <div class="w-8 h-8 rounded-full bg-linear-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <div class="text-xs font-bold text-gray-900 dark:text-white leading-tight">{{ auth()->user()->name }}</div>
                                <div class="text-[10px] font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">{{ auth()->user()->role }}</div>
                            </div>
                            <svg class="w-3 h-3 text-gray-500 ms-1 hidden sm:block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                        </button>

                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-2xl shadow-xl dark:bg-gray-800 dark:divide-gray-700 border border-gray-100 dark:border-gray-700 w-56 overflow-hidden" id="dropdown-user">
                            <div class="px-4 py-3.5 bg-blue-50/50 dark:bg-gray-700/50" role="none">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate" role="none">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs font-medium text-gray-500 truncate dark:text-gray-400 mt-0.5" role="none">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                            <ul class="py-2" role="none">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                        <span>Profil Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-6ZM4 16a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-6Z" clip-rule="evenodd"/></svg>
                                        <span>Dasbor Utama</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="border-t border-gray-100 dark:border-gray-700 py-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-gray-700 flex items-center gap-2.5 transition-colors font-medium" role="menuitem">
                                        <svg class="w-4 h-4 shrink-0 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                                        <span>Keluar Sistem</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Left Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-all duration-300 -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 flex flex-col justify-between shadow-sm" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto">
            <ul class="space-y-1.5 font-medium">
                <li>
                    <div class="px-3 py-2 text-[11px] font-bold text-gray-400 uppercase tracking-widest dark:text-gray-500">
                        Menu Utama
                    </div>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-gray-900 rounded-xl dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white font-bold shadow-md shadow-blue-500/20' : '' }}">
                        <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-6ZM4 16a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H4Zm10 0a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-6Z" clip-rule="evenodd"/></svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tiket.index') }}" class="flex items-center p-3 text-gray-900 rounded-xl dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('tiket.*') ? 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white font-bold shadow-md shadow-blue-500/20' : '' }}">
                        <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('tiket.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 .586 1.414l2.828 2.828A2 2 0 0 0 6.828 20H18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm2 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Z" clip-rule="evenodd"/></svg>
                        <span class="ms-3">Tiket Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="flex items-center p-3 text-gray-900 rounded-xl dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white font-bold shadow-md shadow-blue-500/20' : '' }}">
                        <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        <span class="ms-3">Profil Saya</span>
                    </a>
                </li>

                @if(auth()->user()->role === 'admin')
                    <li class="pt-5">
                        <div class="px-3 py-2 text-[11px] font-bold text-gray-400 uppercase tracking-widest dark:text-gray-500">
                            Kelola Admin
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('knowledge-base.index') }}" class="flex items-center p-3 text-gray-900 rounded-xl dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('knowledge-base.*') ? 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white font-bold shadow-md shadow-blue-500/20' : '' }}">
                            <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('knowledge-base.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-1v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2H6Zm6 2v12H7a1 1 0 0 0-1 1v1h11V4h-5Z" clip-rule="evenodd"/></svg>
                            <span class="ms-3">Knowledge Base</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center p-3 text-gray-900 rounded-xl dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white font-bold shadow-md shadow-blue-500/20' : '' }}">
                            <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('users.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.764A5.998 5.998 0 0 1 19.5 18Z" clip-rule="evenodd"/></svg>
                            <span class="ms-3">Kelola User</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('report.index') }}" class="flex items-center p-3 text-gray-900 rounded-xl dark:text-white hover:bg-blue-50 dark:hover:bg-gray-700 group transition-all {{ request()->routeIs('report.*') ? 'bg-blue-600 text-white dark:bg-blue-600 dark:text-white font-bold shadow-md shadow-blue-500/20' : '' }}">
                            <svg class="w-5 h-5 shrink-0 transition duration-75 {{ request()->routeIs('report.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H11Zm.5 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-5a1 1 0 0 0-1-1Zm-4 2a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1Zm8-4a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0v-7a1 1 0 0 0-1-1Z" clip-rule="evenodd"/></svg>
                            <span class="ms-3">Laporan</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        
        <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-800/80">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center p-3 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 font-bold transition-all gap-2.5 shadow-xs">
                    <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div id="mainContent" class="p-4 sm:ml-64 pt-20 transition-all duration-300">
        <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 min-h-[calc(100vh-6rem)] shadow-md border border-gray-100 dark:border-gray-700 transition-all">
            @yield('content')
        </div>
    </div>

    <!-- Flowbite Toast Notifications -->
    <div class="fixed top-20 right-5 z-50 flex flex-col gap-3 max-w-sm w-full">
        @if(session('success'))
            <div id="toast-success" class="flex items-center w-full p-4 text-gray-500 bg-white rounded-2xl shadow-xl border border-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all animate-bounce" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-xl dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-bold text-gray-800 dark:text-gray-200">{{ session('success') }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="toast-error" class="flex items-center w-full p-4 text-gray-500 bg-white rounded-2xl shadow-xl border border-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all animate-bounce" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-xl dark:bg-red-800 dark:text-red-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ms-3 text-sm font-bold text-gray-800 dark:text-gray-200">{{ session('error') }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-error" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Toggle Sidebar Script for Desktop & Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('logo-sidebar');
            const mainContent = document.getElementById('mainContent');

            if (toggleBtn && sidebar && mainContent) {
                toggleBtn.addEventListener('click', function () {
                    // Check if sidebar is currently visible or collapsed on desktop
                    const isCollapsedDesktop = sidebar.classList.contains('sm:-translate-x-full');
                    const isHiddenMobile = sidebar.classList.contains('-translate-x-full');

                    if (window.innerWidth >= 640) {
                        // Desktop toggle
                        if (isCollapsedDesktop) {
                            sidebar.classList.remove('sm:-translate-x-full');
                            sidebar.classList.add('sm:translate-x-0');
                            mainContent.classList.add('sm:ml-64');
                            mainContent.classList.remove('sm:ml-0');
                        } else {
                            sidebar.classList.remove('sm:translate-x-0');
                            sidebar.classList.add('sm:-translate-x-full');
                            mainContent.classList.remove('sm:ml-64');
                            mainContent.classList.add('sm:ml-0');
                        }
                    } else {
                        // Mobile toggle
                        if (isHiddenMobile) {
                            sidebar.classList.remove('-translate-x-full');
                            sidebar.classList.add('translate-x-0');
                        } else {
                            sidebar.classList.remove('translate-x-0');
                            sidebar.classList.add('-translate-x-full');
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
