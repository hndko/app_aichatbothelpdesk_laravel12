@extends('layouts.app-backend')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan pantau seluruh tiket kendala sistem</p>
    </div>

    @if(auth()->user()->isUser())
        <a href="{{ route('tiket.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center gap-2 shadow-md shadow-blue-500/20 transition-all">
            <i class="bi bi-plus-lg text-lg"></i> Buat Tiket Baru
        </a>
    @endif
</div>

<!-- Filter & Search Card Flowbite -->
<div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
    <form action="{{ route('tiket.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
        <div class="md:col-span-4 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-400">
                <i class="bi bi-search"></i>
            </div>
            <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all" placeholder="Cari No. Tiket atau Subjek..." value="{{ request('search') }}">
        </div>

        <div class="md:col-span-3">
            <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ ucfirst($cat->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-3">
            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                <option value="">-- Semua Status --</option>
                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="progress" {{ request('status') === 'progress' ? 'selected' : '' }}>Progress</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="md:col-span-2 flex items-center gap-2">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 w-full transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search', 'category_id', 'status']))
                <a href="{{ route('tiket.index') }}" class="py-2.5 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 flex items-center justify-center" title="Reset Filter">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Flowbite -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3.5">No. Tiket</th>
                    @if(auth()->user()->isAdmin())
                        <th scope="col" class="px-6 py-3.5">Pelapor</th>
                    @endif
                    <th scope="col" class="px-6 py-3.5">Subjek</th>
                    <th scope="col" class="px-6 py-3.5">Kategori</th>
                    <th scope="col" class="px-6 py-3.5">Prioritas</th>
                    <th scope="col" class="px-6 py-3.5">Status</th>
                    @if(auth()->user()->isAdmin())
                        <th scope="col" class="px-6 py-3.5">Sentimen AI</th>
                    @endif
                    <th scope="col" class="px-6 py-3.5">Teknisi</th>
                    <th scope="col" class="px-6 py-3.5">Tanggal</th>
                    <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($tickets as $ticket)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                            <a href="{{ route('tiket.show', $ticket->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                {{ $ticket->ticket_number }}
                            </a>
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900 dark:text-white">{{ $ticket->user->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->user->email ?? '' }}</div>
                            </td>
                        @endif
                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                            {{ \Illuminate\Support\Str::limit($ticket->subject, 35) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                {{ strtoupper($ticket->category->name ?? '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $prioBadge = match($ticket->priority) {
                                    'high' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 border-rose-200',
                                    'medium' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 border-blue-200',
                                    default => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300 border-slate-200',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded border {{ $prioBadge }}">
                                {{ ucfirst($ticket->priority) }}
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
                        @if(auth()->user()->isAdmin())
                            <td class="px-6 py-4">
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
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($ticket->assignedAdmin)
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2.5 py-1 rounded-full border border-blue-200 dark:border-blue-800">
                                    <i class="bi bi-person-fill"></i> {{ $ticket->assignedAdmin->name }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">Belum di-assign</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('tiket.show', $ticket->id) }}" class="py-1.5 px-3 text-xs font-medium text-blue-600 focus:outline-none bg-blue-50 rounded-lg border border-blue-200 hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-700 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-600 dark:hover:text-white dark:hover:bg-blue-700 inline-flex items-center gap-1 transition-all">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 10 : 8 }}" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-ticket-perforated text-4xl block mb-2 opacity-40"></i>
                            <p class="text-sm">Tidak ada data tiket yang ditemukan.</p>
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
