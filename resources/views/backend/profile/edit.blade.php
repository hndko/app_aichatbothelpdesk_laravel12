@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Banner -->
    <div
        class="bg-linear-to-r from-blue-600 via-indigo-600 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg flex flex-col sm:flex-row items-center gap-6 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

        <div
            class="w-20 h-20 rounded-full bg-white text-blue-600 flex items-center justify-center font-extrabold text-3xl shadow-xl shrink-0 border-4 border-white/20">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="text-center sm:text-left z-10">
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <p class="text-blue-100 text-sm mt-1">{{ $user->email }}</p>
            <div
                class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md text-white border border-white/20">
                <span>👑 Peran Akun:</span>
                <span class="uppercase">{{ $user->role }}</span>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <h3
            class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 border-b border-gray-100 dark:border-gray-700 pb-4">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
            </svg>
            <span>Informasi Data Diri</span>
        </h3>

        @if($errors->any())
        <div
            class="p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 dark:bg-gray-700 dark:text-red-400 border border-red-200 dark:border-red-800">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Nama
                        Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs"
                        required>
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Alamat
                        Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs"
                        required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Nomor
                        WhatsApp / Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="08123456789"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Status Hak
                        Akses</label>
                    <input type="text" value="{{ strtoupper($user->role) }}" disabled
                        class="bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-xl block w-full p-3 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300 cursor-not-allowed">
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                <h4 class="text-md font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 20">
                        <path
                            d="M14 7h-1.5V4.5a4.5 4.5 0 1 0-9 0V7H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-8.5-2.5a2.5 2.5 0 1 1 5 0V7h-5V4.5ZM10 13.5a2 2 0 1 1-4 0v-1a2 2 0 1 1 4 0v1Z" />
                    </svg>
                    <span>Ganti Kata Sandi (Opsional)</span>
                </h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Kosongkan bagian ini jika Anda tidak ingin
                    mengubah kata sandi akun Anda.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kata
                            Sandi Baru</label>
                        <input type="password" id="password" name="password" placeholder="Minimal 6 karakter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs">
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Kata Sandi
                            Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi kata sandi baru"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all shadow-xs">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit"
                    class="text-white bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-6 py-3 text-center dark:focus:ring-blue-800 flex items-center gap-2 shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 11.917 9.724 16.5 19 7.5" />
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
