@extends('layouts.app-backend')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50 dark:bg-blue-900/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="z-10">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span>🎫</span>
                <span>{{ $title }}</span>
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola dan pantau seluruh riwayat laporan kendala IT yang masuk ke sistem.</p>
        </div>

        @if(auth()->user()->isUser())
            <div class="z-10 shrink-0">
                <a href="{{ route('tiket.create') }}" class="text-white bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-5 py-3 text-center inline-flex items-center gap-2 shadow-lg shadow-blue-500/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
                    <span>Buat Tiket Baru</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <form action="{{ route('tiket.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-center">
            <!-- Search Box -->
            <div class="sm:col-span-2 lg:col-span-4 relative">
                <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                </div>
                <input type="text" name="search" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-2xs" placeholder="Cari No. Tiket atau Subjek Kendala..." value="{{ request('search') }}">
            </div>

            <!-- Filter Kategori -->
            <div class="sm:col-span-1 lg:col-span-3">
                <select name="category_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all shadow-2xs">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ strtoupper($cat->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="sm:col-span-1 lg:col-span-3">
                <select name="status" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all shadow-2xs">
                    <option value="">-- Semua Status --</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open (Menunggu)</option>
                    <option value="progress" {{ request('status') === 'progress' ? 'selected' : '' }}>Progress (Diproses)</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed (Selesai)</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="sm:col-span-2 lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-xl text-sm px-5 py-3 w-full transition-all shadow-sm flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                    <span>Filter</span>
                </button>
                @if(request()->hasAny(['search', 'category_id', 'status']))
                    <a href="{{ route('tiket.index') }}" class="p-3 text-sm font-medium text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 hover:text-blue-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 flex items-center justify-center transition-all shrink-0" title="Reset Filter">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 dark:bg-gray-700/80 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">No. Tiket</th>
                        @if(auth()->user()->isStaff())
                            <th scope="col" class="px-6 py-4 font-bold">Pelapor</th>
                        @endif
                        <th scope="col" class="px-6 py-4 font-bold">Subjek Kendala</th>
                        <th scope="col" class="px-6 py-4 font-bold">Kategori</th>
                        <th scope="col" class="px-6 py-4 font-bold">Prioritas</th>
                        <th scope="col" class="px-6 py-4 font-bold">Status</th>
                        @if(auth()->user()->isStaff())
                            <th scope="col" class="px-6 py-4 font-bold">Sentimen AI</th>
                        @endif
                        <th scope="col" class="px-6 py-4 font-bold">Teknisi IT</th>
                        <th scope="col" class="px-6 py-4 font-bold">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($tickets as $ticket)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-blue-50/30 dark:hover:bg-gray-700/50 transition-colors group">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                <a href="{{ route('tiket.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 group-hover:underline flex items-center gap-1">
                                    <span>{{ $ticket->ticket_number }}</span>
                                </a>
                            </td>
                            @if(auth()->user()->isStaff())
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $ticket->user->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->user->email ?? '' }}</div>
                                </td>
                            @endif
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-gray-200 max-w-xs truncate">
                                {{ $ticket->subject }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-lg dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    {{ $ticket->category_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold px-3 py-1 rounded-lg {{ $ticket->priority_badge }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-bold px-3 py-1 rounded-lg {{ $ticket->status_badge }}">
                                    {{ strtoupper($ticket->status) }}
                                </span>
                            </td>
                            @if(auth()->user()->isStaff())
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-bold px-3 py-1 rounded-lg {{ $ticket->sentiment_badge }} inline-block">
                                        {{ $ticket->sentiment_label }}
                                    </span>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ticket->assignedAdmin)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/30 px-3 py-1 rounded-full border border-blue-200 dark:border-blue-800 shadow-2xs">
                                        <div class="w-4 h-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[9px]">
                                            {{ strtoupper(substr($ticket->assignedAdmin->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $ticket->assignedAdmin->name }}</span>
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1 rounded-md border border-dashed border-gray-200 dark:border-gray-600">Menunggu antrean</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $ticket->formatted_date }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('tiket.show', $ticket->id) }}" class="py-2 px-3.5 text-xs font-bold text-blue-600 focus:outline-none bg-blue-50 rounded-xl border border-blue-200 hover:bg-blue-600 hover:text-white dark:bg-gray-700 dark:text-blue-400 dark:border-gray-600 dark:hover:bg-blue-600 dark:hover:text-white inline-flex items-center gap-1.5 transition-all shadow-2xs">
                                    <span>Detail</span>
                                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isStaff() ? 10 : 8 }}" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                    <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.586l.944 2.228a.991.991 0 0 0 .908.586h3.602a.991.991 0 0 0 .908-.586l.944-2.228a.991.991 0 0 1 .908-.586H20M4 13v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6M4 13l2-9h12l2 9"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 dark:text-gray-200">Tidak ada tiket yang ditemukan</h4>
                                <p class="text-xs text-gray-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter kategori Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
