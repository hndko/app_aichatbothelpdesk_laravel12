@extends('layouts.app-backend')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Nav -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-300 flex items-center justify-center text-2xl shrink-0 border border-purple-100 dark:border-purple-800 shadow-2xs">
                👤+
            </div>
            <div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">{{ $title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Daftarkan akun pengguna baru untuk memberi hak akses ke dalam sistem</p>
            </div>
        </div>
        <a href="{{ route('users.index') }}" class="py-2.5 px-4 text-sm font-bold text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center justify-center gap-2 transition-all shadow-2xs shrink-0">
            <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Info Banner -->
    <div class="p-4 rounded-2xl bg-indigo-50/80 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800/60 flex items-start gap-3 text-indigo-900 dark:text-indigo-200">
        <span class="text-xl shrink-0">💡</span>
        <div class="text-xs leading-relaxed">
            <strong class="font-bold block text-sm mb-0.5">Panduan Hak Akses (*Role*):</strong>
            <strong>User:</strong> Karyawan pelapor kendala. | <strong>Helpdesk:</strong> Teknisi penanganan masalah teknis. | <strong>Service Desk:</strong> Distributor dan pemantau tiket. | <strong>Admin:</strong> Pengelola penuh sistem.
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        value="{{ old('name') }}"
                        placeholder="Contoh: Budi Santoso"
                        @class([
                            'bg-gray-50 border text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-semibold',
                            'border-red-500' => $errors->has('name'),
                            'border-gray-300' => !$errors->has('name'),
                        ])
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
                        value="{{ old('email') }}"
                        placeholder="Contoh: budi@company.com"
                        @class([
                            'bg-gray-50 border text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-semibold',
                            'border-red-500' => $errors->has('email'),
                            'border-gray-300' => !$errors->has('email'),
                        ])
                        required
                    >
                    @error('email')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Role -->
                <div class="space-y-2">
                    <label for="role" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>Peran Akses (*Role*)</span> <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="role" @class([
                        'bg-gray-50 border text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all font-bold',
                        'border-red-500' => $errors->has('role'),
                        'border-gray-300' => !$errors->has('role'),
                    ])>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>👤 Karyawan / Pelapor (User)</option>
                        <option value="helpdesk" {{ old('role') === 'helpdesk' ? 'selected' : '' }}>🟢 Teknisi Helpdesk</option>
                        <option value="service_desk" {{ old('role') === 'service_desk' ? 'selected' : '' }}>🔵 Service Desk</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>🟣 Administrator IT</option>
                    </select>
                    @error('role')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div class="space-y-2">
                    <label for="phone" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>📱 Nomor WhatsApp / Telepon</span>
                    </label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Contoh: 081234567890"
                        @class([
                            'bg-gray-50 border text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-medium',
                            'border-red-500' => $errors->has('phone'),
                            'border-gray-300' => !$errors->has('phone'),
                        ])
                    >
                    @error('phone')
                        <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>Password Akun</span> <span class="text-red-500">*</span>
                    </label>
                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/40 px-2.5 py-1 rounded-lg border border-indigo-200 dark:border-indigo-800">
                        🔑 Default disarankan: <code class="font-mono">password</code>
                    </span>
                </div>
                <input
                    type="text"
                    id="password"
                    name="password"
                    value="{{ old('password', 'password') }}"
                    placeholder="Masukkan password akun..."
                    @class([
                        'bg-gray-50 border text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all font-mono font-bold',
                        'border-red-500' => $errors->has('password'),
                        'border-gray-300' => !$errors->has('password'),
                    ])
                    required
                >
                <p class="text-xs text-gray-500 dark:text-gray-400">Anda dapat mengubah atau membiarkan password default di atas (<code class="font-mono font-bold text-gray-700 dark:text-gray-300">password</code>).</p>
                @error('password')
                    <p class="text-xs font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Spesialisasi Kategori (Untuk Teknisi & Staf) -->
            <div id="specialization_section" class="space-y-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>🛠️ Spesialisasi Penanganan Kategori Tiket</span>
                    </label>
                    <span class="text-[11px] font-semibold text-gray-500 dark:text-gray-400 italic">(Khusus untuk Teknisi Helpdesk / Staf)</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Centang kategori yang dikuasai agar sistem dapat melakukan penugasan (*assignment*) tiket secara tepat.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                    @foreach($categories as $cat)
                        <label class="flex items-center p-3.5 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-indigo-50/50 dark:hover:bg-gray-700/50 cursor-pointer transition-all gap-3 bg-gray-50/50 dark:bg-gray-800">
                            <input type="checkbox" name="specializations[]" value="{{ $cat->id }}" class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ in_array($cat->id, old('specializations', [])) ? 'checked' : '' }}>
                            <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200">{{ strtoupper($cat->name) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('users.index') }}" class="w-full sm:w-auto py-3 px-6 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-extrabold rounded-xl text-sm px-6 py-3 text-center inline-flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20 transition-all cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18 1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5v-3h10v3Zm0-5H5V3h10v7Z"/></svg>
                    <span>Simpan Pengguna Baru</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const specSection = document.getElementById('specialization_section');

    function toggleSpecialization() {
        if (roleSelect.value === 'user') {
            specSection.style.opacity = '0.4';
            specSection.style.pointerEvents = 'none';
        } else {
            specSection.style.opacity = '1';
            specSection.style.pointerEvents = 'auto';
        }
    }

    if (roleSelect && specSection) {
        roleSelect.addEventListener('change', toggleSpecialization);
        toggleSpecialization();
    }
});
</script>
@endsection
