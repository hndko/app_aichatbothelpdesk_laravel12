@extends('layouts.app-backend')

@section('content')
<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <!-- Total Tiket -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between hover:shadow-md transition-all">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tiket</span>
            <h4 class="text-3xl font-bold text-gray-900 dark:text-white mt-1 count-up" data-target="{{ $totalTickets }}">{{ $totalTickets }}</h4>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl shadow-inner">
            <i class="bi bi-ticket-perforated-fill"></i>
        </div>
    </div>

    <!-- Open -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between hover:shadow-md transition-all">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tiket Open</span>
            <h4 class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-1 count-up" data-target="{{ $openTickets }}">{{ $openTickets }}</h4>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl shadow-inner">
            <i class="bi bi-clock-fill"></i>
        </div>
    </div>

    <!-- Progress -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between hover:shadow-md transition-all">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tiket Progress</span>
            <h4 class="text-3xl font-bold text-sky-600 dark:text-sky-400 mt-1 count-up" data-target="{{ $progressTickets }}">{{ $progressTickets }}</h4>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 flex items-center justify-center text-2xl shadow-inner">
            <i class="bi bi-arrow-repeat"></i>
        </div>
    </div>

    <!-- Closed -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between hover:shadow-md transition-all">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tiket Closed</span>
            <h4 class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1 count-up" data-target="{{ $closedTickets }}">{{ $closedTickets }}</h4>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl shadow-inner">
            <i class="bi bi-check-circle-fill"></i>
        </div>
    </div>
</div>

<!-- Tiket Terbaru Flowbite Card & Table -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <h5 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i class="bi bi-clock-history text-blue-600 dark:text-blue-400"></i> Tiket Terbaru
        </h5>
        <a href="{{ route('tiket.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 inline-flex items-center gap-1 transition-colors">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No. Tiket</th>
                    <th scope="col" class="px-6 py-3">Subject</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Prioritas</th>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($recentTickets as $ticket)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                            <a href="{{ route('tiket.show', $ticket->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                {{ $ticket->ticket_number }}
                            </a>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                            {{ \Illuminate\Support\Str::limit($ticket->subject, 40) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                {{ strtoupper($ticket->category->name ?? '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusBadge = match($ticket->status) {
                                    'open' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border-red-200',
                                    'progress' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 border-amber-200',
                                    'closed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border-emerald-200',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded border {{ $statusBadge }}">
                                {{ strtoupper($ticket->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $prioBadge = match($ticket->priority) {
                                    'high' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300',
                                    'medium' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300',
                                    default => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
                                };
                            @endphp
                            <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $prioBadge }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $ticket->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-inbox text-4xl block mb-2 opacity-40"></i>
                            <span>Belum ada tiket yang terdaftar.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
