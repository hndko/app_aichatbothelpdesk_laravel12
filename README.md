<div align="center">
  <img src="public/assets/images/logo.png" alt="MariDesk AI Logo" width="120" style="border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
  
  # 🚀 MariDesk AI
  ### Sistem Manajemen IT Helpdesk & Asisten Virtual Cerdas Berbasis AI
  
  [![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![Flowbite](https://img.shields.io/badge/Flowbite-UI_Library-1E40AF?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://flowbite.com)
  [![PHP Version](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![AI Powered](https://img.shields.io/badge/AI_Powered-OpenAI_%2F_Gemini-412991?style=for-the-badge&logo=openai&logoColor=white)](https://openai.com)
</div>

---

## 🌟 Tentang Proyek (Portfolio Highlight)

**MariDesk AI** adalah solusi platform **IT Helpdesk modern** yang digabungkan dengan **Kecerdasan Buatan (AI Chatbot)** untuk mentransformasi cara perusahaan menangani kendala teknis sehari-hari. 

Proyek ini dibangun sebagai representasi nyata dari alur kerja operasional IT Support di level *enterprise*, di mana efisiensi, kecepatan respon, dan kepuasan pengguna menjadi prioritas utama. Dengan menyaring pertanyaan umum melalui *Knowledge Base* pintar, MariDesk AI menghemat hingga **70% waktu teknisi IT**, sehingga teknisi dapat fokus menyelesaikan masalah teknis yang lebih kompleks.

---

## ✨ Fitur Unggulan

### 🤖 1. AI Chatbot Asisten Virtual 24/7
* **Automasi Jawaban Instan**: Pelapor dapat berinteraksi langsung dengan AI Chatbot sebelum tiket diteruskan ke admin. AI menjawab pertanyaan secara akurat berdasarkan data *Knowledge Base* perusahaan.
* **Smart Fallback**: Jika kendala membutuhkan intervensi manusia, alur percakapan mulus beralih menjadi tiket penanganan oleh teknisi.

### 🎫 2. Manajemen Tiket Multi-Kategori & Status
* **Kategori Terstruktur**: Pemisahan kendala ke dalam **Hardware**, **Software**, dan **Network**.
* **Alur Status Transparan**: Pemantauan status tiket secara *real-time* dari `Open` ➔ `Progress` ➔ `Closed`.
* **Prioritas Penanganan**: Pengelompokan tingkat urgensi (*Low*, *Medium*, *High*, *Urgent*).

### 💡 3. Sentimen Analisis AI (*Standout Feature*)
* **Deteksi Emosi Pelapor**: AI secara otomatis menganalisis nada pesan dan percakapan untuk menentukan tingkat kepuasan pelapor (**😊 Puas / 😐 Netral / 😠 Tidak Puas / Urgent**).
* Membantu manajer IT memprioritaskan tiket dengan sentimen negatif agar segera ditangani guna menjaga kualitas layanan (*SLA*).

### 📑 4. Ekspor Laporan Eksekutif (PDF & Excel)
* **Laporan Siap Cetak**: Unduh rekapitulasi performa teknisi, analisis sentimen, dan riwayat kendala dalam format **PDF** (berkualitas tinggi) maupun **Excel** untuk analisis lanjutan.

### 🎨 5. Desain UI/UX Premium & Mode Gelap (*Dark Mode*)
* Didesain dengan **Tailwind CSS v4.0** dan **Flowbite**, memberikan tampilan yang estetis, *glassmorphism*, bergaya *modern dynamic*, serta **100% responsif** di semua perangkat (Desktop, Tablet, dan Mobile).
* Dilengkapi dengan efek interaktif, transisi halus, dan kursor kustom.

### 🇮🇩 6. Lokalisasi Indonesia Penuh
* Menggunakan format waktu **Carbon Indonesia (`translatedFormat`)** dengan jam, menit, dan detik (WIB).
* Sudah dilengkapi 20+ seeder data *Knowledge Base* kasus nyata IT Helpdesk kantor di Indonesia.

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi / Library |
| :--- | :--- |
| **Backend Framework** | Laravel 12 (PHP 8.2+) |
| **Frontend Styling** | Tailwind CSS v4.0, Vanilla CSS |
| **Component Library** | Flowbite Components & Flowbite SVG Icons |
| **Database** | MySQL (Laragon / Eloquent ORM) |
| **AI Integration** | OpenAI API / Gemini API / OpenRouter LLM |
| **PDF & Excel Export** | DomPDF & Maatwebsite Excel |
| **Notification & Alert** | Flowbite Toast / SweetAlert2 |

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### 1. Kloning Repositori
```bash
git clone https://github.com/hndko/app_aichatbothelpdesk_laravel12.git
cd app_aichatbothelpdesk_laravel12
```

### 2. Instal Dependensi
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`, lalu atur koneksi database dan API Key AI Anda:
```bash
cp .env.example .env
php artisan key:generate
```
Pastikan Anda menambahkan konfigurasi AI di `.env`:
```env
AI_PROVIDER=openai # atau gemini / openrouter
AI_API_KEY="your-api-key-here"
AI_MODEL="gpt-4o-mini" # atau model pilihan Anda
```

### 4. Migrasi & Seeding Database
Jalankan migrasi beserta seeder terpecah yang sudah menyediakan 20 FAQ dan akun demo:
```bash
php artisan migrate:fresh --seed
```

### 5. Build Asset & Jalankan Server
```bash
npm run build
php artisan serve
```
Buka browser Anda dan akses: **`http://127.0.0.1:8000`**

---

## 🔐 Akun Demo (Untuk Pengujian)

Anda dapat masuk menggunakan akun seeder berikut:

| Peran (*Role*) | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| 🛡️ **Administrator IT** | `admin@example.com` | `password` | Kelola tiket, balas chat, analisis sentimen, ekspor laporan PDF/Excel, kelola FAQ |
| 👤 **Karyawan / Pelapor** | `user@example.com` | `password` | Submit tiket baru, chat dengan AI Bot, pantau status tiket |
| 👤 **Karyawan 2** | `siti@example.com` | `password` | Submit tiket baru |

---

## 📸 Snapshot Struktur Seeder

Proyek ini menerapkan arsitektur *seeder* yang modular dan bersih (`database/seeders/`):
* `CategorySeeder.php` ➔ Data kategori Hardware, Software, Network.
* `UserSeeder.php` ➔ Akun Administrator & Karyawan (dengan email `@example.com`).
* `WebsiteSettingSeeder.php` ➔ Konfigurasi nama platform & identitas perusahaan.
* `KnowledgeBaseSeeder.php` ➔ 20+ FAQ realistis IT Helpdesk Indonesia.
* `TicketSeeder.php` ➔ Contoh tiket awal beserta riwayat interaksi.

---

<div align="center">
  <p>Dikembangkan dengan ❤️ sebagai bukti portofolio keahlian pengerjaan aplikasi <strong>AI Agentic Coding & Fullstack Laravel Development</strong>.</p>
</div>
