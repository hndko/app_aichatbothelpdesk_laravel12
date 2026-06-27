<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NexusDesk AI — Sistem Helpdesk IT Cerdas">
    <title>{{ $title ?? 'Login' }} — NexusDesk AI</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Flowbite via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        @yield('content')
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flash Messages -->
    @if(session('success'))
        <input type="hidden" id="flash-success" value="{{ session('success') }}">
    @endif
    @if(session('error'))
        <input type="hidden" id="flash-error" value="{{ session('error') }}">
    @endif

    <!-- Custom Alerts JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
