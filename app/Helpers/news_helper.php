<?php

if (!function_exists('get_post_image')) {
    /**
     * Get image URL with fallback to dynamic branded placeholder
     */
    function get_post_image($post, $size = 'large'): string
    {
        $imagePath = '';

        if (is_array($post)) {
            $imagePath = $post['image_path'] ?? $post['file_path'] ?? $post['featured_image'] ?? '';
            $title = $post['post_title'] ?? 'PACEKO';
            $category = $post['category_name'] ?? 'Berita';
            $id = $post['ID'] ?? rand(1, 9999);
        } elseif (is_object($post)) {
            $imagePath = $post->image_path ?? $post->file_path ?? $post->featured_image ?? '';
            $title = $post->post_title ?? 'PACEKO';
            $category = $post->category_name ?? 'Berita';
            $id = $post->ID ?? rand(1, 9999);
        } else {
            $title = 'PACEKO.COM';
            $category = 'Berita';
            $id = 1;
        }

        // Clean path if full URL
        if (!empty($imagePath)) {
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                // If local host or relative
                if (strpos($imagePath, 'localhost') !== false || strpos($imagePath, 'paceko.com') !== false) {
                    $parsed = parse_url($imagePath, PHP_URL_PATH);
                    $imagePath = preg_replace('#^/+(paceko33/|paceko/)?(wp-content/uploads/)?#', '', $parsed);
                } else {
                    return $imagePath;
                }
            }

            // Check possible physical paths
            $candidates = [
                FCPATH . 'uploads/news/' . basename($imagePath),
                FCPATH . 'uploads/' . ltrim($imagePath, '/'),
                FCPATH . 'uploads/wp-content/uploads/' . ltrim($imagePath, '/'),
                FCPATH . 'wp-content/uploads/' . ltrim($imagePath, '/'),
                FCPATH . 'wordpress_lama/wp-content/uploads/' . ltrim($imagePath, '/'),
                FCPATH . 'backup_wp/wp-content/uploads/' . ltrim($imagePath, '/'),
                FCPATH . '../wordpress_lama/wp-content/uploads/' . ltrim($imagePath, '/'),
            ];

            foreach ($candidates as $cand) {
                if (file_exists($cand) && !is_dir($cand)) {
                    $rel = str_replace('\\', '/', substr($cand, strlen(FCPATH)));
                    return base_url($rel);
                }
            }
        }

        // Return elegant branded placeholder SVG generator
        return base_url('placeholder?title=' . urlencode(mb_substr($title, 0, 50)) . '&cat=' . urlencode($category) . '&id=' . $id);
    }
}

if (!function_exists('format_indo_date')) {
    function format_indo_date($datetime, bool $withTime = false): string
    {
        if (empty($datetime)) return '-';
        $timestamp = is_numeric($datetime) ? $datetime : strtotime($datetime);
        if (!$timestamp) return '-';

        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $dayName = $days[date('w', $timestamp)];
        $dayNum = date('j', $timestamp);
        $monthName = $months[(int)date('n', $timestamp)];
        $year = date('Y', $timestamp);

        $result = "{$dayName}, {$dayNum} {$monthName} {$year}";
        if ($withTime) {
            $time = date('H:i', $timestamp);
            $result .= " {$time} WITA";
        }
        return $result;
    }
}

if (!function_exists('time_ago_id')) {
    function time_ago_id($datetime): string
    {
        if (empty($datetime)) return '';
        $timestamp = is_numeric($datetime) ? $datetime : strtotime($datetime);
        if (!$timestamp) return '';

        $diff = time() - $timestamp;

        if ($diff < 60) {
            return 'Baru saja';
        } elseif ($diff < 3600) {
            $mins = max(1, floor($diff / 60));
            return $mins . ' menit yang lalu';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' jam yang lalu';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' hari yang lalu';
        } else {
            return date('d M Y', $timestamp);
        }
    }
}

if (!function_exists('clean_excerpt')) {
    function clean_excerpt($content, int $length = 130): string
    {
        if (empty($content)) return '';
        // Remove shortcodes
        $text = preg_replace('/\[.*?\]/', '', $content);
        // Strip HTML
        $text = strip_tags($text);
        // Replace multiple whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        if (mb_strlen($text) <= $length) {
            return $text;
        }

        return mb_substr($text, 0, $length) . '...';
    }
}

if (!function_exists('get_setting')) {
    function get_setting(string $key, $default = ''): string
    {
        static $settings = null;
        if ($settings === null) {
            $model = new \App\Models\SettingModel();
            $settings = $model->getAllSettings();
        }
        return (string)($settings[$key] ?? $default);
    }
}

if (!function_exists('get_navigation_menus')) {
    function get_navigation_menus(): array
    {
        static $menuTree = null;
        if ($menuTree === null) {
            $model = new \App\Models\MenuModel();
            $menuTree = $model->getMenuTree(true);
        }
        return $menuTree;
    }
}

if (!function_exists('get_banners')) {
    function get_banners(?string $position = null): array
    {
        $model = new \App\Models\BannerModel();
        return $model->getActiveBanners($position);
    }
}

if (!function_exists('render_banner')) {
    /**
     * Render banner dynamically by position with dimension guides and fallback placeholder
     * 
     * @param string $position (header, home_top, home_middle, sidebar, sidebar_bottom, in_article, after_article, footer)
     * @param array $options ['class' => '', 'show_placeholder' => true]
     * @return string HTML output
     */
    function render_banner(string $position, array $options = []): string
    {
        $banners = get_banners($position);
        $showPlaceholder = $options['show_placeholder'] ?? true;
        $extraClass = $options['class'] ?? '';

        // Standard dimension guides
        $specs = [
            'header'         => ['width' => 728, 'height' => 90,  'label' => '728 × 90 px (Leaderboard)',          'min_h' => 70],
            'home_top'       => ['width' => 970, 'height' => 250, 'label' => '970 × 250 px (Top Billboard)',        'min_h' => 120],
            'home_middle'    => ['width' => 970, 'height' => 250, 'label' => '970 × 250 px / 728 × 90 px',          'min_h' => 120],
            'sidebar'        => ['width' => 300, 'height' => 250, 'label' => '300 × 250 px (Medium Rectangle)',     'min_h' => 180],
            'sidebar_bottom' => ['width' => 300, 'height' => 600, 'label' => '300 × 600 px (Half Page Skyscraper)', 'min_h' => 280],
            'in_article'     => ['width' => 728, 'height' => 90,  'label' => '728 × 90 px (In-Article)',            'min_h' => 80],
            'after_article'  => ['width' => 728, 'height' => 90,  'label' => '728 × 90 px (After-Article)',         'min_h' => 80],
            'footer'         => ['width' => 970, 'height' => 90,  'label' => '970 × 90 px (Footer Leaderboard)',    'min_h' => 80],
        ];

        $spec = $specs[$position] ?? ['width' => 728, 'height' => 90, 'label' => 'Banner Iklan (' . $position . ')', 'min_h' => 80];

        // 1. If active banner exists in database, render it
        if (!empty($banners)) {
            $b = $banners[0];
            $target = !empty($b['target_url']) ? esc($b['target_url']) : '#';
            $title = esc($b['title']);
            $imgUrl = base_url($b['image_url']);

            $html = '<div class="paceko-ad-slot paceko-ad-' . esc($position) . ' ' . esc($extraClass) . ' my-3 text-center">';
            $html .= '<div class="d-flex align-items-center justify-content-between mb-1 px-1">';
            $html .= '<span class="text-uppercase text-muted" style="font-size: 0.65rem; letter-spacing: 0.05em;"><i class="fa-solid fa-rectangle-ad text-danger me-1"></i> Iklan Sponsor</span>';
            $html .= '<span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.6rem;">' . esc($spec['label']) . '</span>';
            $html .= '</div>';
            $html .= '<a href="' . $target . '" target="_blank" rel="noopener sponsored" title="' . $title . '" class="d-inline-block w-100 shadow-sm rounded overflow-hidden ad-banner-link">';
            $html .= '<img src="' . $imgUrl . '" alt="' . $title . '" class="img-fluid w-100 h-auto rounded border" style="max-height:' . $spec['height'] . 'px; object-fit: contain;">';
            $html .= '</a>';
            $html .= '</div>';
            return $html;
        }

        // 2. If no active banner, render interactive vacancy placeholder
        if ($showPlaceholder) {
            $contactUrl = base_url('kontak');
            $html = '<div class="paceko-ad-slot paceko-ad-placeholder paceko-ad-' . esc($position) . ' ' . esc($extraClass) . ' my-3 text-center">';
            $html .= '<div class="d-flex align-items-center justify-content-between mb-1 px-1">';
            $html .= '<span class="text-uppercase text-danger fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05em;"><i class="fa-solid fa-bullhorn me-1"></i> Slot Iklan Tersedia</span>';
            $html .= '<span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.6rem;">' . esc($spec['label']) . '</span>';
            $html .= '</div>';
            
            $html .= '<a href="' . $contactUrl . '" class="ad-placeholder-box d-flex flex-column align-items-center justify-content-center p-3 text-decoration-none rounded-3 border border-2 border-dashed" style="min-height: ' . $spec['min_h'] . 'px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">';
            $html .= '<div class="d-flex align-items-center gap-2 mb-1 flex-wrap justify-content-center">';
            $html .= '<i class="fa-solid fa-rectangle-ad text-danger fs-5"></i>';
            $html .= '<span class="fw-bold text-dark small">Pasang Iklan / Banner di Sini</span>';
            $html .= '<span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.65rem;">' . esc($spec['label']) . '</span>';
            $html .= '</div>';
            $html .= '<p class="text-muted small mb-2" style="font-size: 0.75rem;">Jangkau puluhan ribu pembaca setia PACEKO.com. Klik di sini untuk info pasang iklan &amp; tarif sponsorship.</p>';
            $html .= '<span class="btn btn-outline-danger btn-sm py-0 px-3 fw-semibold" style="font-size: 0.72rem;"><i class="fa-solid fa-envelope me-1"></i> Hubungi Redaksi</span>';
            $html .= '</a>';
            $html .= '</div>';
            return $html;
        }

        return '';
    }
}

if (!function_exists('reading_time')) {
    function reading_time($content): string
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200);
        return max(1, $minutes) . ' menit baca';
    }
}

