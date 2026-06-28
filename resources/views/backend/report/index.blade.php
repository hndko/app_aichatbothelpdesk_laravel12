@extends('layouts.app-backend')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Banner Premium -->
    <div class="bg-linear-to-r from-blue-600 via-indigo-600 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col lg:flex-row items-center justify-between gap-6 relative overflow-hidden border border-white/10">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col sm:flex-row items-center gap-5 z-10 text-center sm:text-left">
            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md text-white flex items-center justify-center text-3xl shadow-inner shrink-0 border border-white/20">
                📈
            </div>
            <div>
                <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-blue-400/20 text-blue-200 border border-blue-400/30 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        Analytics Hub Active
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $title }}</h1>
                <p class="text-blue-100 text-sm mt-1 max-w-xl">Pantau statistik penyelesaian kendala, kinerja tim Helpdesk, sentimen AI kepuasan pengguna, dan unduh berkas laporan.</p>
            </div>
        </div>

        <div class="z-10 shrink-0 flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <a href="{{ route('report.export-pdf') }}" class="w-full sm:w-auto px-5 py-3.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-sm shadow-lg shadow-rose-600/30 transition-all flex items-center justify-center gap-2 hover:scale-105 active:scale-95 shrink-0 cursor-pointer">
                <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                <span>Export PDF</span>
            </a>
            <a href="{{ route('report.export-excel') }}" class="w-full sm:w-auto px-5 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 hover:scale-105 active:scale-95 shrink-0 cursor-pointer">
                <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                <span>Export Excel</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl shrink-0 shadow-inner border border-blue-100 dark:border-blue-800">
                📋
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 block">Total Tiket Masuk</span>
                <h4 class="text-3xl font-black text-gray-900 dark:text-white mt-0.5">{{ $total }}</h4>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl shrink-0 shadow-inner border border-amber-100 dark:border-amber-800">
                ⏳
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 block">Sedang Diproses</span>
                <h4 class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-0.5">{{ $progress }}</h4>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl shrink-0 shadow-inner border border-emerald-100 dark:border-emerald-800">
                ✅
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 block">Selesai (Closed)</span>
                <h4 class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $closed }}</h4>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-sky-50 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400 flex items-center justify-center text-2xl shrink-0 shadow-inner border border-sky-100 dark:border-sky-800">
                😊
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 block">Sentimen Positif AI</span>
                <h4 class="text-3xl font-black text-sky-600 dark:text-sky-400 mt-0.5">{{ $positive }}</h4>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <form action="{{ route('report.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full grow">
                <!-- Filter Status -->
                <div>
                    <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-bold transition-all">
                        <option value="">🎯 Semua Status Tiket</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>🔴 Open (Menunggu)</option>
                        <option value="progress" {{ request('status') === 'progress' ? 'selected' : '' }}>🟡 Progress (Ditangani)</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>🟢 Closed (Selesai)</option>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-bold transition-all">
                        <option value="">📂 Semua Kategori Kendala</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ strtoupper($cat->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-2 w-full md:w-auto shrink-0">
                <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-bold rounded-xl text-sm px-6 py-3 w-full md:w-auto transition-all shadow-sm cursor-pointer flex items-center justify-center gap-2 shrink-0">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2.586a1 1 0 0 1-.293.707l-6.414 6.414a1 1 0 0 0-.293.707V17l-4 4v-6.586a1 1 0 0 0-.293-.707L3.293 7.293A1 1 0 0 1 3 6.586V4Z"/></svg>
                    <span>Filter Laporan</span>
                </button>
                @if(request()->filled('status') || request()->filled('category_id'))
                    <a href="{{ route('report.index') }}" class="p-3 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl hover:bg-gray-200 hover:text-indigo-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white transition-all flex items-center justify-center shrink-0" title="Reset Filter">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Statistik Kinerja per Helpdesk Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h5 class="font-extrabold text-gray-900 dark:text-white flex items-center gap-2.5 text-base">
                <span class="w-8 h-8 rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-300 flex items-center justify-center text-base shrink-0">🛡️</span>
                <span>Statistik Kinerja Tim Helpdesk & Service Desk</span>
            </h5>
            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-full border border-indigo-200 dark:border-indigo-800 self-start sm:self-auto">Patokan Evaluasi KPI Staf</span>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 font-extrabold">
                    <tr>
                        <th scope="col" class="px-6 py-4 min-w-[200px]">Nama Teknisi / Staf</th>
                        <th scope="col" class="px-6 py-4">Peran (*Role*)</th>
                        <th scope="col" class="px-6 py-4 text-center">Tiket Hari Ini</th>
                        <th scope="col" class="px-6 py-4 text-center">Minggu Ini</th>
                        <th scope="col" class="px-6 py-4 text-center">Bulan Ini</th>
                        <th scope="col" class="px-6 py-4 text-center">Aktif Ditangani</th>
                        <th scope="col" class="px-6 py-4 text-center">Selesai (*Closed*)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($helpdeskStats as $staff)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-indigo-50/30 dark:hover:bg-gray-700/40 transition-colors">
                            <td class="px-6 py-4.5 font-extrabold text-gray-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-linear-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-sm shrink-0">
                                        {{ strtoupper(substr($staff->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $staff->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4.5 whitespace-nowrap">
                                @if(str_contains(strtolower($staff->role_label), 'admin'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                        {{ $staff->role_label }}
                                    </span>
                                @elseif(str_contains(strtolower($staff->role_label), 'service'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        {{ $staff->role_label }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        {{ $staff->role_label }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4.5 text-center font-black text-gray-900 dark:text-white text-base">
                                {{ $staff->daily }}
                            </td>
                            <td class="px-6 py-4.5 text-center font-black text-gray-900 dark:text-white text-base">
                                {{ $staff->weekly }}
                            </td>
                            <td class="px-6 py-4.5 text-center font-black text-gray-900 dark:text-white text-base">
                                {{ $staff->monthly }}
                            </td>
                            <td class="px-6 py-4.5 text-center whitespace-nowrap">
                                <span class="px-3 py-1 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 font-extrabold text-sm border border-amber-200 dark:border-amber-800 inline-block min-w-[3rem]">
                                    {{ $staff->total_active }}
                                </span>
                            </td>
                            <td class="px-6 py-4.5 text-center whitespace-nowrap">
                                <span class="px-3 py-1 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 font-extrabold text-sm border border-emerald-200 dark:border-emerald-800 inline-block min-w-[3rem]">
                                    {{ $staff->total_closed }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <p class="text-sm font-semibold">Belum ada data staf Helpdesk atau penugasan tiket.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table Preview Laporan Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h5 class="font-extrabold text-gray-900 dark:text-white flex items-center gap-2.5 text-base">
                <span class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 flex items-center justify-center text-base shrink-0">📑</span>
                <span>Pratinjau Daftar Tiket Masuk</span>
            </h5>
            <span class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs font-extrabold px-3.5 py-1.5 rounded-full border border-gray-200 dark:border-gray-600 shadow-2xs self-start sm:self-auto">
                Total Menampilkan: {{ $tickets->total() }} Tiket
            </span>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 font-extrabold">
                    <tr>
                        <th scope="col" class="px-6 py-4">No. Tiket</th>
                        <th scope="col" class="px-6 py-4 min-w-[150px]">Pelapor</th>
                        <th scope="col" class="px-6 py-4 min-w-[200px]">Subjek Masalah</th>
                        <th scope="col" class="px-6 py-4">Kategori</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-center">Sentimen AI</th>
                        <th scope="col" class="px-6 py-4 min-w-[150px]">Teknisi Assignee</th>
                        <th scope="col" class="px-6 py-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($tickets as $ticket)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-indigo-50/30 dark:hover:bg-gray-700/40 transition-colors">
                            <td class="px-6 py-4 font-black text-indigo-600 dark:text-indigo-400 whitespace-nowrap">
                                <a href="{{ route('tiket.show', $ticket->id) }}" class="hover:underline">{{ $ticket->ticket_number }}</a>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $ticket->user->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-300">
                                {{ \Illuminate\Support\Str::limit($ticket->subject, 35) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-extrabold px-3 py-1 rounded-lg border border-gray-200 dark:border-gray-600">
                                    {{ strtoupper($ticket->category->name ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($ticket->status === 'open')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span>
                                        <span>OPEN</span>
                                    </span>
                                @elseif($ticket->status === 'progress')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>PROGRESS</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        <span>CLOSED</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($ticket->sentiment === 'positive')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        <span>😊 Puas</span>
                                    </span>
                                @elseif($ticket->sentiment === 'negative')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                        <span>😠 Urgent / Kecewa</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-sky-50 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-sky-800">
                                        <span>😐 Netral</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-semibold whitespace-nowrap">
                                {{ $ticket->assignedAdmin->name ?? 'Belum Ditugaskan' }}
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $ticket->created_at->translatedFormat('d M Y, H:i') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z"/></svg>
                                </div>
                                <h5 class="text-base font-bold text-gray-800 dark:text-gray-200 mb-1">Data Laporan Kosong</h5>
                                <p class="text-xs max-w-sm mx-auto">Belum ada tiket yang masuk atau sesuai dengan kriteria filter yang Anda pilih.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tickets->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
