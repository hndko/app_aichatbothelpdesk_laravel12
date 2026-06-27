<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal IT Helpdesk' }} — NexusDesk AI</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        .frontend-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--gray-lightest);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .hero-section {
            background: linear-gradient(135deg, #4F46E5 0%, #3B82F6 50%, #06B6D4 100%);
            padding: 5rem 1rem 6rem;
            color: white;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 50%;
            top: -150px;
            right: -100px;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }
        .hero-search-card {
            max-width: 720px;
            margin: -3rem auto 3rem;
            position: relative;
            z-index: 10;
        }
        .faq-card {
            transition: var(--transition);
            border: 1px solid var(--gray-lightest);
            border-radius: var(--border-radius);
            background: white;
            overflow: hidden;
            height: 100%;
        }
        .faq-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-light);
        }
        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            background: white;
            border: 1px solid var(--gray-lightest);
            color: var(--dark-light);
            font-weight: 500;
            font-size: 0.875rem;
            transition: var(--transition-fast);
        }
        .category-pill:hover, .category-pill.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }
        .frontend-footer {
            background: var(--dark);
            color: var(--gray-light);
            padding: 3rem 0 2rem;
            margin-top: 5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="frontend-header py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('portal') }}" class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="height: 38px; border-radius: 8px;">
                <div>
                    <h5 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">NexusDesk <span class="text-primary">AI</span></h5>
                    <small class="text-muted d-block" style="font-size: 0.65rem; line-height: 1;">PORTAL IT HELPDESK</small>
                </div>
            </a>

            <div class="d-flex align-items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-nd-primary btn-sm px-3">
                        <i class="bi bi-speedometer2"></i> Ke Dasbor Helpdesk
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-nd-primary btn-sm px-3">
                        <i class="bi bi-box-arrow-in-right"></i> Login Helpdesk
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="frontend-footer border-top border-secondary">
        <div class="container">
            <div class="row g-4 justify-content-between mb-4">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="height: 32px; border-radius: 6px;">
                        <h6 class="mb-0 fw-bold text-white">NexusDesk AI</h6>
                    </div>
                    <p class="small mb-0 text-secondary">Solusi sistem IT Helpdesk cerdas berbasis Artificial Intelligence. Membantu karyawan menemukan jawaban teknis seketika dengan akurasi tinggi dari Knowledge Base perusahaan.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <h6 class="text-white fw-semibold mb-2">Butuh Bantuan Langsung?</h6>
                    <p class="small mb-1 text-secondary">Jika kendala tidak ditemukan di FAQ ini, silakan login untuk membuat tiket baru.</p>
                    <a href="{{ route('login') }}" class="text-accent text-decoration-none small fw-medium">Submit Tiket Kendala <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="border-top border-secondary pt-3 d-flex flex-wrap justify-content-between align-items-center small text-secondary">
                <span>&copy; {{ date('Y') }} NexusDesk AI Helpdesk. All rights reserved.</span>
                <span>🥇 Project #1 — Advanced Agentic Coding Portofolio</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Global JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
