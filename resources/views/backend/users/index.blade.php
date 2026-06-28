@extends('layouts.app-backend')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Banner Premium -->
    <div class="bg-linear-to-r from-indigo-600 via-purple-600 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden border border-white/10">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col sm:flex-row items-center gap-5 z-10 text-center sm:text-left">
            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md text-white flex items-center justify-center text-3xl shadow-inner shrink-0 border border-white/20">
                👥
            </div>
            <div>
                <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-purple-400/20 text-purple-200 border border-purple-400/30 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
                        User Directory Active
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $title }}</h1>
                <p class="text-indigo-100 text-sm mt-1 max-w-xl">Pusat kendali akun, pemantauan peran kewenangan (*role permissions*), dan manajemen pengguna terdaftar di platform.</p>
            </div>
        </div>

        <div class="z-10 shrink-0">
            <div class="px-4 py-2.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-center">
                <span class="block text-[11px] font-bold uppercase tracking-widest text-indigo-200">Total Terdaftar</span>
                <span class="text-xl font-black text-white">{{ $users->total() }} Pengguna</span>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 shadow-xs">
            <svg class="w-6 h-6 shrink-0 text-emerald-600 dark:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search Card -->
    <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-center">
            <div class="relative grow w-full">
                <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                </div>
                <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full ps-10 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-medium" placeholder="Cari berdasarkan Nama Lengkap atau Alamat Email..." value="{{ request('search') }}">
            </div>

            <div class="flex gap-2 w-full sm:w-auto shrink-0">
                <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-bold rounded-xl text-sm px-6 py-3 w-full sm:w-auto transition-all shadow-sm cursor-pointer flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                    <span>Cari Pengguna</span>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('users.index') }}" class="p-3 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl hover:bg-gray-200 hover:text-indigo-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white transition-all flex items-center justify-center shrink-0" title="Reset Pencarian">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 dark:bg-gray-700/80 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 font-extrabold">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-16 text-center">ID</th>
                        <th scope="col" class="px-6 py-4 min-w-[250px]">Informasi Pengguna</th>
                        <th scope="col" class="px-6 py-4 text-center">Peran Akses (*Role*)</th>
                        <th scope="col" class="px-6 py-4">Kontak Telepon</th>
                        <th scope="col" class="px-6 py-4">Terdaftar Sejak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($users as $user)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-indigo-50/30 dark:hover:bg-gray-700/40 transition-colors">
                            <td class="px-6 py-5 text-center font-bold text-gray-400">
                                #{{ $user->id }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-2xl bg-linear-to-tr from-indigo-600 via-purple-600 to-pink-500 text-white flex items-center justify-center font-black text-base shadow-md shrink-0 border border-white/20">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-gray-900 dark:text-white text-base leading-tight mb-0.5">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-purple-600 dark:text-purple-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                                        <span>Administrator</span>
                                    </span>
                                @elseif($user->role === 'service_desk')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm1 11H9v-2h2v2Zm0-4H9V5h2v4Z"/></svg>
                                        <span>Service Desk</span>
                                    </span>
                                @elseif($user->role === 'helpdesk')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-emerald-600 dark:text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                                        <span>Teknisi Helpdesk</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                        <span>Karyawan / Pelapor</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 font-semibold text-gray-700 dark:text-gray-300">
                                {{ $user->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    <span>{{ $user->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"/></svg>
                                </div>
                                <h5 class="text-base font-bold text-gray-800 dark:text-gray-200 mb-1">Pengguna Tidak Ditemukan</h5>
                                <p class="text-xs max-w-sm mx-auto">Tidak ada data pengguna yang sesuai dengan kata kunci pencarian Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
