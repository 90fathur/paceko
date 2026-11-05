-- ========================================================
-- TABEL TAMBAHAN PORTAL BERITA PACEKO.COM (CodeIgniter 4)
-- Jalankan query ini di phpMyAdmin pada database: dpobtoro_paccekoku
-- ========================================================

-- 1. Tabel Pengaturan Website (Logo, Favicon, Judul, SEO, dll.)
CREATE TABLE IF NOT EXISTS `paceko_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext COLLATE utf8mb4_unicode_ci,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paceko_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'site_title', 'PACEKO.com', NOW()),
(2, 'site_tagline', 'Media Informasi, Inspirasi dan Inovatif Terdepan Sulbar', NOW()),
(3, 'site_logo', 'assets/images/logo.png', NOW()),
(4, 'site_favicon', 'assets/images/logo.png', NOW()),
(5, 'site_description', 'Portal Berita dan Media Informasi Terdepan Sulawesi Barat', NOW()),
(6, 'site_keywords', 'berita sulbar, paceko, polewali mandar, majene, mamuju, info sulbar', NOW()),
(7, 'office_address', 'Jl. Poros Polewali - Majene, Polewali Mandar, Sulawesi Barat', NOW()),
(8, 'contact_email', 'redaksi@paceko.com', NOW()),
(9, 'contact_phone', '+62 821-9999-0000', NOW()),
(10, 'social_facebook', 'https://facebook.com', NOW()),
(11, 'social_twitter', 'https://twitter.com', NOW()),
(12, 'social_instagram', 'https://instagram.com', NOW()),
(13, 'social_youtube', 'https://youtube.com', NOW()),
(14, 'social_whatsapp', 'https://wa.me/6282199990000', NOW()),
(15, 'running_text_extra', 'SELAMAT DATANG DI PORTAL RESMI PACEKO.COM VERSI BARU BERBASIS CODEIGNITER 4', NOW()),
(16, 'footer_text', 'PACEKO.com adalah portal berita digital terdepan di Sulawesi Barat dan Nusantara. Menyajikan berita aktual, inspirasi kedaerahan, serta konten inovatif yang kredibel dan berimbang.', NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- 2. Tabel Banner Iklan & Sponsor
CREATE TABLE IF NOT EXISTS `paceko_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sidebar',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '#',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paceko_banners` (`id`, `title`, `position`, `image_url`, `target_url`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 'Bank Sulbar - Mitra Pembangunan Daerah Sulawesi Barat', 'header', 'uploads/banners/dummy_header_728x90.svg', 'https://paceko.com/kontak', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW()),
(2, 'Pemerintah Provinsi Sulawesi Barat - Menuju Sulbar Malaqbi & Maju', 'home_top', 'uploads/banners/dummy_billboard_970x250.svg', 'https://sulbarprov.go.id', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW()),
(3, 'PACEKO ADS Promo - Pasang Iklan & Promosikan Brand Anda', 'home_middle', 'uploads/banners/dummy_homemiddle_970x250.svg', 'https://paceko.com/kontak', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW()),
(4, 'Kopi Arabika Mamasa - 100% Organik Khas Pegunungan Sulbar', 'sidebar', 'uploads/banners/dummy_sidebar_300x250.svg', 'https://paceko.com/kontak', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW()),
(5, 'Universitas Sulawesi Barat (UNSULBAR) - PMB TA 2026/2027', 'sidebar_bottom', 'uploads/banners/dummy_sidebar_300x600.svg', 'https://unsulbar.ac.id', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW()),
(6, 'Telkomsel 5G Sulbar - Jaringan Internet Super Cepat & Kuota Melimpah', 'in_article', 'uploads/banners/dummy_inarticle_728x90.svg', 'https://telkomsel.com', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW()),
(7, 'Pesona Wisata Mandar - Eksplorasi Budaya & Keindahan Bahari Polman', 'after_article', 'uploads/banners/dummy_afterarticle_728x90.svg', 'https://paceko.com/kategori/wisata', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW()),
(8, 'Slot Iklan Usaha & Sponsor PACEKO.com - Hubungi Redaksi Sekarang', 'footer', 'uploads/banners/dummy_footer_970x90.svg', 'https://paceko.com/kontak', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'active', NOW())
ON DUPLICATE KEY UPDATE `status` = 'active';

-- 3. Tabel Pesan Masuk / Pengaduan Pembaca
CREATE TABLE IF NOT EXISTS `paceko_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel Menu Navigasi Dinamis & Dropdown
CREATE TABLE IF NOT EXISTS `paceko_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order_num` int(11) NOT NULL DEFAULT '0',
  `target` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paceko_menus` (`id`, `title`, `url`, `parent_id`, `order_num`, `target`, `is_active`, `created_at`) VALUES
(1, 'Home', '/', 0, 1, '_self', 1, NOW()),
(2, 'Sosial', '/kategori/sosial', 0, 2, '_self', 1, NOW()),
(3, 'Peristiwa', '/kategori/peristiwa', 0, 3, '_self', 1, NOW()),
(4, 'Pemerintahan', '/kategori/pemerintahan', 0, 4, '_self', 1, NOW()),
(5, 'Polhukam', '/kategori/polhukam', 0, 5, '_self', 1, NOW()),
(6, 'Rubrik Khusus', '#', 0, 6, '_self', 1, NOW()),
(7, 'Informasi', '#', 0, 7, '_self', 1, NOW()),
(8, 'Kesehatan', '/kategori/kesehatan', 6, 1, '_self', 1, NOW()),
(9, 'Parlemen', '/kategori/parlemen', 6, 2, '_self', 1, NOW()),
(10, 'Pendidikan', '/kategori/pendidikan', 6, 3, '_self', 1, NOW()),
(11, 'Inspirasi', '/kategori/inspirasi', 6, 4, '_self', 1, NOW()),
(12, 'Politik', '/kategori/politik', 6, 5, '_self', 1, NOW()),
(13, 'Opini', '/kategori/opini', 6, 6, '_self', 1, NOW()),
(14, 'Wisata', '/kategori/wisata', 6, 7, '_self', 1, NOW()),
(15, 'Tentang Kami', '/tentang-kami', 7, 1, '_self', 1, NOW()),
(16, 'Susunan Redaksi', '/redaksi', 7, 2, '_self', 1, NOW()),
(17, 'Pedoman Media Siber', '/pedoman-media-siber', 7, 3, '_self', 1, NOW()),
(18, 'Info Pasang Iklan', '/halaman/tarif-iklan-paceko', 7, 4, '_self', 1, NOW()),
(19, 'Kontak Redaksi', '/kontak', 7, 5, '_self', 1, NOW())
ON DUPLICATE KEY UPDATE `is_active` = 1;
