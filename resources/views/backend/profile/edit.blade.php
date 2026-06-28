@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Banner Premium -->
    <div class="bg-linear-to-r from-indigo-600 via-purple-600 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden border border-white/10">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col sm:flex-row items-center gap-5 z-10 text-center sm:text-left">
            <div class="w-20 h-20 rounded-3xl bg-white/15 backdrop-blur-md text-white flex items-center justify-center font-black text-4xl shadow-inner shrink-0 border-2 border-white/20">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center justify-center sm:justify-start gap-2 mb-1.5">
                    <span class="px-3 py-0.5 rounded-full text-xs font-extrabold bg-purple-400/20 text-purple-200 border border-purple-400/30 flex items-center gap-1.5 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
                        <span>Sesi Akun Aktif (*Verified Session*)</span>
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $user->name }}</h1>
                <p class="text-indigo-100 text-sm mt-0.5 font-mono">{{ $user->email }}</p>
            </div>
        </div>

        <div class="z-10 shrink-0">
            <div class="px-5 py-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-center shadow-inner">
                <span class="block text-[11px] font-bold uppercase tracking-widest text-indigo-200">Peran Akses</span>
                <span class="text-lg font-black text-white uppercase flex items-center justify-center gap-1.5 mt-0.5">
                    @if($user->role === 'admin')
                        <span>👑</span> <span>Administrator</span>
                    @elseif($user->role === 'service_desk')
                        <span>🎧</span> <span>Service Desk</span>
                    @elseif($user->role === 'helpdesk')
                        <span>🛠️</span> <span>Helpdesk Staff</span>
                    @else
                        <span>👤</span> <span>Karyawan</span>
                    @endif
                </span>
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

    <!-- Alert Errors -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 shadow-xs">
            <div class="flex items-center gap-2 font-extrabold text-sm mb-2">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>
                <span>Mohon periksa kembali kesalahan berikut:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 font-semibold ps-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Kartu 1: Informasi Data Diri -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 flex items-center justify-center text-xl shrink-0 border border-indigo-100 dark:border-indigo-800">
                        👤
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white">Informasi Data Diri</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Kelola informasi nama pengenal dan kontak aktif Anda</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/40 px-3 py-1 rounded-full border border-indigo-200 dark:border-indigo-800 hidden sm:inline">Data Profil</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        <span>Nama Lengkap</span> <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        placeholder="Contoh: Budi Santoso"
                        class="bg-gray-50 border @error('name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-semibold"
                        required
                    >
                    @error('name')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                        <span>Alamat Email</span> <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        placeholder="Contoh: budi@company.com"
                        class="bg-gray-50 border @error('email') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-semibold"
                        required
                    >
                    @error('email')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <!-- No Telepon -->
                <div class="space-y-2">
                    <label for="phone" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>Nomor WhatsApp / Telepon</span>
                    </label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="Contoh: 081234567890"
                        class="bg-gray-50 border @error('phone') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-medium"
                    >
                    @error('phone')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Hak Akses (Readonly) -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>🔒 Status Hak Akses (*Role*)</span>
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            value="{{ strtoupper($user->role) }}"
                            disabled
                            class="bg-gray-100 border border-gray-200 text-gray-500 font-extrabold text-sm rounded-xl block w-full p-3.5 dark:bg-gray-700/60 dark:border-gray-600 dark:text-gray-400 cursor-not-allowed select-none"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-xs">
                            Kewenangan Terkunci
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Keamanan & Kata Sandi -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-300 flex items-center justify-center text-xl shrink-0 border border-amber-100 dark:border-amber-800">
                        🔑
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white">Perbarui Kata Sandi</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tingkatkan keamanan akun dengan memperbarui sandi secara berkala</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/40 px-3 py-1 rounded-full border border-amber-200 dark:border-amber-800 hidden sm:inline">Opsional</span>
            </div>

            <!-- Info Banner -->
            <div class="p-4 rounded-2xl bg-amber-50/70 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/60 flex items-start gap-3 text-amber-900 dark:text-amber-200">
                <span class="text-xl shrink-0">💡</span>
                <div class="text-xs leading-relaxed">
                    <strong class="font-bold block text-sm mb-0.5">Catatan Perubahan Sandi:</strong>
                    Biarkan kedua kolom di bawah ini tetap kosong jika Anda tidak bermaksud mengubah kata sandi akun Anda saat ini.
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Kata Sandi Baru -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-bold text-gray-900 dark:text-white">
                        Kata Sandi Baru <span class="text-xs font-normal text-gray-500">(Minimal 6 karakter)</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan sandi baru..."
                        class="bg-gray-50 border @error('password') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-mono"
                    >
                    @error('password')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Kata Sandi Baru -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-900 dark:text-white">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi sandi baru..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-mono"
                    >
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end pt-2">
            <button type="submit" class="w-full sm:w-auto text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-extrabold rounded-2xl text-sm px-8 py-4 text-center inline-flex items-center justify-center gap-2.5 shadow-xl shadow-indigo-600/30 transition-all cursor-pointer hover:scale-105 active:scale-95">
                <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                <span>Simpan Perubahan Profil</span>
            </button>
        </div>
    </form>
</div>
@endsection
