<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="NexusDesk AI — Sistem Helpdesk IT Cerdas">
    <title>{{ $title ?? 'Dashboard' }} — NexusDesk AI</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="app-sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('assets/images/logo.png') }}" alt="NexusDesk AI">
            <div class="sidebar-brand-text">
                <h5>NexusDesk AI</h5>
                <small>ND AI Helpdesk</small>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="sidebar-label">Menu Utama</div>

            <div class="sidebar-item">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="sidebar-item">
                <a href="{{ route('tiket.index') }}" class="sidebar-link {{ request()->routeIs('tiket.*') ? 'active' : '' }}">
                    <i class="bi bi-ticket-perforated-fill"></i>
                    <span>Tiket Saya</span>
                </a>
            </div>

            @if(auth()->user()->role === 'admin')
                <div class="sidebar-label">Kelola</div>

                <div class="sidebar-item">
                    <a href="{{ route('knowledge-base.index') }}" class="sidebar-link {{ request()->routeIs('knowledge-base.*') ? 'active' : '' }}">
                        <i class="bi bi-book-fill"></i>
                        <span>Knowledge Base</span>
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Kelola User</span>
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('report.index') }}" class="sidebar-link {{ request()->routeIs('report.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        <span>Laporan</span>
                    </a>
                </div>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start" style="cursor:pointer;">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Topbar -->
    <header class="app-topbar">
        <div class="topbar-left">
            <button class="btn-sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-title">
                <h4>{{ $title ?? 'Dashboard' }}</h4>
            </div>
        </div>

        <div class="topbar-right">
            <div class="topbar-user dropdown">
                <div class="d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="topbar-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="topbar-user-info d-none d-sm-flex">
                        <span>{{ auth()->user()->name }}</span>
                        <small>{{ auth()->user()->role }}</small>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 0.75rem; color: var(--gray);"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-left me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="app-main">
        <div class="app-content animate-fade-in">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flash Messages -->
    @if(session('success'))
        <input type="hidden" id="flash-success" value="{{ session('success') }}">
    @endif
    @if(session('error'))
        <input type="hidden" id="flash-error" value="{{ session('error') }}">
    @endif
    @if(session('warning'))
        <input type="hidden" id="flash-warning" value="{{ session('warning') }}">
    @endif

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
