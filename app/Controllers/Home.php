<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\PageModel;
use App\Models\MessageModel;

class Home extends BaseController
{
    protected $postModel;
    protected $categoryModel;
    protected $pageModel;
    protected $messageModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->pageModel = new PageModel();
        $this->messageModel = new MessageModel();
    }

    /**
     * Portal Homepage
     */
    public function index()
    {
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sliderPosts    = $this->postModel->getSliderPosts(5);
        $breakingNews   = $this->postModel->getBreakingNews(10);
        $popularPosts   = $this->postModel->getPopularPosts(5);
        $latestPosts    = $this->postModel->getLatestPosts($limit, $offset);
        $navCategories  = $this->categoryModel->getTopCategories(9);
        $allCategories  = $this->categoryModel->getAllCategories();

        // Highlight category sections
        $pemerintahanNews = $this->postModel->getPostsByCategory('pemerintahan', 4);
        $peristiwaNews    = $this->postModel->getPostsByCategory('peristiwa', 4);
        $polhukamNews     = $this->postModel->getPostsByCategory('polhukam', 4);
        $inspirasiNews    = $this->postModel->getPostsByCategory('inspirasi', 4);

        $totalLatest = $this->postModel->where('post_type', 'post')->where('post_status', 'publish')->countAllResults();
        $totalPages = ceil($totalLatest / $limit);

        $data = [
            'title'            => get_setting('site_title', 'PACEKO.com') . ' - ' . get_setting('site_tagline', 'Media Informasi, Inspirasi dan Inovatif'),
            'metaDescription'  => get_setting('site_description', 'Portal berita terdepan menyajikan berita terkini, peristiwa, sosial, politik, pemerintahan, dan inspirasi.'),
            'ogTitle'          => get_setting('site_title', 'PACEKO.com') . ' - ' . get_setting('site_tagline', 'Media Informasi, Inspirasi dan Inovatif'),
            'ogDescription'    => get_setting('site_description', 'Portal berita terdepan menyajikan berita terkini, peristiwa, sosial, politik, pemerintahan, dan inspirasi.'),
            'ogImage'          => base_url('assets/images/og-default.jpg'),
            'ogType'           => 'website',
            'ogUrl'            => base_url(),
            'sliderPosts'      => $sliderPosts,
            'breakingNews'     => $breakingNews,
            'popularPosts'     => $popularPosts,
            'latestPosts'      => $latestPosts,
            'navCategories'    => $navCategories,
            'allCategories'    => $allCategories,
            'pemerintahanNews' => $pemerintahanNews,
            'peristiwaNews'    => $peristiwaNews,
            'polhukamNews'     => $polhukamNews,
            'inspirasiNews'    => $inspirasiNews,
            'currentPage'      => $page,
            'totalPages'       => $totalPages,
            'baseUrlPagination'=> base_url()
        ];

        return view('home/index', $data);
    }

    /**
     * Article Detail Page
     */
    public function detail($slug = null)
    {
        if (empty($slug)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Berita tidak ditemukan');
        }

        $post = $this->postModel->getPostBySlug($slug);
        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Berita tidak ditemukan: ' . $slug);
        }

        // Increment Views
        $this->postModel->incrementViews((int)$post['ID']);
        $post['views'] = ((int)$post['views']) + 1;

        $relatedPosts   = $this->postModel->getRelatedPosts((int)$post['ID'], (int)($post['category_id'] ?? null), 4);
        $popularPosts   = $this->postModel->getPopularPosts(5);
        $breakingNews   = $this->postModel->getBreakingNews(8);
        $navCategories  = $this->categoryModel->getTopCategories(9);
        $allCategories  = $this->categoryModel->getAllCategories();

        $postImage = get_og_image($post);
        
        // Robust Multi-tier Clean Description (Immune to MS Word CSS/XML garbage & empty excerpts)
        $cleanDesc = '';
        if (!empty($post['seo_description'])) {
            $cleanDesc = clean_excerpt($post['seo_description'], 160);
        }
        if (empty($cleanDesc) && !empty($post['post_excerpt'])) {
            $cleanDesc = clean_excerpt($post['post_excerpt'], 160);
        }
        if (empty($cleanDesc) && !empty($post['post_content'])) {
            $cleanDesc = clean_excerpt($post['post_content'], 160);
        }
        if (empty($cleanDesc)) {
            $cleanDesc = 'Baca ulasan berita selengkapnya mengenai ' . strip_tags($post['post_title']) . ' di PACEKO.com - Portal Berita Inspiratif dan Terpercaya.';
        }

        $seoTitle = !empty($post['seo_title']) ? trim($post['seo_title']) : $post['post_title'];
        $metaKeywords = !empty($post['seo_keywords']) ? trim($post['seo_keywords']) : (!empty($post['tags']) ? trim($post['tags']) : null);

        $data = [
            'title'           => esc($seoTitle) . ' - ' . get_setting('site_title', 'PACEKO.com'),
            'metaDescription' => esc($cleanDesc),
            'metaKeywords'    => $metaKeywords,
            'ogTitle'         => esc($seoTitle),
            'ogDescription'   => esc($cleanDesc),
            'ogImage'         => $postImage,
            'ogType'          => 'article',
            'ogUrl'           => current_url(),
            'publishedTime'   => $post['post_date'],
            'modifiedTime'    => $post['post_modified'] ?? $post['post_date'],
            'author'          => $post['author_name'] ?? 'Redaksi PACEKO',
            'section'         => $post['category_name'] ?? 'Berita',
            'post'            => $post,
            'relatedPosts'    => $relatedPosts,
            'popularPosts'    => $popularPosts,
            'breakingNews'    => $breakingNews,
            'navCategories'   => $navCategories,
            'allCategories'   => $allCategories,
        ];

        return view('news/detail', $data);
    }

    /**
     * Category Archive Page
     */
    public function category($slug = null)
    {
        if (empty($slug)) {
            return redirect()->to('/');
        }

        $category = $this->categoryModel->getCategoryBySlug($slug);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan: ' . $slug);
        }

        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $posts = $this->postModel->getPostsByCategory($slug, $limit, $offset);
        $totalPosts = $this->postModel->countPostsByCategory($slug);
        $totalPages = ceil($totalPosts / $limit);

        $popularPosts   = $this->postModel->getPopularPosts(5);
        $breakingNews   = $this->postModel->getBreakingNews(8);
        $navCategories  = $this->categoryModel->getTopCategories(9);
        $allCategories  = $this->categoryModel->getAllCategories();

        $catImage = !empty($posts[0]) ? get_og_image($posts[0]) : base_url('assets/images/og-default.jpg');
        $catDesc = 'Kumpulan berita terkini seputar ' . esc($category['name']) . ' di ' . get_setting('site_title', 'PACEKO.com');

        $data = [
            'title'           => 'Berita Kategori ' . esc($category['name']) . ' - ' . get_setting('site_title', 'PACEKO.com'),
            'metaDescription' => $catDesc,
            'ogTitle'         => 'Berita ' . esc($category['name']) . ' - ' . get_setting('site_title', 'PACEKO.com'),
            'ogDescription'   => $catDesc,
            'ogImage'         => $catImage,
            'ogType'          => 'website',
            'ogUrl'           => current_url(),
            'category'        => $category,
            'posts'           => $posts,
            'currentPage'     => $page,
            'totalPages'      => $totalPages,
            'totalPosts'      => $totalPosts,
            'popularPosts'    => $popularPosts,
            'breakingNews'    => $breakingNews,
            'navCategories'   => $navCategories,
            'allCategories'   => $allCategories,
            'baseUrlPagination'=> base_url('kategori/' . $slug)
        ];

        return view('news/category', $data);
    }

    /**
     * Search Results Page
     */
    public function search()
    {
        $keyword = trim((string)$this->request->getGet('q'));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $posts = [];
        $totalPosts = 0;
        $totalPages = 0;

        if (!empty($keyword)) {
            $posts = $this->postModel->searchPosts($keyword, $limit, $offset);
            $totalPosts = $this->postModel->countSearchResults($keyword);
            $totalPages = ceil($totalPosts / $limit);
        }

        $popularPosts   = $this->postModel->getPopularPosts(5);
        $breakingNews   = $this->postModel->getBreakingNews(8);
        $navCategories  = $this->categoryModel->getTopCategories(9);
        $allCategories  = $this->categoryModel->getAllCategories();

        $data = [
            'title'           => 'Hasil Pencarian: "' . esc($keyword) . '" - ' . get_setting('site_title', 'PACEKO.com'),
            'metaDescription' => 'Hasil pencarian berita untuk kata kunci ' . esc($keyword),
            'ogTitle'         => 'Pencarian: ' . esc($keyword) . ' - ' . get_setting('site_title', 'PACEKO.com'),
            'ogDescription'   => 'Hasil pencarian berita untuk kata kunci ' . esc($keyword),
            'ogImage'         => base_url('assets/images/og-default.jpg'),
            'ogType'          => 'website',
            'ogUrl'           => current_url(),
            'keyword'         => $keyword,
            'posts'           => $posts,
            'currentPage'     => $page,
            'totalPages'      => $totalPages,
            'totalPosts'      => $totalPosts,
            'popularPosts'    => $popularPosts,
            'breakingNews'    => $breakingNews,
            'navCategories'   => $navCategories,
            'allCategories'   => $allCategories,
            'baseUrlPagination'=> base_url('cari?q=' . urlencode($keyword))
        ];

        return view('news/search', $data);
    }

    /**
     * Dynamic Branded SVG Placeholder Generator
     */
    public function placeholder()
    {
        $title = $this->request->getGet('title') ?? 'PACEKO';
        $category = $this->request->getGet('cat') ?? 'Berita Terkini';
        $id = (int)($this->request->getGet('id') ?? 1);

        $gradients = [
            ['#0f172a', '#1e293b', '#dc2626'],
            ['#1e1b4b', '#312e81', '#4338ca'],
            ['#1c1917', '#292524', '#78350f'],
            ['#064e3b', '#065f46', '#047857'],
            ['#1e293b', '#334155', '#e11d48'],
            ['#3b0764', '#581c87', '#7e22ce']
        ];
        $grad = $gradients[$id % count($gradients)];

        $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500" width="100%" height="100%">
  <defs>
    <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="' . $grad[0] . '" />
      <stop offset="70%" stop-color="' . $grad[1] . '" />
      <stop offset="100%" stop-color="' . $grad[2] . '" />
    </linearGradient>
    <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse">
      <path d="M 40 0 L 0 40 M 0 0 L 40 40" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/>
    </pattern>
  </defs>
  
  <rect width="800" height="500" fill="url(#bgGrad)" />
  <rect width="800" height="500" fill="url(#pattern)" />
  
  <circle cx="700" cy="400" r="180" fill="rgba(220,38,38,0.12)" />
  <circle cx="700" cy="400" r="120" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="20" />

  <g transform="translate(60, 60)">
    <circle cx="36" cy="36" r="32" fill="#E50914" />
    <circle cx="36" cy="36" r="16" fill="' . $grad[0] . '" />
    <circle cx="36" cy="36" r="8" fill="#FFFFFF" />
    <text x="80" y="44" font-family="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif" font-weight="900" font-size="28" fill="#FFFFFF" letter-spacing="1">PACEKO<tspan fill="#E50914">.COM</tspan></text>
  </g>

  <g transform="translate(60, 240)">
    <rect width="auto" height="34" rx="6" fill="#E50914" />
    <text x="16" y="23" font-family="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif" font-weight="700" font-size="14" fill="#FFFFFF" letter-spacing="1">' . htmlspecialchars(strtoupper($category), ENT_QUOTES, 'UTF-8') . '</text>
  </g>

  <text x="60" y="320" font-family="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif" font-weight="700" font-size="24" fill="#FFFFFF">
    ' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '
  </text>
  
  <text x="60" y="420" font-family="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif" font-weight="400" font-size="14" fill="rgba(255,255,255,0.6)">
    Media Informasi, Inspirasi dan Inovatif
  </text>
</svg>';

        return $this->response
            ->setHeader('Content-Type', 'image/svg+xml')
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody($svg);
    }

    /**
     * Dynamic Static Page Viewer (from database wp_posts post_type = 'page')
     */
    public function page($slug = null)
    {
        if (empty($slug)) {
            return redirect()->to('/');
        }

        $page = $this->pageModel->getPageBySlug($slug);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman tidak ditemukan: ' . $slug);
        }

        $navCategories = $this->categoryModel->getTopCategories(9);
        $allCategories = $this->categoryModel->getAllCategories();
        $breakingNews  = $this->postModel->getBreakingNews(8);

        $desc = clean_excerpt($page['post_content'], 160);
        $data = [
            'title'           => esc($page['post_title']) . ' - ' . get_setting('site_title', 'PACEKO.com'),
            'metaDescription' => esc($desc),
            'ogTitle'         => esc($page['post_title']) . ' - ' . get_setting('site_title', 'PACEKO.com'),
            'ogDescription'   => esc($desc),
            'ogImage'         => base_url('assets/images/og-default.jpg'),
            'ogType'          => 'article',
            'ogUrl'           => current_url(),
            'page'            => $page,
            'navCategories'   => $navCategories,
            'allCategories'   => $allCategories,
            'breakingNews'    => $breakingNews,
        ];

        return view('pages/dynamic', $data);
    }

    /**
     * Handle Contact Message Submission
     */
    public function sendMessage()
    {
        $rules = [
            'name'    => 'required|min_length[3]|max_length[150]',
            'email'   => 'required|valid_email',
            'subject' => 'required|min_length[3]|max_length[200]',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Mohon lengkapi semua isian formulir dengan benar.');
        }

        $data = [
            'name'       => trim((string)$this->request->getPost('name')),
            'email'      => trim((string)$this->request->getPost('email')),
            'phone'      => trim((string)$this->request->getPost('phone')),
            'subject'    => trim((string)$this->request->getPost('subject')),
            'message'    => trim((string)$this->request->getPost('message')),
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->messageModel->insert($data);

        return redirect()->to('/kontak')->with('success', 'Terima kasih! Pesan dan informasi Anda telah terkirim ke Redaksi PACEKO.com.');
    }

    /**
     * Static Pages (loads from DB PageModel if exists, else static view fallback)
     */
    public function about()
    {
        $dbPage = $this->pageModel->getPageBySlug('tentang-kami');
        if ($dbPage && !empty($dbPage['post_content'])) {
            return $this->page('tentang-kami');
        }

        $navCategories = $this->categoryModel->getTopCategories(9);
        $allCategories = $this->categoryModel->getAllCategories();
        $breakingNews  = $this->postModel->getBreakingNews(8);
        return view('pages/about', compact('navCategories', 'allCategories', 'breakingNews') + ['title' => 'Tentang Kami - PACEKO.com']);
    }

    public function redaksi()
    {
        $dbPage = $this->pageModel->getPageBySlug('redaksi');
        if ($dbPage && !empty($dbPage['post_content'])) {
            return $this->page('redaksi');
        }

        $navCategories = $this->categoryModel->getTopCategories(9);
        $allCategories = $this->categoryModel->getAllCategories();
        $breakingNews  = $this->postModel->getBreakingNews(8);
        return view('pages/redaksi', compact('navCategories', 'allCategories', 'breakingNews') + ['title' => 'Susunan Redaksi - PACEKO.com']);
    }

    public function pedoman()
    {
        $dbPage = $this->pageModel->getPageBySlug('pedoman-media-cyber') ?? $this->pageModel->getPageBySlug('pedoman-media-siber');
        if ($dbPage && !empty($dbPage['post_content'])) {
            return $this->page($dbPage['post_name']);
        }

        $navCategories = $this->categoryModel->getTopCategories(9);
        $allCategories = $this->categoryModel->getAllCategories();
        $breakingNews  = $this->postModel->getBreakingNews(8);
        return view('pages/pedoman', compact('navCategories', 'allCategories', 'breakingNews') + ['title' => 'Pedoman Media Siber - PACEKO.com']);
    }

    public function kontak()
    {
        $navCategories = $this->categoryModel->getTopCategories(9);
        $allCategories = $this->categoryModel->getAllCategories();
        $breakingNews  = $this->postModel->getBreakingNews(8);
        return view('pages/kontak', compact('navCategories', 'allCategories', 'breakingNews') + ['title' => 'Kontak & Informasi - PACEKO.com']);
    }

    /**
     * Dynamic media handler for legacy WordPress uploads
     * Catches and serves images whether wp-content is in public/ or outside
     */
    public function media(string ...$segments)
    {
        $path = implode('/', $segments);
        $path = str_replace(['../', '..\\'], '', $path);

        $candidates = [
            FCPATH . 'wp-content/uploads/' . $path,
            FCPATH . '../wp-content/uploads/' . $path,
            FCPATH . '../wordpress_lama/wp-content/uploads/' . $path,
            FCPATH . '../wp_lama/wp-content/uploads/' . $path,
            FCPATH . '../backup_wp/wp-content/uploads/' . $path,
            FCPATH . 'uploads/' . $path,
        ];

        foreach ($candidates as $cand) {
            if (file_exists($cand) && is_file($cand)) {
                $ext = strtolower(pathinfo($cand, PATHINFO_EXTENSION));
                $mimes = [
                    'jpg'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png'  => 'image/png',
                    'gif'  => 'image/gif',
                    'webp' => 'image/webp',
                    'svg'  => 'image/svg+xml',
                ];
                $mime = $mimes[$ext] ?? 'image/jpeg';

                return $this->response
                    ->setHeader('Content-Type', $mime)
                    ->setHeader('Cache-Control', 'public, max-age=2592000')
                    ->setBody(file_get_contents($cand));
            }
        }

        // On localhost, proxy/redirect to live server if missing
        if (ENVIRONMENT !== 'production' || strpos(base_url(), 'localhost') !== false) {
            return redirect()->to('https://paceko.com/wp-content/uploads/' . $path);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Media tidak ditemukan');
    }
}
