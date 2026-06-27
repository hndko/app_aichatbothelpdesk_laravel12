@extends('layouts.app-backend')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">Daftar pengguna terdaftar di sistem NexusDesk AI</p>
    </div>
</div>

<!-- Search Card Flowbite -->
<div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
    <form action="{{ route('users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-center">
        <div class="relative grow w-full">
            <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
            </div>
            <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all" placeholder="Cari Nama atau Email..." value="{{ request('search') }}">
        </div>

        <div class="flex gap-2 w-full sm:w-auto">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto transition-all">
                Cari
            </button>
            @if(request()->has('search') && request('search') != '')
                <a href="{{ route('users.index') }}" class="py-2.5 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 flex items-center justify-center" title="Reset">
                    <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Users Table Flowbite -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3.5 w-16">ID</th>
                    <th scope="col" class="px-6 py-3.5">User</th>
                    <th scope="col" class="px-6 py-3.5">Role</th>
                    <th scope="col" class="px-6 py-3.5">No. Telepon</th>
                    <th scope="col" class="px-6 py-3.5">Terdaftar Sejak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($users as $user)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-400">#{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-linear-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-md shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role === 'admin')
                                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded dark:bg-purple-900/40 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                    ADMIN IT
                                </span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                    USER
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $user->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 opacity-40 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/></svg>
                            <p class="text-sm">Belum ada data pengguna yang terdaftar.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
