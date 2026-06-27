# GEMINI — Dokumentasi & Aturan Kerja Project AI Chatbot Helpdesk

Dokumen ini berisi informasi lengkap spesifikasi project **AI Chatbot Helpdesk** sekaligus menjadi patokan aturan kerja wajib (Rules) bagi AI Agent (Gemini) maupun developer dalam mengembangkan aplikasi ini.

---

## BAGIAN I: INFORMASI PROJECT

### 1. Deskripsi & Latar Belakang
- **Nama Project:** 🥇 Project #1: AI Chatbot Helpdesk
- **Objektif:** Solusi sistem manajemen tiket layanan IT (IT Helpdesk) yang terintegrasi dengan AI Chatbot untuk menjawab FAQ secara otomatis berdasarkan *knowledge base* perusahaan.
- **Value Utama:** Secara langsung merepresentasikan *daily job* IT Helpdesk di dunia nyata. Memberikan bukti nyata kepada HR/perusahaan mengenai kemampuan dalam membangun solusi otomasi cerdas untuk efisiensi penanganan masalah teknis sehari-hari.
- **Estimasi Pengerjaan:** 2 Minggu

### 2. Tech Stack
- **Backend:** PHP 8.2+, Laravel 12
- **Frontend:** Laravel Blade, Tailwind CSS v4.0 (Flowbite Component Library & Icons, Responsive UI/UX, Vanilla JS)
- **Database:** MySQL (via Laragon)
- **AI Integration:** OpenAI API / Gemini API / OpenRouter / Custom Base URL + API Key (Mendukung fleksibilitas pergantian provider LLM)
- **Eksternal & Library:** Flowbite Toast / SweetAlert2, DomPDF / Maatwebsite Excel (untuk export laporan)

### 3. Daftar Fitur

#### A. Fitur Wajib
1. **Login Multi-Role:** Pemisahan hak akses dan tampilan dasbor antara `admin` (IT Helpdesk) dan `user` (Karyawan/Pelapor).
2. **Submit Tiket:** Pelapor dapat membuat tiket kendala dengan pengelompokan kategori:
   - *Hardware* (Kendala perangkat keras)
   - *Software* (Kendala aplikasi/sistem operasi)
   - *Network* (Kendala jaringan/internet)
3. **AI Chatbot FAQ:** Asisten virtual otomatis yang menjawab pertanyaan umum dari *knowledge base* sebelum tiket diteruskan ke admin.
4. **Admin Dashboard:** Pusat kelola tiket, pemantauan statistik analitik lengkap (distribusi kategori, prioritas, sentimen AI, dan SLA completion rate) yang dilengkapi filter rentang waktu (*range date*), serta pembaruan alur status tiket (`open` → `progress` → `closed`).
5. **History Chat:** Riwayat interaksi/percakapan lengkap per ID tiket antara pelapor, chatbot, dan admin.
6. **Notifikasi Email:** Pengiriman pemberitahuan otomatis kepada pelapor setiap kali ada balasan atau pembaruan status pada tiketnya.

#### B. Fitur Bonus (*Standout Features*)
1. **Sentimen Analisis Tiket:** AI mendeteksi tingkat kepuasan pelapor (Puas / Netral / Tidak Puas) berdasarkan teks/pesan pada tiket atau chat.
2. **Export Laporan:** Kemampuan mengunduh ringkasan performa helpdesk dan data tiket ke format **PDF** dan **Excel**.
3. **Auto-Assign Tiket:** Sistem secara cerdas mendistribusikan tiket secara otomatis kepada admin/teknisi tertentu berdasarkan kategori kendala.
4. **Konfigurasi AI Provider & Model Dinamis:** Admin dapat mengelola dan mengganti penyedia layanan LLM (OpenRouter, OpenAI, Gemini, Custom Base URL) serta model AI langsung melalui antarmuka UI tanpa perlu mengubah `.env` atau merestart server.

---

## BAGIAN II: ATURAN KERJA AGENT (RULES & CONVENTIONS)

Jika terdapat konflik antara kebiasaan umum penulisan kode dengan aturan di bawah ini, maka aturan pada dokumen `GEMINI.md` ini yang wajib diprioritaskan.

### 1. Prinsip Pengembangan & Keamanan
- **Fokus & Terarah:** Lakukan perubahan kode secara spesifik sesuai instruksi. Jangan memindahkan atau mengubah arsitektur besar tanpa persetujuan eksplisit.
- **Integritas Kode:** Jangan menghapus fitur, kode, atau file lain yang tidak terkait langsung dengan tugas yang sedang dikerjakan.
- **Validasi Kritis:** Untuk pengembangan fitur AI, integrasi API eksternal, transaksi database, atau unggah file, wajib memperhatikan:
  - **AI API Fallback & Timeout:** Tangani kegagalan koneksi API LLM (OpenAI/Gemini/OpenRouter) dengan mekanisme *try-catch*, *timeout* yang wajar, dan pesan *fallback* yang ramah bagi user agar aplikasi tidak mengalami *crash* (Error 500).
  - **Keamanan:** Mencegah kebocoran API Key (wajib simpan di `.env`), sanitasi input untuk mencegah *Prompt Injection*, SQL Injection, XSS, serta proteksi CSRF.
  - **Optimasi Database:** Hindari *N+1 query problem*, gunakan *eager loading*, dan pastikan indexing yang tepat pada tabel tiket serta riwayat chat.
  - **Concurrency:** Cegah *race condition* saat admin memperbarui status tiket secara bersamaan.

### 2. Arsitektur Folder & Asset
- **Asset Statis:** File CSS kustom, JS, gambar, dan font disimpan di dalam `public/assets/`.
- **Controller:** Berada langsung di `app/Http/Controllers/` tanpa membuat subfolder baru, kecuali untuk pemisahan namespace yang terencana matang.
- **Model:** Berada di `app/Models/`.
- **View:** 
  - Halaman Dasbor & Manajemen Admin/User berada di `resources/views/backend/[modul]/`.
  - Halaman Portal Publik/Chatbot awal berada di `resources/views/frontend/`.
  - Layout utama berada di `resources/views/layouts/`.
- **Larangan Folder Partials:** Jangan membuat folder atau view bertipe `partials`. Markup UI (seperti form) wajib ditulis penuh di dalam file view fitur terkait. Jika endpoint AJAX membutuhkan balasan potongan HTML, simpan view tersebut dengan nama eksplisit di folder modul terkait tanpa path `partials`.
- **Pengaturan Sistem:** Identitas sistem (Judul aplikasi, logo, konfigurasi LLM aktif) bersumber dari tabel pengaturan/config atau `.env`, tidak boleh di-*hardcode* di dalam view atau controller.

### 3. File Layout Utama

| Layout | File Path | Penggunaan |
| :--- | :--- | :--- |
| **Backend** | `resources/views/layouts/app-backend.blade.php` | Halaman dasbor, kelola tiket, riwayat chat (Admin & User logged-in) |
| **Auth** | `resources/views/layouts/app-auth.blade.php` | Halaman autentikasi (Login, Register, Forgot Password) |
| **Frontend** | `resources/views/layouts/app-frontend.blade.php` | Halaman portal publik pencarian FAQ tanpa login |

### 4. Konvensi Layout & Blade
- **Pembatasan Yield:** Layout utama hanya boleh menyediakan satu `@yield('content')` sebagai slot area konten utama.
- **Pengiriman Title:** Judul halaman dikirim dari controller melalui variabel `$title`, kemudian dirender langsung di layout utama. Jangan menambahkan `@yield('title')`, `@yield('styles')`, atau `@yield('scripts')` baru.
- **Pemanfaatan Asset & Tailwind CSS v4:** Seluruh styling wajib menggunakan Tailwind CSS v4 & Flowbite. Ikuti aturan standar Tailwind v4 berikut agar tidak menimbulkan warning/error:
  - Gunakan `shrink-0` (bukan `flex-shrink-0`).
  - Gunakan `grow` (bukan `flex-grow`).
  - Gunakan `inset-s-0` / `inset-e-0` (bukan `start-0` / `end-0`).
  - Gunakan `bg-linear-to-r` (bukan `bg-gradient-to-r`).
  - Ikon wajib menggunakan Flowbite SVG Icons (`https://flowbite.com/docs/customize/icons/`).
  - Notifikasi/Alert wajib menggunakan Flowbite Toast component (`https://flowbite.com/docs/components/toast/`).
- **Larangan Query di Blade:** Dilarang keras melakukan query database atau memanggil Eloquent langsung di dalam file `.blade.php` (contoh: `Tiket::get()`). Seluruh data harus disiapkan oleh controller.
- **Larangan Blok PHP di View:** Hindari penggunaan tag `@php ... @endphp` atau `<?php ... ?>` di dalam Blade. Pemetaan warna status (*badge* Tailwind/Flowbite), kalkulasi, atau logika kondisional harus diproses di Controller atau Helper.
- **Keutuhan Form:** Form `create.blade.php` dan `edit.blade.php` wajib ditulis secara utuh dan mandiri. Jangan menggunakan `@include()` untuk memotong form atau tabel utama.

### 5. Konvensi Controller & Eloquent Model
- **Passing Data ke View:** Gunakan return view dengan associative array `$data` (contoh: `return view('backend.tiket.index', $data);`). Dilarang menggunakan fungsi `compact()`.
- **Parameter Route:** Method controller menerima parameter ID bertipe string: `public function show(string $id)`, **bukan** *Implicit Route Model Binding*.
- **Pencarian Data Eksplisit:** Ambil data di dalam method menggunakan `Model::findOrFail($id)`.
- **Validasi Request:** Selalu gunakan `$request->validate([...])` secara eksplisit sebelum melakukan `create` atau `update`. Hindari penggunaan `$request->all()`.
- **Transaksi Database:** Gunakan `DB::transaction()` untuk operasi yang melibatkan manipulasi beberapa tabel sekaligus.

### 6. Tabel Pedoman Penamaan

| Elemen | Konvensi | Contoh |
| :--- | :--- | :--- |
| **File View** | `snake_case.blade.php` | `index.blade.php`, `show_ticket.blade.php`, `edit.blade.php` |
| **Folder View** | `lowercase` sesuai modul | `backend/tiket`, `backend/dashboard`, `backend/profile`, `backend/ai_setting` |
| **Controller** | `PascalCase + Controller` | `TiketController.php`, `ChatbotController.php`, `ProfileController.php`, `AiSettingController.php` |
| **Model** | `PascalCase` (Tunggal) | `Tiket.php`, `Kategori.php`, `ChatHistory.php`, `WebsiteSetting.php` |
| **Route Name** | `dot.notation` | `tiket.index`, `profile.edit`, `ai-setting.index` |
| **File Layout** | `app-[nama].blade.php` | `app-backend.blade.php` |

### 7. Alur Menambah Halaman / Modul Baru
1. Buat file view baru di `resources/views/backend/[modul]/nama_blade.blade.php`.
2. Gunakan `@extends('layouts.app-backend')` dan `@section('content')`.
3. Di dalam Controller, siapkan array `$data['title'] = 'Judul Halaman';` beserta data model yang dibutuhkan.
4. Daftarkan route di `routes/web.php` di dalam grup middleware `auth` dan *role check* yang sesuai.
5. Tambahkan tautan navigasi di sidebar layout `app-backend.blade.php` jika diperlukan.

### 8. Aturan Git Commit & Auto-Push

Setiap selesai pengerjaan instruksi, agent wajib melakukan **auto commit dan push** dengan aturan penulisan pesan commit:

#### A. Struktur Pesan
`type(scope): subject`

- **Type (huruf kecil):**
  - `feat`: Menambahkan fitur baru.
  - `fix`: Memperbaiki bug.
  - `docs`: Perubahan dokumentasi.
  - `refactor`: Perubahan kode yang tidak memperbaiki bug atau menambah fitur.
  - `test`: Menambahkan atau memperbaiki tes.
  - `chore`: Pekerjaan rutin seperti build atau manajemen dependensi.
- **Scope:** (Opsional) Bagian kode yang diubah dalam tanda kurung, contoh: `(auth)`, `(tiket)`, `(ui)`.
- **Subject:** Deskripsi singkat perubahan menggunakan kalimat imperatif (contoh: "tambahkan", "ubah", bukan "menambahkan" atau "mengubah").

#### B. Aturan 50/72
- **Maksimal 50 Karakter:** Baris subjek/judul tidak boleh lebih dari 50 karakter.
- **Maksimal 72 Karakter:** Bagian isi (*body*) dibungkus maksimal 72 karakter per baris.

#### C. Best Practices
- Gunakan huruf kecil, kecuali untuk kata pertama pada kalimat deskripsi di body.
- Selalu beri jarak satu baris kosong antara judul commit dan isi penjelasan (*body*).
- Fokus pada **mengapa** perubahan dibuat, bukan bagaimana cara kerjanya.
