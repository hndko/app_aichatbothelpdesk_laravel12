@extends('layouts.app-backend')

@section('content')
<!-- Header & Action Buttons Flowbite -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h4 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-7 h-7 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H11Zm.5 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-5a1 1 0 0 0-1-1Zm-4 2a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1Zm8-4a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0v-7a1 1 0 0 0-1-1Z" clip-rule="evenodd"/></svg>
            <span>Rekapitulasi Laporan Helpdesk</span>
        </h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">Pantau statistik penyelesaian kendala, kepuasan sentimen AI, dan unduh berkas laporan.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('report.export-pdf') }}" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-xl text-sm px-4 py-2.5 inline-flex items-center gap-2 shadow-md shadow-red-500/20 transition-all">
            <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
            <span>Export PDF</span>
        </a>
        <a href="{{ route('report.export-excel') }}" class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-xl text-sm px-4 py-2.5 inline-flex items-center gap-2 shadow-md shadow-emerald-500/20 transition-all">
            <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
            <span>Export Excel</span>
        </a>
    </div>
</div>

<!-- Statistics Cards Flowbite Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl shrink-0 shadow-inner">
            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 .586 1.414l2.828 2.828A2 2 0 0 0 6.828 20H18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm2 3a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H7a1 1 0 0 1-1-1Z" clip-rule="evenodd"/></svg>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tiket</span>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-0.5">{{ $total }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl shrink-0 shadow-inner">
            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/></svg>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Sedang Diproses</span>
            <h4 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-0.5">{{ $progress }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl shrink-0 shadow-inner">
            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/></svg>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Selesai (Closed)</span>
            <h4 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $closed }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:shadow-md transition-all">
        <div class="w-14 h-14 rounded-2xl bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 flex items-center justify-center text-2xl shrink-0 shadow-inner">
            <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2Zm3.707 7.707a1 1 0 0 0-1.414-1.414 2 2 0 0 1-2.586 0 1 1 0 0 0-1.414 1.414 4 4 0 0 0 5.414 0Zm-5.207 4.586a1 1 0 0 0-1.414 1.414 4 4 0 0 0 5.828 0 1 1 0 0 0-1.414-1.414 2 2 0 0 1-2.999 0Z" clip-rule="evenodd"/></svg>
        </div>
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Sentimen Positif AI</span>
            <h4 class="text-2xl font-bold text-sky-600 dark:text-sky-400 mt-0.5">{{ $positive }}</h4>
        </div>
    </div>
</div>

<!-- Statistik Kinerja per Helpdesk -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50 flex items-center justify-between">
        <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span>🛡️</span>
            <span>Statistik Kinerja Tim Helpdesk & Service Desk</span>
        </h5>
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Patokan Evaluasi Penanganan Tiket</span>
    </div>
    <div class="relative overflow-x-auto">
        <table id="table-stats" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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

<!-- Table Preview Flowbite -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2Z"/></svg>
            <span>Pratinjau Data Laporan</span>
        </h5>
        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
            Total Menampilkan: {{ $tickets->total() }}
        </span>
    </div>

    <div class="relative overflow-x-auto">
        <table id="table-report" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $ticket->created_at->translatedFormat('d F Y, H:i:s') . ' WIB' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 opacity-40 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.586l.944 2.228a.991.991 0 0 0 .908.586h3.602a.991.991 0 0 0 .908-.586l.944-2.228a.991.991 0 0 1 .908-.586H20M4 13v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6M4 13l2-9h12l2 9"/></svg>
                            <p class="text-sm">Tidak ada data tiket untuk laporan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.DataTable !== 'undefined') {
        if (document.getElementById('table-stats')) {
            new window.DataTable('#table-stats', {
                searchable: true,
                sortable: true,
                perPage: 5,
                perPageSelect: [5, 10, 25],
                labels: {
                    placeholder: "Cari nama staf...",
                    perPage: "data per halaman",
                    noRows: "Tidak ada data staf",
                    info: "Menampilkan {start} - {end} dari {rows} data"
                }
            });
        }
        if (document.getElementById('table-report')) {
            new window.DataTable('#table-report', {
                searchable: true,
                sortable: true,
                perPage: 10,
                perPageSelect: [10, 25, 50, 100],
                labels: {
                    placeholder: "Cari laporan tiket...",
                    perPage: "data per halaman",
                    noRows: "Tidak ada data tiket untuk laporan",
                    info: "Menampilkan {start} - {end} dari {rows} data"
                }
            });
        }
    }
});
</script>
@endpush
@endsection
