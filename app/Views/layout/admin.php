<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Panel - PACEKO.com') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Summernote Lite CSS (standalone, clean, no conflict) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <style>
        /* ADMIN MICRO-TYPOGRAPHY & COMPACT STYLING */
        :root {
            --admin-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --admin-red: #E50914;
            --admin-dark: #0f172a;
            --admin-sidebar-bg: #0b1120;
            --admin-border: #e2e8f0;
            --admin-body-bg: #f8fafc;
            --admin-font-size-base: 0.8125rem; /* ~13px compact font */
        }

        body {
            font-family: var(--admin-font);
            font-size: var(--admin-font-size-base);
            background-color: var(--admin-body-bg);
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        /* Compact Layout Wrappers */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Compact Sidebar */
        .admin-sidebar {
            width: 240px;
            background-color: var(--admin-sidebar-bg);
            color: #94a3b8;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.07);
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 16px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-brand img {
            max-height: 32px;
            filter: brightness(0) invert(1);
        }

        .sidebar-menu {
            padding: 14px 10px;
            list-style: none;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
        }
        .sidebar-header {
            font-size: 0.6875rem; /* 11px */
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 10px 12px 6px;
            font-weight: 700;
        }
        .sidebar-item {
            margin-bottom: 2px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 12px;
            border-radius: 6px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        .sidebar-link i {
            font-size: 0.875rem;
            width: 18px;
            text-align: center;
        }
        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }
        .sidebar-link.active {
            color: #ffffff;
            background: var(--admin-red);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(229, 9, 20, 0.35);
        }

        /* Mobile Offcanvas Sidebar */
        .admin-sidebar-offcanvas {
            width: 270px !important;
            background-color: var(--admin-sidebar-bg) !important;
            color: #94a3b8;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.45) !important;
        }
        .admin-sidebar-offcanvas .sidebar-brand {
            padding: 16px 20px;
            background: rgba(0, 0, 0, 0.25);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        .admin-sidebar-offcanvas .sidebar-brand img {
            max-height: 32px;
            filter: brightness(0) invert(1);
        }
        .admin-sidebar-offcanvas .sidebar-menu {
            overflow-y: auto;
            flex-grow: 1;
            padding-bottom: 20px;
        }

        /* Main Content Container */
        .admin-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Top Bar */
        .admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--admin-border);
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 990;
        }

        /* Compact Cards & Tables */
        .card-compact {
            background: #ffffff;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            margin-bottom: 18px;
        }
        .card-compact .card-header {
            background: #ffffff;
            border-bottom: 1px solid var(--admin-border);
            padding: 10px 16px;
            font-size: 0.85rem;
            font-weight: 700;
        }
        .card-compact .card-body {
            padding: 16px;
        }

        /* Micro Table Styling */
        .table-compact {
            font-size: 0.78125rem; /* 12.5px */
            margin-bottom: 0;
        }
        .table-compact th {
            background: #f8fafc;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
            font-weight: 700;
            padding: 8px 12px;
            border-bottom: 1px solid var(--admin-border);
            white-space: nowrap;
        }
        .table-compact td {
            padding: 7px 12px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-compact tr:hover td {
            background-color: #f8fafc;
        }

        /* Compact Buttons & Badges */
        .btn-compact {
            padding: 4px 10px;
            font-size: 0.75rem;
            border-radius: 5px;
            font-weight: 600;
        }
        .btn-xs {
            padding: 2px 8px;
            font-size: 0.7rem;
            border-radius: 4px;
            font-weight: 500;
            line-height: 1.4;
        }
        .badge-compact {
            font-size: 0.6875rem;
            padding: 3px 6px;
            font-weight: 600;
            border-radius: 4px;
        }

        /* Compact Inputs */
        .form-control-compact {
            font-size: 0.8125rem;
            padding: 6px 10px;
            border-radius: 6px;
            border-color: var(--admin-border);
        }
        .form-control-compact:focus {
            border-color: var(--admin-red);
            box-shadow: 0 0 0 2px rgba(229, 9, 20, 0.15);
        }

        /* Summernote Customization */
        .note-editor.note-airframe, .note-editor.note-frame {
            border: 1px solid var(--admin-border) !important;
            border-radius: 8px !important;
            font-size: 0.875rem;
        }
        .note-toolbar {
            background: #f8fafc !important;
            border-bottom: 1px solid var(--admin-border) !important;
            border-radius: 8px 8px 0 0 !important;
            padding: 6px !important;
        }
        .note-btn {
            font-size: 0.75rem !important;
            padding: 4px 8px !important;
        }
    </style>
</head>
<body>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start admin-sidebar-offcanvas d-lg-none" tabindex="-1" id="adminMobileSidebar" aria-labelledby="adminMobileSidebarLabel">
    <div class="sidebar-brand d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url(get_setting('site_logo', 'assets/images/logo.png')) ?>" alt="PACEKO.com">
            <div>
                <span class="d-block fw-bold text-white small" style="line-height: 1.1;"><?= esc(get_setting('site_title', 'PACEKO.COM')) ?></span>
                <span class="badge bg-danger p-0 px-1" style="font-size: 0.6rem;">ADMIN V2</span>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <?= $this->include('layout/sidebar_nav') ?>

    <div class="p-3 border-top border-secondary border-opacity-25 small text-secondary" style="font-size: 0.72rem;">
        <span>PACEKO Redaksi CI4</span><br>
        <span class="text-white-50">User: <strong><?= esc(session()->get('username') ?? 'admin') ?></strong></span>
    </div>
</div>

<div class="admin-wrapper">
    <!-- Desktop Sidebar -->
    <aside class="admin-sidebar d-none d-lg-flex">
        <div class="sidebar-brand">
            <img src="<?= base_url(get_setting('site_logo', 'assets/images/logo.png')) ?>" alt="PACEKO.com">
            <div>
                <span class="d-block fw-bold text-white small" style="line-height: 1.1;"><?= esc(get_setting('site_title', 'PACEKO.COM')) ?></span>
                <span class="badge bg-danger p-0 px-1" style="font-size: 0.6rem;">ADMIN V2</span>
            </div>
        </div>

        <?= $this->include('layout/sidebar_nav') ?>

        <div class="p-3 border-top border-secondary border-opacity-25 small text-secondary" style="font-size: 0.72rem;">
            <span>PACEKO Redaksi CI4</span><br>
            <span class="text-white-50">User: <strong><?= esc(session()->get('username') ?? 'admin') ?></strong></span>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-2">
                <!-- Hamburger Button for Mobile Sidebar (Top Left) -->
                <button class="btn btn-outline-danger btn-compact d-lg-none d-inline-flex align-items-center gap-1 shadow-sm px-2 py-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar" title="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars fs-6"></i>
                    <span class="fw-bold" style="font-size: 0.75rem;">Menu</span>
                </button>

                <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-secondary btn-compact d-flex align-items-center gap-1" title="Buka Website PACEKO">
                    <i class="fa-solid fa-globe"></i>
                    <span class="d-none d-sm-inline">Portal Berita</span>
                </a>
                <span class="text-muted d-none d-md-inline" style="font-size: 0.75rem;">• Portal Berita Profesional PACEKO</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <span class="d-block fw-bold text-dark" style="font-size: 0.78rem;"><?= esc(session()->get('display_name') ?? 'Admin Redaksi') ?></span>
                    <span class="badge bg-success-subtle text-success badge-compact">Online</span>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-1 border" data-bs-toggle="dropdown" style="width: 32px; height: 32px;">
                        <i class="fa-solid fa-user text-secondary" style="font-size: 0.8rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2 small" style="font-size: 0.78rem;">
                        <li><a class="dropdown-item py-2" href="<?= base_url('admin/profile') ?>"><i class="fa-solid fa-user-gear me-2"></i> Profil</a></li>
                        <li><a class="dropdown-item py-2" href="<?= base_url() ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i> Ke Website</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="<?= base_url('admin/logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 pt-3">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show py-2 px-3 small border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show py-2 px-3 small border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show py-2 px-3 small border-0 shadow-sm" role="alert">
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Admin Content Section -->
        <main class="p-3 p-md-4 flex-grow-1">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Admin Footer -->
        <footer class="p-3 bg-white border-top text-center text-muted small" style="font-size: 0.72rem;">
            &copy; <?= date('Y') ?> <strong>PACEKO.com</strong> Admin Portal • Framework CodeIgniter 4 • Waktu Server: <?= date('d M Y H:i') ?> WITA
        </footer>
    </div>
</div>

<!-- Floating Mobile Menu Button (Bottom-Right, thumb-friendly) -->
<button class="btn btn-danger rounded-circle shadow-lg d-lg-none position-fixed d-flex align-items-center justify-content-center" 
        style="bottom: 22px; right: 22px; width: 48px; height: 48px; z-index: 1040; box-shadow: 0 4px 18px rgba(229, 9, 20, 0.5) !important;" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#adminMobileSidebar" 
        aria-controls="adminMobileSidebar" 
        title="Buka Menu Admin">
    <i class="fa-solid fa-bars fs-5 text-white"></i>
</button>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Summernote Lite JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
    // Ensure mobile offcanvas opens smoothly on all devices
    $(document).ready(function() {
        $('[data-bs-target="#adminMobileSidebar"]').on('click', function(e) {
            var el = document.getElementById('adminMobileSidebar');
            if (el && typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
                var bsOff = bootstrap.Offcanvas.getInstance(el) || new bootstrap.Offcanvas(el);
                bsOff.show();
            }
        });
    });

    function confirmDelete(url, title = 'Apakah Anda yakin ingin menghapus data ini?') {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E50914',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>

