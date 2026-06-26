/**
 * NexusDesk AI — Global JavaScript
 */
document.addEventListener('DOMContentLoaded', function () {

    // === Sidebar Toggle (Mobile) ===
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('appSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('show');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }

    // === SweetAlert2 Flash Messages ===
    const flashSuccess = document.getElementById('flash-success');
    const flashError = document.getElementById('flash-error');
    const flashWarning = document.getElementById('flash-warning');

    if (flashSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: flashSuccess.value,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
            customClass: { popup: 'animate__animated animate__fadeInRight' }
        });
    }

    if (flashError) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: flashError.value,
            timer: 4000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true
        });
    }

    if (flashWarning) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: flashWarning.value,
            timer: 4000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true
        });
    }

    // === Count-Up Animation ===
    const counters = document.querySelectorAll('.count-up');
    counters.forEach(function (counter) {
        const target = parseInt(counter.getAttribute('data-target'), 10);
        const duration = 1500;
        const step = Math.ceil(target / (duration / 16));
        let current = 0;

        const updateCounter = function () {
            current += step;
            if (current >= target) {
                counter.textContent = target.toLocaleString('id-ID');
                return;
            }
            counter.textContent = current.toLocaleString('id-ID');
            requestAnimationFrame(updateCounter);
        };

        // Use IntersectionObserver for lazy counting
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(counter);
    });

    // === SweetAlert Confirm Delete ===
    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = btn.closest('form') || document.getElementById(btn.dataset.formId);

            Swal.fire({
                title: 'Yakin hapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
        });
    });

    // === Active Sidebar Link ===
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar-link').forEach(function (link) {
        const href = link.getAttribute('href');
        if (href && currentPath.startsWith(href) && href !== '/') {
            link.classList.add('active');
        } else if (href === '/' && currentPath === '/') {
            link.classList.add('active');
        }
    });

});
