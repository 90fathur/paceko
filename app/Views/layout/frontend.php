<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO & Metadata -->
    <title><?= esc($title ?? get_setting('site_title', 'PACEKO.com') . ' - ' . get_setting('site_tagline', 'Media Informasi, Inspirasi dan Inovatif')) ?></title>
    <meta name="description" content="<?= esc($metaDescription ?? get_setting('site_description', 'Portal Berita Terkini, Akurat, dan Terpercaya - PACEKO.com')) ?>">
    <meta name="keywords" content="<?= esc($metaKeywords ?? get_setting('site_keywords', 'paceko, berita sulbar, berita polman, berita polewali mandar sulawesi barat')) ?>">
    <meta name="author" content="<?= esc($author ?? get_setting('site_title', 'PACEKO.com')) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="<?= esc($ogUrl ?? current_url()) ?>">
    <link rel="icon" type="image/png" href="<?= base_url(get_setting('site_favicon', 'assets/images/logo.png')) ?>">

    <!-- Open Graph / Facebook / WhatsApp Rich Link Preview -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="<?= esc(get_setting('site_title', 'PACEKO.com')) ?>">
    <meta property="og:type" content="<?= esc($ogType ?? 'website') ?>">
    <meta property="og:url" content="<?= esc($ogUrl ?? current_url()) ?>">
    <meta property="og:title" content="<?= esc($ogTitle ?? $title ?? get_setting('site_title', 'PACEKO.com')) ?>">
    <meta property="og:description" content="<?= esc($ogDescription ?? $metaDescription ?? get_setting('site_description', 'Portal Berita Terkini, Akurat, dan Terpercaya - PACEKO.com')) ?>">
    <meta property="og:image" content="<?= esc($ogImage ?? base_url('assets/images/og-default.jpg')) ?>">
    <meta property="og:image:secure_url" content="<?= esc($ogImage ?? base_url('assets/images/og-default.jpg')) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?= esc($ogTitle ?? $title ?? 'PACEKO.com') ?>">
    <?php if (($ogType ?? 'website') === 'article'): ?>
        <?php if (!empty($publishedTime)): ?>
    <meta property="article:published_time" content="<?= esc(date('c', strtotime($publishedTime))) ?>">
        <?php endif; ?>
        <?php if (!empty($modifiedTime)): ?>
    <meta property="article:modified_time" content="<?= esc(date('c', strtotime($modifiedTime))) ?>">
        <?php endif; ?>
        <?php if (!empty($author)): ?>
    <meta property="article:author" content="<?= esc($author) ?>">
        <?php endif; ?>
        <?php if (!empty($section)): ?>
    <meta property="article:section" content="<?= esc($section) ?>">
        <?php endif; ?>
    <?php endif; ?>

    <!-- Twitter / X Card Preview -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= esc($ogUrl ?? current_url()) ?>">
    <meta name="twitter:title" content="<?= esc($ogTitle ?? $title ?? get_setting('site_title', 'PACEKO.com')) ?>">
    <meta name="twitter:description" content="<?= esc($ogDescription ?? $metaDescription ?? get_setting('site_description', 'Portal Berita Terkini, Akurat, dan Terpercaya - PACEKO.com')) ?>">
    <meta name="twitter:image" content="<?= esc($ogImage ?? base_url('assets/images/og-default.jpg')) ?>">

    <!-- Schema.org JSON-LD for Google, WhatsApp & Social Search -->
    <?php if (($ogType ?? 'website') === 'article' && !empty($post)): ?>
    <?php
    $schemaArticle = [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $ogUrl ?? current_url()
        ],
        'headline' => $post['post_title'],
        'image' => [
            $ogImage ?? base_url('assets/images/og-default.jpg')
        ],
        'datePublished' => date('c', strtotime($post['post_date'])),
        'dateModified' => date('c', strtotime($post['post_modified'] ?? $post['post_date'])),
        'author' => [[
            '@type' => 'Person',
            'name' => $post['author_name'] ?? 'Redaksi PACEKO'
        ]],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'PACEKO.COM',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => base_url('assets/images/logo.png')
            ]
        ],
        'description' => $ogDescription ?? ''
    ];
    ?>
    <script type="application/ld+json">
    <?= json_encode($schemaArticle, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>
    <?php else: ?>
    <?php
    $schemaWebsite = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'PACEKO.com',
        'url' => base_url(),
        'description' => get_setting('site_description', 'Media Informasi, Inspirasi dan Inovatif'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => base_url('cari?q={search_term_string}'),
            'query-input' => 'required name=search_term_string'
        ]
    ];
    ?>
    <script type="application/ld+json">
    <?= json_encode($schemaWebsite, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>
    <?php endif; ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800;900&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6.6.0 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <!-- Swiper 11 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --paceko-red: #E50914;
            --paceko-red-dark: #b80710;
            --paceko-red-light: #ff3843;
            --paceko-dark: #0f172a;
            --paceko-slate: #1e293b;
            --paceko-muted: #64748b;
            --paceko-bg: #f8fafc;
            --paceko-card: #ffffff;
            --paceko-border: #e2e8f0;
            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
            --font-reading: 'Merriweather', Georgia, serif;
        }

        [data-bs-theme="dark"] {
            --paceko-dark: #f8fafc;
            --paceko-slate: #cbd5e1;
            --paceko-muted: #94a3b8;
            --paceko-bg: #090d16;
            --paceko-card: #111827;
            --paceko-border: #1f2937;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .brand-bar,
        [data-bs-theme="dark"] .main-navbar,
        [data-bs-theme="dark"] .ticker-bar,
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .paceko-card,
        [data-bs-theme="dark"] .side-highlight-card,
        [data-bs-theme="dark"] article.bg-white,
        [data-bs-theme="dark"] .modal-content,
        [data-bs-theme="dark"] .offcanvas {
            background-color: #111827 !important;
            color: #e2e8f0 !important;
            border-color: #1f2937 !important;
        }
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2, [data-bs-theme="dark"] h3, [data-bs-theme="dark"] h4, [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6 {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .bg-light,
        [data-bs-theme="dark"] .trending-item,
        [data-bs-theme="dark"] .nav-category-link {
            background-color: #1a2234 !important;
            color: #cbd5e1 !important;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--paceko-bg);
            color: #1e293b;
            line-height: 1.6;
            overflow-x: hidden;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 700;
            color: var(--paceko-dark);
            letter-spacing: -0.02em;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        a:hover {
            color: var(--paceko-red);
        }

        /* Top Bar */
        .top-bar {
            background-color: #0b1120;
            color: #94a3b8;
            font-size: 0.8125rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 6px 0;
        }
        .top-bar a {
            color: #94a3b8;
        }
        .top-bar a:hover {
            color: #ffffff;
        }

        /* Brand Bar */
        .brand-bar {
            background-color: #ffffff;
            padding: 8px 0;
            border-bottom: 1px solid var(--paceko-border);
        }
        .brand-logo {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .brand-logo img {
            max-height: 46px;
            width: auto;
            object-fit: contain;
            transition: transform 0.2s ease;
        }
        .brand-logo:hover img {
            transform: scale(1.02);
        }
        .paceko-ad-header {
            margin: 0 !important;
        }
        .paceko-ad-header img {
            max-height: 68px !important;
            width: auto;
            object-fit: contain;
        }
        @media (max-width: 767.98px) {
            .brand-bar {
                padding: 6px 0;
            }
            .brand-logo img {
                max-height: 38px;
            }
        }

        /* Running Text Ticker */
        .ticker-bar {
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            border-bottom: 2px solid var(--paceko-red);
            padding: 6px 0;
            font-size: 0.85rem;
        }
        .ticker-badge {
            background-color: var(--paceko-red);
            color: #ffffff;
            font-weight: 800;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .ticker-pulse {
            width: 7px;
            height: 7px;
            background: #ffffff;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.4s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }
        .ticker-marquee {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }
        .ticker-content {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 35s linear infinite;
        }
        .ticker-content:hover {
            animation-play-state: paused;
        }
        @keyframes marquee {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }
        .ticker-item {
            margin-right: 28px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #334155;
            font-weight: 500;
        }
        .ticker-item:hover {
            color: var(--paceko-red);
        }

        /* Sticky Navigation Bar */
        .main-navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border-bottom: 1px solid var(--paceko-border);
            position: sticky;
            top: 0;
            z-index: 1020;
            backdrop-filter: blur(10px);
        }
        .nav-category-link {
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            padding: 12px 14px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            position: relative;
        }
        .nav-category-link:hover,
        .nav-category-link.active {
            color: var(--paceko-red);
        }
        .nav-category-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 14px;
            right: 14px;
            height: 3px;
            background-color: var(--paceko-red);
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }
        .nav-category-link:hover::after,
        .nav-category-link.active::after {
            transform: scaleX(1);
        }

        /* Dropdown Navigation Enhancement */
        @media (min-width: 992px) {
            .main-navbar .dropdown:hover > .dropdown-menu {
                display: block;
                margin-top: 0;
                animation: navFadeIn 0.2s ease-in-out;
            }
        }
        @keyframes navFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .main-navbar .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important;
            border: 1px solid rgba(0,0,0,0.06) !important;
            min-width: 210px;
        }
        .main-navbar .dropdown-item {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.15s ease;
        }
        .main-navbar .dropdown-item:hover {
            background-color: rgba(229, 9, 20, 0.08);
            color: var(--paceko-red);
            padding-left: 20px;
        }

        /* Ad Banner Slots & Placeholders */
        .paceko-ad-slot {
            position: relative;
        }
        .ad-banner-link {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: inline-block;
        }
        .ad-banner-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important;
        }
        .ad-placeholder-box {
            border-color: #cbd5e1 !important;
            transition: all 0.2s ease;
        }
        .ad-placeholder-box:hover {
            border-color: var(--paceko-red) !important;
            background: #fff1f2 !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(229, 9, 20, 0.08);
        }
        .ad-placeholder-box:hover .btn-outline-danger {
            background-color: var(--paceko-red);
            color: #ffffff;
        }

        /* Card Designs */
        .paceko-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--paceko-border);
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .paceko-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -10px rgba(0,0,0,0.1);
            border-color: #cbd5e1;
        }

        .category-pill {
            display: inline-block;
            background: rgba(229, 9, 20, 0.1);
            color: var(--paceko-red);
            font-weight: 700;
            font-size: 0.72rem;
            padding: 3px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .category-pill:hover {
            background: var(--paceko-red);
            color: #ffffff;
        }

        /* Section Headings */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }
        .section-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 70px;
            height: 2px;
            background-color: var(--paceko-red);
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title i {
            color: var(--paceko-red);
        }

        /* Swiper Hero Slider */
        .hero-slider {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            height: 440px;
            position: relative;
        }
        .hero-slide {
            position: relative;
            height: 100%;
            background-color: var(--paceko-dark);
            overflow: hidden;
        }
        .hero-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .hero-slide:hover img {
            transform: scale(1.04);
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15,23,42,0.1) 0%, rgba(15,23,42,0.5) 50%, rgba(15,23,42,0.95) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 30px;
            color: #ffffff;
        }
        .hero-title {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1.25;
            color: #ffffff;
            margin: 10px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        .hero-title:hover {
            color: #ffcccc;
        }
        .hero-meta {
            font-size: 0.8125rem;
            color: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Side Highlights */
        .side-highlight-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 12px;
            border: 1px solid var(--paceko-border);
            display: flex;
            gap: 14px;
            align-items: center;
            transition: all 0.2s ease;
        }
        .side-highlight-card:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.06);
            transform: translateY(-2px);
            border-color: #cbd5e1;
        }
        .side-highlight-img {
            width: 110px;
            height: 85px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .side-highlight-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .side-highlight-title {
            font-size: 0.92rem;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Trending Numbers */
        .trending-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px dashed var(--paceko-border);
        }
        .trending-item:last-child {
            border-bottom: none;
        }
        .trending-num {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            font-weight: 900;
            color: #cbd5e1;
            line-height: 1;
            width: 32px;
            flex-shrink: 0;
            text-align: center;
        }
        .trending-item:nth-child(1) .trending-num { color: #E50914; }
        .trending-item:nth-child(2) .trending-num { color: #f97316; }
        .trending-item:nth-child(3) .trending-num { color: #eab308; }

        /* Article Reading Experience */
        .article-content {
            font-family: var(--font-reading);
            font-size: 1.1rem;
            line-height: 1.85;
            color: inherit;
        }
        .article-content p {
            margin-bottom: 1.5rem;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 20px 0;
        }
        .article-content blockquote {
            border-left: 4px solid var(--paceko-red);
            padding-left: 20px;
            margin: 24px 0;
            font-style: italic;
            color: var(--paceko-muted);
        }

        /* Share Buttons */
        .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #ffffff;
            font-size: 1rem;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .share-btn:hover {
            transform: scale(1.1);
            opacity: 0.9;
            color: #ffffff;
        }
        .share-wa { background-color: #25D366; }
        .share-fb { background-color: #1877F2; }
        .share-x  { background-color: #000000; }
        .share-tg { background-color: #229ED9; }
        .share-copy { background-color: #64748b; }

        /* Footer */
        .paceko-footer {
            background-color: #0b1120;
            color: #94a3b8;
            font-size: 0.875rem;
            border-top: 4px solid var(--paceko-red);
            padding-top: 50px;
            padding-bottom: 25px;
            margin-top: 60px;
        }
        .footer-heading {
            font-family: var(--font-heading);
            font-size: 1rem;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 8px;
        }
        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 2px;
            background: var(--paceko-red);
        }
        .footer-link {
            color: #94a3b8;
            display: block;
            margin-bottom: 8px;
            transition: color 0.2s ease;
        }
        .footer-link:hover {
            color: #ffffff;
            padding-left: 4px;
        }

        /* Back to top */
        #backToTop {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 44px;
            height: 44px;
            background: var(--paceko-red);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(229, 9, 20, 0.4);
            cursor: pointer;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        #backToTop.show {
            opacity: 1;
            visibility: visible;
        }

        /* Print Stylesheet */
        @media print {
            .top-bar, .brand-bar, .ticker-bar, .main-navbar, .paceko-footer, #backToTop, .share-btn, .btn, .breadcrumb, form {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
        }

        @media (max-width: 991.98px) {
            .hero-slider {
                height: 320px;
            }
            .hero-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>

    <!-- 1. Top Bar -->
    <div class="top-bar">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span><i class="fa-regular fa-calendar-days text-danger me-1"></i> <span id="currentDateIndo"><?= format_indo_date(date('Y-m-d')) ?></span></span>
                <span class="d-none d-md-inline text-muted">•</span>
                <span class="d-none d-md-inline"><i class="fa-regular fa-clock me-1 text-danger"></i> <span id="liveClock">00:00:00</span> WITA</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="<?= base_url('tentang-kami') ?>" class="d-none d-sm-inline">Tentang Kami</a>
                <a href="<?= base_url('redaksi') ?>" class="d-none d-sm-inline">Redaksi</a>
                <a href="<?= base_url('pedoman-media-siber') ?>" class="d-none d-sm-inline">Pedoman Siber</a>
                <a href="<?= base_url('kontak') ?>" class="d-none d-sm-inline">Kontak</a>
                <span class="text-muted d-none d-sm-inline">|</span>
                
                <!-- Social Links -->
                <div class="d-flex align-items-center gap-2">
                    <?php if ($fb = get_setting('social_facebook')): ?>
                        <a href="<?= esc($fb) ?>" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if ($tw = get_setting('social_twitter')): ?>
                        <a href="<?= esc($tw) ?>" target="_blank" title="Twitter/X"><i class="fa-brands fa-x-twitter"></i></a>
                    <?php endif; ?>
                    <?php if ($ig = get_setting('social_instagram')): ?>
                        <a href="<?= esc($ig) ?>" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ($yt = get_setting('social_youtube')): ?>
                        <a href="<?= esc($yt) ?>" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <?php endif; ?>
                </div>

                <!-- Theme Dark/Light Mode Switch -->
                <button id="themeToggleBtn" class="btn btn-sm btn-outline-secondary border-0 text-white py-0 px-2" style="font-size: 0.8rem;" title="Ubah Mode Gelap / Terang">
                    <i class="fa-solid fa-moon" id="themeIcon"></i>
                </button>

                <a href="<?= base_url('admin/login') ?>" class="badge bg-danger text-white py-1 px-2 text-uppercase" style="font-size: 0.7rem; text-decoration: none;">
                    <i class="fa-solid fa-lock me-1"></i> Admin
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Brand Header Bar with Header Banner Slot -->
    <header class="brand-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-auto col-md-auto col-8">
                    <a href="<?= base_url() ?>" class="brand-logo d-inline-flex align-items-center">
                        <img src="<?= base_url(get_setting('site_logo', 'assets/images/logo.png')) ?>" alt="<?= esc(get_setting('site_title', 'PACEKO.com')) ?>" class="img-fluid">
                    </a>
                </div>

                <!-- Header Banner (728x90 slot) -->
                <div class="col-lg col-md col-4 d-flex justify-content-end align-items-center gap-3">
                    <div class="d-none d-md-block flex-grow-1 text-end" style="max-width: 580px;">
                        <?= render_banner('header', ['class' => 'my-0 text-end']) ?>
                    </div>

                    <!-- Mobile Hamburger -->
                    <button class="btn btn-outline-danger d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. Running Text / Breaking News Ticker -->
    <?php if (!empty($breakingNews) || !empty(get_setting('running_text_extra'))): ?>
    <div class="ticker-bar">
        <div class="container d-flex align-items-center gap-3">
            <div class="ticker-badge">
                <span class="ticker-pulse"></span>
                <span>BREAKING NEWS</span>
            </div>
            <div class="ticker-marquee flex-grow-1">
                <div class="ticker-content">
                    <?php if ($extraTicker = get_setting('running_text_extra')): ?>
                        <span class="ticker-item text-danger fw-bold">
                            <i class="fa-solid fa-bullhorn text-warning"></i> <?= esc($extraTicker) ?>
                        </span>
                    <?php endif; ?>

                    <?php foreach ($breakingNews as $item): ?>
                        <a href="<?= base_url('berita/' . esc($item['slug'])) ?>" class="ticker-item">
                            <i class="fa-regular fa-newspaper text-danger"></i>
                            <span><?= esc($item['post_title']) ?></span>
                        </a>
                    <?php endforeach; ?>

                    <!-- Loop duplicate for seamless scroll -->
                    <?php foreach ($breakingNews as $item): ?>
                        <a href="<?= base_url('berita/' . esc($item['slug'])) ?>" class="ticker-item">
                            <i class="fa-regular fa-newspaper text-danger"></i>
                            <span><?= esc($item['post_title']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php
    $navMenus = get_navigation_menus();
    $formatNavUrl = function($url) {
        if (empty($url) || $url === '#') return '#';
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) return $url;
        return base_url(ltrim($url, '/'));
    };
    $isMenuCurrent = function($url) {
        $u = trim((string)$url, '/');
        $current = trim(uri_string(), '/');
        if (($u === '' || $u === '#') && $current === '') return ($u === '');
        return ($u !== '' && $u === $current);
    };
    ?>

    <!-- 4. Sticky Navigation Bar -->
    <nav class="main-navbar d-none d-lg-block">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center flex-wrap">
                <?php if (!empty($navMenus)): ?>
                    <?php foreach ($navMenus as $m): ?>
                        <?php if (!empty($m['children'])): 
                            $isParentActive = false;
                            foreach ($m['children'] as $c) {
                                if ($isMenuCurrent($c['url'])) {
                                    $isParentActive = true;
                                    break;
                                }
                            }
                        ?>
                            <div class="dropdown d-inline-block">
                                <a class="nav-category-link dropdown-toggle <?= $isParentActive ? 'active' : '' ?>" href="<?= esc($formatNavUrl($m['url'])) ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false" target="<?= esc($m['target'] ?? '_self') ?>">
                                    <?= esc($m['title']) ?>
                                </a>
                                <ul class="dropdown-menu shadow border-0 py-2">
                                    <?php foreach ($m['children'] as $child): ?>
                                        <li>
                                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 <?= $isMenuCurrent($child['url']) ? 'active fw-bold' : '' ?>" href="<?= esc($formatNavUrl($child['url'])) ?>" target="<?= esc($child['target'] ?? '_self') ?>">
                                                <i class="fa-solid fa-angle-right text-danger small"></i>
                                                <span><?= esc($child['title']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?= esc($formatNavUrl($m['url'])) ?>" target="<?= esc($m['target'] ?? '_self') ?>" class="nav-category-link <?= $isMenuCurrent($m['url']) ? 'active' : '' ?>">
                                <?php if ($m['title'] === 'Home' || $m['title'] === 'Beranda'): ?>
                                    <i class="fa-solid fa-house me-1"></i>
                                <?php endif; ?>
                                <?= esc($m['title']) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="<?= base_url() ?>" class="nav-category-link <?= (uri_string() === '' || uri_string() === '/') ? 'active' : '' ?>">
                        <i class="fa-solid fa-house me-1"></i> Home
                    </a>
                    <?php if (!empty($navCategories)): ?>
                        <?php foreach ($navCategories as $cat): ?>
                            <a href="<?= base_url('kategori/' . esc($cat['slug'])) ?>" class="nav-category-link <?= (uri_string() === 'kategori/' . $cat['slug']) ? 'active' : '' ?>">
                                <?= esc($cat['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div>
                <a href="#searchModal" data-bs-toggle="modal" class="text-secondary p-2" title="Cari Berita">
                    <i class="fa-solid fa-magnifying-glass fs-5"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- 5. Offcanvas Mobile Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <img src="<?= base_url(get_setting('site_logo', 'assets/images/logo.png')) ?>" alt="<?= esc(get_setting('site_title', 'PACEKO.com')) ?>" style="max-height: 40px;">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="<?= base_url('cari') ?>" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari berita...">
                    <button class="btn btn-danger" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <h6 class="text-uppercase text-danger fw-bold fs-7 mb-3">Menu Navigasi</h6>
            <div class="list-group list-group-flush mb-4">
                <?php if (!empty($navMenus)): ?>
                    <?php foreach ($navMenus as $idx => $m): ?>
                        <?php if (!empty($m['children'])): ?>
                            <div class="border-bottom">
                                <a class="d-flex justify-content-between align-items-center py-2 px-3 text-dark text-decoration-none fw-semibold" data-bs-toggle="collapse" href="#mobileSubmenu<?= $idx ?>" role="button" aria-expanded="false">
                                    <span><?= esc($m['title']) ?></span>
                                    <i class="fa-solid fa-chevron-down small text-muted"></i>
                                </a>
                                <div class="collapse ps-3 bg-light rounded my-1" id="mobileSubmenu<?= $idx ?>">
                                    <?php foreach ($m['children'] as $child): ?>
                                        <a href="<?= esc($formatNavUrl($child['url'])) ?>" class="d-block py-2 px-3 text-secondary text-decoration-none border-bottom border-light small" target="<?= esc($child['target'] ?? '_self') ?>">
                                            <i class="fa-solid fa-angle-right me-2 text-danger"></i><?= esc($child['title']) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?= esc($formatNavUrl($m['url'])) ?>" class="list-group-item list-group-item-action py-2 px-3 border-0 border-bottom text-dark fw-semibold" target="<?= esc($m['target'] ?? '_self') ?>">
                                <?php if ($m['title'] === 'Home' || $m['title'] === 'Beranda'): ?>
                                    <i class="fa-solid fa-house me-2 text-danger"></i>
                                <?php endif; ?>
                                <?= esc($m['title']) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="<?= base_url() ?>" class="list-group-item list-group-item-action py-2 px-3 border-0 border-bottom text-dark fw-semibold">
                        <i class="fa-solid fa-house me-2 text-danger"></i> Beranda
                    </a>
                <?php endif; ?>
            </div>
            <hr>
            <div class="mt-3">
                <a href="<?= base_url('admin/login') ?>" class="btn btn-outline-danger w-100">
                    <i class="fa-solid fa-lock me-1"></i> Login Redaksi Admin
                </a>
            </div>
        </div>
    </div>

    <!-- 6. Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Pencarian Berita PACEKO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="<?= base_url('cari') ?>" method="GET">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control rounded-start-pill" placeholder="Ketik kata kunci berita..." required autofocus>
                            <button class="btn btn-danger rounded-end-pill px-4" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Injection -->
    <main class="py-4">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer Leaderboard Banner (970x90) -->
    <div class="container my-3">
        <?= render_banner('footer', ['class' => 'my-0']) ?>
    </div>

    <!-- 7. Footer -->
    <footer class="paceko-footer">
        <div class="container">
            <div class="row g-4 mb-5">
                <!-- Col 1: About Brand -->
                <div class="col-lg-4 col-md-6">
                    <div class="mb-3">
                        <img src="<?= base_url(get_setting('site_logo', 'assets/images/logo.png')) ?>" alt="<?= esc(get_setting('site_title', 'PACEKO.com')) ?>" style="max-height: 48px; filter: brightness(0) invert(1);">
                    </div>
                    <p class="text-secondary small leading-relaxed">
                        <?= esc(get_setting('footer_text', 'PACEKO.com adalah portal berita dan media informasi digital terdepan di Sulawesi Barat dan Nusantara. Menyajikan berita aktual, inspirasi kedaerahan, serta konten inovatif yang kredibel dan berimbang.')) ?>
                    </p>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <?php if ($fb = get_setting('social_facebook')): ?>
                            <a href="<?= esc($fb) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-facebook-f text-white"></i></a>
                        <?php endif; ?>
                        <?php if ($tw = get_setting('social_twitter')): ?>
                            <a href="<?= esc($tw) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-x-twitter text-white"></i></a>
                        <?php endif; ?>
                        <?php if ($ig = get_setting('social_instagram')): ?>
                            <a href="<?= esc($ig) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-instagram text-white"></i></a>
                        <?php endif; ?>
                        <?php if ($yt = get_setting('social_youtube')): ?>
                            <a href="<?= esc($yt) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-youtube text-white"></i></a>
                        <?php endif; ?>
                        <?php if ($wa = get_setting('social_whatsapp')): ?>
                            <a href="<?= esc($wa) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fa-brands fa-whatsapp text-white"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2: Kategori Populer -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Kategori Populer</h6>
                    <div class="row g-2">
                        <?php if (!empty($navCategories)): ?>
                            <?php foreach ($navCategories as $cat): ?>
                                <div class="col-6">
                                    <a href="<?= base_url('kategori/' . esc($cat['slug'])) ?>" class="footer-link">
                                        <i class="fa-solid fa-angle-right me-1 text-danger"></i> <?= esc($cat['name']) ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 3: Informasi Redaksi -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-heading">Tentang Kami</h6>
                    <a href="<?= base_url('tentang-kami') ?>" class="footer-link"><i class="fa-solid fa-angle-right me-1 text-danger"></i> Profil Media</a>
                    <a href="<?= base_url('redaksi') ?>" class="footer-link"><i class="fa-solid fa-angle-right me-1 text-danger"></i> Susunan Redaksi</a>
                    <a href="<?= base_url('pedoman-media-siber') ?>" class="footer-link"><i class="fa-solid fa-angle-right me-1 text-danger"></i> Pedoman Media Siber</a>
                    <a href="<?= base_url('halaman/kebijakan-privasi') ?>" class="footer-link"><i class="fa-solid fa-angle-right me-1 text-danger"></i> Kebijakan Privasi</a>
                    <a href="<?= base_url('kontak') ?>" class="footer-link"><i class="fa-solid fa-angle-right me-1 text-danger"></i> Kontak Kami</a>
                </div>

                <!-- Col 4: Kontak Redaksi -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Kontak Redaksi</h6>
                    <p class="small text-secondary mb-2">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i> <?= esc(get_setting('office_address', 'Polewali Mandar, Sulawesi Barat, Indonesia')) ?>
                    </p>
                    <p class="small text-secondary mb-2">
                        <i class="fa-solid fa-envelope text-danger me-2"></i> <?= esc(get_setting('contact_email', 'redaksi@paceko.com')) ?>
                    </p>
                    <p class="small text-secondary mb-2">
                        <i class="fa-solid fa-phone text-danger me-2"></i> <?= esc(get_setting('contact_phone', '+62 821-8888-9999')) ?>
                    </p>
                    <div class="p-3 rounded bg-secondary bg-opacity-10 border border-secondary border-opacity-25 mt-3">
                        <span class="text-white fw-bold d-block small mb-1">Kirimkan Opini / Informasi:</span>
                        <a href="<?= base_url('kontak') ?>" class="text-danger small fw-bold">Klik di sini untuk kirim berita &rarr;</a>
                    </div>
                </div>
            </div>

            <hr class="border-secondary border-opacity-25">

            <div class="row align-items-center small text-secondary pt-2">
                <div class="col-md-6 text-center text-md-start">
                    &copy; <?= date('Y') ?> <strong><?= esc(get_setting('site_title', 'PACEKO.com')) ?></strong>. Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <span class="text-muted">Ditenagai oleh CodeIgniter 4 Framework</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <div id="backToTop" title="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up"></i>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Theme Dark/Light Mode Management
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        const htmlEl = document.documentElement;

        const savedTheme = localStorage.getItem('paceko_theme') || 'light';
        setTheme(savedTheme);

        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                const cur = htmlEl.getAttribute('data-bs-theme');
                const next = cur === 'dark' ? 'light' : 'dark';
                setTheme(next);
            });
        }

        function setTheme(theme) {
            htmlEl.setAttribute('data-bs-theme', theme);
            localStorage.setItem('paceko_theme', theme);
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }
        }

        // Live Clock
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour12: false });
            const clockEl = document.getElementById('liveClock');
            if (clockEl) clockEl.innerText = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Back to top
        const btt = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                btt.classList.add('show');
            } else {
                btt.classList.remove('show');
            }
        });
        btt.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
