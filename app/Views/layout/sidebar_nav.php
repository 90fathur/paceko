<ul class="sidebar-menu">
    <li class="sidebar-header">Utama</li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>
    </li>

    <li class="sidebar-header">Manajemen Konten</li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/news') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'news' ? 'active' : '' ?>">
            <i class="fa-solid fa-newspaper"></i> Kelola Berita
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/news/create') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'news_create' ? 'active' : '' ?>">
            <i class="fa-solid fa-pen-to-square"></i> Tulis Berita
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/categories') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'categories' ? 'active' : '' ?>">
            <i class="fa-solid fa-tags"></i> Kategori Berita
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/menus') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'menus' ? 'active' : '' ?>">
            <i class="fa-solid fa-bars-staggered"></i> Menu & Dropdown
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/pages') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'pages' ? 'active' : '' ?>">
            <i class="fa-solid fa-file-lines"></i> Kelola Halaman
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/banners') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'banners' ? 'active' : '' ?>">
            <i class="fa-solid fa-rectangle-ad"></i> Banner Iklan
        </a>
    </li>

    <li class="sidebar-header">Interaksi & Redaksi</li>
    <li class="sidebar-item">
        <?php 
        $unreadCount = (new \App\Models\MessageModel())->getUnreadCount();
        ?>
        <a href="<?= base_url('admin/messages') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'messages' ? 'active' : '' ?>">
            <i class="fa-solid fa-envelope"></i> Pesan Masuk
            <?php if ($unreadCount > 0): ?>
                <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 0.65rem;"><?= $unreadCount ?></span>
            <?php endif; ?>
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/users') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'users' ? 'active' : '' ?>">
            <i class="fa-solid fa-users"></i> Wartawan / Pengguna
        </a>
    </li>

    <li class="sidebar-header">Pengaturan</li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/settings') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'settings' ? 'active' : '' ?>">
            <i class="fa-solid fa-sliders"></i> Pengaturan & Logo
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url('admin/profile') ?>" class="sidebar-link <?= ($activeMenu ?? '') === 'profile' ? 'active' : '' ?>">
            <i class="fa-solid fa-key"></i> Profil & Password
        </a>
    </li>
    <li class="sidebar-item">
        <a href="<?= base_url() ?>" target="_blank" class="sidebar-link text-warning">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Website
        </a>
    </li>
    <li class="sidebar-item mt-3">
        <a href="<?= base_url('admin/logout') ?>" class="sidebar-link text-danger">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </li>
</ul>
