@extends('layouts.app-backend')

@section('content')
<div class="space-y-6">
    <!-- Header & Filter Bar Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Dasbor & Analisis Layanan IT</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau performa penanganan kendala teknis dan kepuasan pengguna secara real-time.</p>
        </div>

        <!-- Date Range Filter Buttons & Custom Form -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-wrap">
            <div class="inline-flex rounded-xl p-1 bg-gray-100 dark:bg-gray-700/80 border border-gray-200 dark:border-gray-600 gap-1 overflow-x-auto">
                <a href="{{ route('dashboard', ['range' => 'all']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ $selectedRange === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' }}">
                    Semua Waktu
                </a>
                <a href="{{ route('dashboard', ['range' => 'today']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ $selectedRange === 'today' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' }}">
                    Hari Ini
                </a>
                <a href="{{ route('dashboard', ['range' => '7days']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ $selectedRange === '7days' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' }}">
                    7 Hari Terakhir
                </a>
                <a href="{{ route('dashboard', ['range' => '30days']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ $selectedRange === '30days' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' }}">
                    30 Hari Terakhir
                </a>
                <a href="{{ route('dashboard', ['range' => 'month']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ $selectedRange === 'month' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' }}">
                    Bulan Ini
                </a>
            </div>

            <!-- Custom Date Form -->
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700/50 p-1.5 rounded-xl border border-gray-200 dark:border-gray-600">
                <input type="hidden" name="range" value="custom">
                <input type="date" name="start_date" value="{{ $startDate }}" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1.5 shadow-2xs" required>
                <span class="text-xs font-bold text-gray-400">-</span>
                <input type="date" name="end_date" value="{{ $endDate }}" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1.5 shadow-2xs" required>
                <button type="submit" class="bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1 shadow-sm transition-transform active:scale-95 shrink-0">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                    <span>Filter</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 5 KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Card 1: Total Tiket -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between relative overflow-hidden group hover:border-blue-500/50 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Tiket</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 .586 1.414l2.828 2.828A2 2 0 0 0 6.828 20H18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm2 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Z" clip-rule="evenodd"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($totalTickets) }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Keseluruhan laporan masuk</p>
            </div>
        </div>

        <!-- Card 2: Menunggu (Open) -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between relative overflow-hidden group hover:border-red-500/50 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Menunggu (Open)</span>
                <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 animate-pulse" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-red-600 dark:text-red-400">{{ number_format($openTickets) }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Belum ditangani teknisi</p>
            </div>
        </div>

        <!-- Card 3: Sedang Diproses -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between relative overflow-hidden group hover:border-amber-500/50 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Sedang Diproses</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 9h2V6q0-.414-.293-.707A1 1 0 0 0 12 5q-.414 0-.707.293A1 1 0 0 0 11 6v3Zm-4 5H4q-.414 0-.707-.293A1 1 0 0 1 3 13q0-.414.293-.707A1 1 0 0 1 4 12h3v2Zm13 0h-3v-2h3q.414 0 .707.293A1 1 0 0 1 21 13q0 .414-.293.707A1 1 0 0 1 20 14Zm-9 7v-3h2v3q0 .414-.293.707A1 1 0 0 1 12 22q-.414 0-.707-.293A1 1 0 0 1 11 21Z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-amber-600 dark:text-amber-400">{{ number_format($progressTickets) }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Dalam pengerjaan tim</p>
            </div>
        </div>

        <!-- Card 4: Selesai Ditangani -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between relative overflow-hidden group hover:border-emerald-500/50 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Selesai (Closed)</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($closedTickets) }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kendala terselesaikan</p>
            </div>
        </div>

        <!-- Card 5: Tingkat Penyelesaian (SLA) -->
        <div class="bg-linear-to-tr from-indigo-600 to-purple-600 p-5 rounded-2xl shadow-md text-white flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-indigo-100 uppercase tracking-wider">Penyelesaian (SLA)</span>
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline justify-between">
                    <h3 class="text-3xl font-black">{{ $completionRate }}%</h3>
                    <span class="text-[11px] font-semibold text-indigo-100">Success Rate</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2 mt-2 overflow-hidden">
                    <div class="bg-white h-2 rounded-full transition-all duration-1000" style="width: {{ $completionRate }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Breakdown Grid (3 Panels) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Panel 1: Distribusi Kategori Kendala -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span>📊 Kategori Kendala</span>
                    </h3>
                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Distribusi Tiket</span>
                </div>
                <div class="space-y-4">
                    @foreach($categoryAnalytics as $cat)
                        <div>
                            <div class="flex justify-between text-sm font-semibold mb-1.5">
                                <span class="text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                    <span>{{ $cat['icon'] }}</span>
                                    <span>{{ $cat['name'] }}</span>
                                </span>
                                <span class="text-gray-900 dark:text-white">{{ $cat['count'] }} tiket <span class="text-xs font-normal text-gray-400">({{ $cat['percent'] }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                <div class="{{ $cat['color'] }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $cat['percent'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-6 pt-3 border-t border-gray-100 dark:border-gray-700">
                Pengelompokan otomatis berdasarkan saat pelapor membuat tiket.
            </p>
        </div>

        <!-- Panel 2: Analisis Prioritas Tiket -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span>⚡ Tingkat Urgensi</span>
                    </h3>
                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Prioritas Penanganan</span>
                </div>
                <div class="space-y-4">
                    @foreach($priorityAnalytics as $prio)
                        <div>
                            <div class="flex justify-between items-center text-sm font-semibold mb-1.5">
                                <span class="px-2.5 py-0.5 rounded text-xs font-bold {{ $prio['badge'] }}">
                                    {{ $prio['label'] }}
                                </span>
                                <span class="text-gray-900 dark:text-white">{{ $prio['count'] }} <span class="text-xs font-normal text-gray-400">({{ $prio['percent'] }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                <div class="{{ $prio['color'] }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $prio['percent'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-6 pt-3 border-t border-gray-100 dark:border-gray-700">
                Tiket Urgent & High wajib diprioritaskan oleh admin helpdesk.
            </p>
        </div>

        <!-- Panel 3: Analisis Sentimen AI (*Standout Feature*) -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-50 dark:bg-indigo-900/10 rounded-full blur-2xl pointer-events-none"></div>
            <div>
                <div class="flex items-center justify-between mb-4 z-10 relative">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span>🤖 Sentimen AI</span>
                    </h3>
                    <span class="text-[11px] font-bold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 px-2 py-0.5 rounded-full">AI Powered</span>
                </div>
                <div class="space-y-4 z-10 relative">
                    @foreach($sentimentAnalytics as $sent)
                        <div>
                            <div class="flex justify-between text-sm font-semibold mb-1.5">
                                <span class="text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                    <span class="text-base">{{ $sent['emoji'] }}</span>
                                    <span>{{ $sent['label'] }}</span>
                                </span>
                                <span class="font-bold {{ $sent['text'] }}">{{ $sent['count'] }} <span class="text-xs font-normal text-gray-400">({{ $sent['percent'] }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                <div class="{{ $sent['color'] }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $sent['percent'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-6 pt-3 border-t border-gray-100 dark:border-gray-700 z-10 relative">
                Deteksi otomatis emosi pelapor berdasarkan analisis bahasa natural.
            </p>
        </div>
    </div>

    @if(!auth()->user()->isUser())
    <!-- Statistik Kinerja per Helpdesk -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50 flex items-center justify-between">
            <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span>🛡️</span>
                <span>Statistik Kinerja Tim Helpdesk & Service Desk</span>
            </h5>
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Patokan Evaluasi Penanganan Tiket</span>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Nama Teknisi / Staf</th>
                        <th scope="col" class="px-6 py-3.5">Peran (Role)</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Tiket Hari Ini</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Minggu Ini</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Bulan Ini</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Aktif (Open/Progress)</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Selesai (Closed)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($helpdeskStats as $staff)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 flex items-center justify-center font-black text-xs">
                                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                                </div>
                                <span>{{ $staff->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-200 dark:border-blue-800">
                                    {{ $staff->role_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                {{ $staff->daily }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                {{ $staff->weekly }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                {{ $staff->monthly }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-amber-600 dark:text-amber-400">
                                {{ $staff->total_active }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-emerald-600 dark:text-emerald-400">
                                {{ $staff->total_closed }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada data staf Helpdesk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Tabel Tiket Terbaru Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Tiket Terbaru</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pantau laporan kendala terbaru yang masuk ke dalam platform.</p>
            </div>
            <a href="{{ route('tiket.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 flex items-center gap-1 bg-blue-50 dark:bg-gray-700 px-3.5 py-2 rounded-xl transition-all">
                <span>Lihat Semua Tiket</span>
                <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
            </a>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/75 dark:bg-gray-700/75 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">No. Tiket</th>
                        <th scope="col" class="px-6 py-3.5">Subject</th>
                        <th scope="col" class="px-6 py-3.5">Kategori</th>
                        <th scope="col" class="px-6 py-3.5">Status</th>
                        <th scope="col" class="px-6 py-3.5">Prioritas</th>
                        <th scope="col" class="px-6 py-3.5">Tanggal Laporan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentTickets as $ticket)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-blue-50/30 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                <a href="{{ route('tiket.show', $ticket->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200 max-w-xs truncate">
                                {{ $ticket->subject }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-1 rounded-lg dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    {{ $ticket->category_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-lg {{ $ticket->status_badge }}">
                                    {{ strtoupper($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-lg {{ $ticket->priority_badge }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $ticket->formatted_date }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-30 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.586l.944 2.228a.991.991 0 0 0 .908.586h3.602a.991.991 0 0 0 .908-.586l.944-2.228a.991.991 0 0 1 .908-.586H20M4 13v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6M4 13l2-9h12l2 9"/></svg>
                                <span class="block font-medium">Belum ada data tiket pada rentang waktu ini.</span>
                                <span class="text-xs text-gray-400 mt-1 block">Silakan ubah filter tanggal atau buat laporan tiket baru.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
