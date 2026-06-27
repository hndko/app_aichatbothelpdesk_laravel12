@extends('layouts.app-backend')

@section('content')
<!-- Header & Action Buttons Flowbite -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h4 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i class="bi bi-file-earmark-bar-graph text-blue-600 dark:text-blue-400"></i> Rekapitulasi Laporan Helpdesk
        </h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">Pantau statistik penyelesaian kendala, kepuasan sentimen AI, dan unduh berkas laporan.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('report.export-pdf') }}" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-xl text-sm px-4 py-2.5 inline-flex items-center gap-2 shadow-md shadow-red-500/20 transition-all">
            <i class="bi bi-file-earmark-pdf-fill text-lg"></i> Export PDF
        </a>
        <a href="{{ route('report.export-excel') }}" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-xl text-sm px-4 py-2.5 inline-flex items-center gap-2 shadow-md shadow-emerald-500/20 transition-all">
            <i class="bi bi-file-earmark-excel-fill text-lg"></i> Export Excel
        </a>
    </div>
</div>

<!-- Statistics Cards Flowbite Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
            <i class="bi bi-ticket-detailed-fill"></i>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tiket</span>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-0.5">{{ $total }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Sedang Diproses</span>
            <h4 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-0.5">{{ $progress }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Selesai (Closed)</span>
            <h4 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $closed }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
            <i class="bi bi-emoji-smile-fill"></i>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Sentimen Positif AI</span>
            <h4 class="text-2xl font-bold text-sky-600 dark:text-sky-400 mt-0.5">{{ $positive }}</h4>
        </div>
    </div>
</div>

<!-- Table Preview Flowbite -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i class="bi bi-table text-blue-600 dark:text-blue-400"></i> Pratinjau Data Laporan
        </h5>
        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
            Total Menampilkan: {{ $tickets->total() }}
        </span>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3.5">No. Tiket</th>
                    <th scope="col" class="px-6 py-3.5">Pelapor</th>
                    <th scope="col" class="px-6 py-3.5">Subjek Masalah</th>
                    <th scope="col" class="px-6 py-3.5">Kategori</th>
                    <th scope="col" class="px-6 py-3.5">Status</th>
                    <th scope="col" class="px-6 py-3.5">Sentimen AI</th>
                    <th scope="col" class="px-6 py-3.5">Teknisi Assignee</th>
                    <th scope="col" class="px-6 py-3.5">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($tickets as $ticket)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">{{ $ticket->ticket_number }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">{{ $ticket->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($ticket->subject, 30) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                {{ strtoupper($ticket->category->name ?? '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusBadge = match($ticket->status) {
                                    'open' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border-red-200',
                                    'progress' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 border-amber-200',
                                    'closed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border-emerald-200',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded border {{ $statusBadge }}">{{ strtoupper($ticket->status) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $sBadge = match($ticket->sentiment) {
                                    'positive' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border-emerald-200',
                                    'negative' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 border-rose-200',
                                    default    => 'bg-sky-100 text-sky-800 dark:bg-sky-900/40 dark:text-sky-300 border-sky-200',
                                };
                                $sIcon = match($ticket->sentiment) {
                                    'positive' => '😊 Puas',
                                    'negative' => '😠 Urgent',
                                    default    => '😐 Netral',
                                };
                            @endphp
                            <span class="text-xs font-medium px-2.5 py-1 rounded border {{ $sBadge }}">{{ $sIcon }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ $ticket->assignedAdmin->name ?? 'Belum di-assign' }}</td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $ticket->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-inbox text-4xl block mb-2 opacity-40"></i>
                            <p class="text-sm">Tidak ada data tiket untuk laporan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection
