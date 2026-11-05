<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">

    <!-- Top Billboard Banner (970x250) -->
    <div class="mb-4">
        <?= render_banner('home_top', ['class' => 'my-0']) ?>
    </div>

    <!-- 1. HERO SECTION: Carousel Slider + Side Highlights -->
    <section class="mb-5">
        <div class="row g-4">
            <!-- Left: Headline Carousel Slider -->
            <div class="col-lg-8">
                <?php if (!empty($sliderPosts)): ?>
                <div class="swiper hero-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ($sliderPosts as $slider): ?>
                            <div class="swiper-slide hero-slide">
                                <img src="<?= get_post_image($slider) ?>" alt="<?= esc($slider['post_title']) ?>" loading="lazy">
                                <div class="hero-overlay">
                                    <div>
                                        <a href="<?= base_url('kategori/' . esc($slider['category_slug'])) ?>" class="category-pill bg-danger text-white mb-2">
                                            <?= esc($slider['category_name']) ?>
                                        </a>
                                    </div>
                                    <h2 class="hero-title">
                                        <a href="<?= base_url('berita/' . esc($slider['slug'])) ?>">
                                            <?= esc($slider['post_title']) ?>
                                        </a>
                                    </h2>
                                    <div class="hero-meta">
                                        <span><i class="fa-regular fa-user text-danger me-1"></i> <?= esc($slider['author_name']) ?></span>
                                        <span><i class="fa-regular fa-clock text-danger me-1"></i> <?= time_ago_id($slider['post_date']) ?></span>
                                        <span><i class="fa-regular fa-eye text-danger me-1"></i> <?= number_format($slider['views']) ?> tayangan</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Swiper Controls -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next text-white"></div>
                    <div class="swiper-button-prev text-white"></div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right: Side Highlights (3 Cards) -->
            <div class="col-lg-4 d-flex flex-column justify-content-between gap-3">
                <div class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
                    <span class="fw-bold text-uppercase fs-7 text-danger"><i class="fa-solid fa-bolt me-1"></i> Sorotan Utama</span>
                    <span class="badge bg-danger-subtle text-danger">Update Cepat</span>
                </div>
                <?php 
                $sideHighlights = array_slice($latestPosts, 0, 3);
                foreach ($sideHighlights as $side): 
                ?>
                    <div class="side-highlight-card flex-grow-1">
                        <div class="side-highlight-img">
                            <img src="<?= get_post_image($side) ?>" alt="<?= esc($side['post_title']) ?>" loading="lazy">
                        </div>
                        <div class="flex-grow-1">
                            <a href="<?= base_url('kategori/' . esc($side['category_slug'])) ?>" class="category-pill mb-1">
                                <?= esc($side['category_name']) ?>
                            </a>
                            <h3 class="side-highlight-title">
                                <a href="<?= base_url('berita/' . esc($side['slug'])) ?>" class="text-dark">
                                    <?= esc($side['post_title']) ?>
                                </a>
                            </h3>
                            <div class="small text-muted" style="font-size: 0.75rem;">
                                <i class="fa-regular fa-clock me-1 text-danger"></i> <?= time_ago_id($side['post_date']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 2. TRENDING TOPICS / TERPOPULER STRIP -->
    <section class="mb-5 p-3 rounded-4 bg-white border shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-2 col-12 border-end-md mb-2 mb-md-0">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-4 text-danger"><i class="fa-solid fa-fire"></i></span>
                    <div>
                        <span class="fw-bold text-uppercase d-block lh-1 text-dark" style="font-size: 0.85rem;">Sedang</span>
                        <span class="fw-black text-danger text-uppercase lh-1" style="font-size: 1.1rem; font-family: var(--font-heading);">Trending</span>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-12">
                <div class="d-flex align-items-center gap-3 overflow-x-auto pb-1" style="white-space: nowrap;">
                    <?php 
                    $trendingStrip = array_slice($popularPosts, 0, 4);
                    $tRank = 1;
                    foreach ($trendingStrip as $trend): 
                    ?>
                        <a href="<?= base_url('berita/' . esc($trend['slug'])) ?>" class="d-inline-flex align-items-center gap-2 text-dark bg-light px-3 py-2 rounded-pill border text-truncate" style="max-width: 280px; font-size: 0.825rem;">
                            <span class="badge bg-danger rounded-circle"><?= $tRank++ ?></span>
                            <span class="text-truncate"><?= esc($trend['post_title']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. MAIN SECTION (2 COLUMNS: Stream 8 cols + Sidebar 4 cols) -->
    <div class="row g-4">
        <!-- Main Column (8 Cols) -->
        <div class="col-lg-8">

            <!-- Latest News Stream -->
            <div class="section-header">
                <h3 class="section-title"><i class="fa-solid fa-newspaper"></i> Berita Terkini</h3>
                <span class="text-muted small">Update langsung dari lapangan</span>
            </div>

            <div class="row g-4 mb-4">
                <?php foreach ($latestPosts as $news): ?>
                    <div class="col-md-6">
                        <article class="paceko-card h-100 d-flex flex-column">
                            <div class="position-relative" style="height: 200px; overflow: hidden;">
                                <img src="<?= get_post_image($news) ?>" alt="<?= esc($news['post_title']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                                <a href="<?= base_url('kategori/' . esc($news['category_slug'])) ?>" class="category-pill position-absolute top-0 start-0 m-3 shadow-sm bg-danger text-white">
                                    <?= esc($news['category_name']) ?>
                                </a>
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="d-flex align-items-center gap-3 text-muted small mb-2" style="font-size: 0.78rem;">
                                    <span><i class="fa-regular fa-clock text-danger me-1"></i> <?= time_ago_id($news['post_date']) ?></span>
                                    <span><i class="fa-regular fa-eye text-danger me-1"></i> <?= number_format($news['views']) ?> views</span>
                                </div>
                                <h4 class="fs-6 fw-bold mb-2 lh-base">
                                    <a href="<?= base_url('berita/' . esc($news['slug'])) ?>" class="text-dark">
                                        <?= esc($news['post_title']) ?>
                                    </a>
                                </h4>
                                <p class="text-secondary small mb-3 flex-grow-1" style="font-size: 0.83rem; line-height: 1.5;">
                                    <?= esc(clean_excerpt($news['post_content'], 110)) ?>
                                </p>
                                <div class="pt-2 border-top d-flex justify-content-between align-items-center text-muted small" style="font-size: 0.75rem;">
                                    <span>Oleh: <strong class="text-dark"><?= esc($news['author_name']) ?></strong></span>
                                    <a href="<?= base_url('berita/' . esc($news['slug'])) ?>" class="text-danger fw-semibold">Baca Selengkapnya &rarr;</a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav class="my-4 d-flex justify-content-center">
                    <ul class="pagination pagination-sm">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link text-danger" href="<?= base_url('?page=' . ($currentPage - 1)) ?>">&laquo; Sebelumnya</a>
                            </li>
                        <?php endif; ?>

                        <?php 
                        $start = max(1, $currentPage - 2);
                        $end   = min($totalPages, $currentPage + 2);
                        for ($i = $start; $i <= $end; $i++): 
                        ?>
                            <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                <a class="page-link <?= ($i === $currentPage) ? 'bg-danger border-danger text-white' : 'text-danger' ?>" href="<?= base_url('?page=' . $i) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link text-danger" href="<?= base_url('?page=' . ($currentPage + 1)) ?>">Berikutnya &raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>

            <!-- Antar Seksi Berita Banner (970x250) -->
            <div class="my-4">
                <?= render_banner('home_middle', ['class' => 'my-0']) ?>
            </div>

            <!-- CATEGORY SPOTLIGHT 1: Pemerintahan & Parlemen -->
            <?php if (!empty($pemerintahanNews)): ?>
            <div class="mt-5">
                <div class="section-header">
                    <h3 class="section-title"><i class="fa-solid fa-landmark"></i> Pemerintahan & Kebijakan</h3>
                    <a href="<?= base_url('kategori/pemerintahan') ?>" class="text-danger small fw-bold">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="row g-3">
                    <?php foreach ($pemerintahanNews as $item): ?>
                        <div class="col-md-6 col-12">
                            <div class="paceko-card p-3 d-flex gap-3 align-items-center h-100">
                                <div style="width: 100px; height: 80px; flex-shrink: 0; border-radius: 8px; overflow: hidden;">
                                    <img src="<?= get_post_image($item) ?>" alt="<?= esc($item['post_title']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                                </div>
                                <div>
                                    <div class="small text-muted mb-1" style="font-size: 0.72rem;">
                                        <i class="fa-regular fa-clock text-danger me-1"></i> <?= time_ago_id($item['post_date']) ?>
                                    </div>
                                    <h5 class="fs-7 fw-bold mb-0 lh-sm">
                                        <a href="<?= base_url('berita/' . esc($item['slug'])) ?>" class="text-dark">
                                            <?= esc($item['post_title']) ?>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- CATEGORY SPOTLIGHT 2: Inspirasi & Inovatif -->
            <?php if (!empty($inspirasiNews)): ?>
            <div class="mt-5">
                <div class="section-header">
                    <h3 class="section-title"><i class="fa-solid fa-lightbulb"></i> Inspirasi & Inovatif</h3>
                    <a href="<?= base_url('kategori/inspirasi') ?>" class="text-danger small fw-bold">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="row g-3">
                    <?php foreach ($inspirasiNews as $item): ?>
                        <div class="col-md-6 col-12">
                            <div class="paceko-card p-3 d-flex gap-3 align-items-center h-100">
                                <div style="width: 100px; height: 80px; flex-shrink: 0; border-radius: 8px; overflow: hidden;">
                                    <img src="<?= get_post_image($item) ?>" alt="<?= esc($item['post_title']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                                </div>
                                <div>
                                    <div class="small text-muted mb-1" style="font-size: 0.72rem;">
                                        <i class="fa-regular fa-clock text-danger me-1"></i> <?= time_ago_id($item['post_date']) ?>
                                    </div>
                                    <h5 class="fs-7 fw-bold mb-0 lh-sm">
                                        <a href="<?= base_url('berita/' . esc($item['slug'])) ?>" class="text-dark">
                                            <?= esc($item['post_title']) ?>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- Sidebar Column (4 Cols) -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 80px; z-index: 1000;">

                <!-- 1. Berita Terpopuler Widget -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3 border-0 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fs-6 fw-bold text-uppercase d-flex align-items-center gap-2">
                            <i class="fa-solid fa-trophy text-warning"></i> Berita Terpopuler
                        </h5>
                        <span class="badge bg-danger">Paling Banyak Dibaca</span>
                    </div>
                    <div class="card-body p-3 bg-white">
                        <?php 
                        $rank = 1;
                        foreach ($popularPosts as $pop): 
                        ?>
                            <div class="trending-item">
                                <div class="trending-num"><?= $rank++ ?></div>
                                <div class="flex-grow-1">
                                    <a href="<?= base_url('kategori/' . esc($pop['category_slug'])) ?>" class="category-pill mb-1">
                                        <?= esc($pop['category_name']) ?>
                                    </a>
                                    <h5 class="fs-7 fw-bold mb-1 lh-sm">
                                        <a href="<?= base_url('berita/' . esc($pop['slug'])) ?>" class="text-dark">
                                            <?= esc($pop['post_title']) ?>
                                        </a>
                                    </h5>
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        <i class="fa-regular fa-eye text-danger me-1"></i> <?= number_format($pop['views']) ?> pembaca
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Sidebar Banner Slot 1 (300x250) -->
                <?= render_banner('sidebar', ['class' => 'mb-4']) ?>

                <!-- 2. Kategori Pilihan Widget -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fs-6 fw-bold text-uppercase text-dark">
                            <i class="fa-solid fa-tags text-danger me-2"></i> Kategori Pilihan
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!empty($navCategories)): ?>
                                <?php foreach ($navCategories as $cat): ?>
                                    <a href="<?= base_url('kategori/' . esc($cat['slug'])) ?>" class="btn btn-sm btn-light border rounded-pill d-inline-flex align-items-center gap-2 py-1 px-3">
                                        <span><?= esc($cat['name']) ?></span>
                                        <span class="badge bg-danger rounded-pill"><?= number_format($cat['count']) ?></span>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- 3. Saluran Media & Info Publik -->
                <div class="card border-0 shadow-sm rounded-4 text-white overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #E50914 100%);">
                    <div class="card-body p-4 text-center">
                        <div class="display-6 mb-2 text-warning"><i class="fa-solid fa-bullhorn"></i></div>
                        <h5 class="fw-bold mb-2">Salurkan Informasi Anda</h5>
                        <p class="small text-white-50 mb-3">
                            Punya informasi peristiwa penting atau opini menarik di sekitar Anda? Kirimkan langsung ke redaksi PACEKO.com.
                        </p>
                        <a href="https://api.whatsapp.com/send?text=Halo%20Redaksi%20PACEKO" target="_blank" class="btn btn-light text-danger fw-bold rounded-pill px-4 btn-sm">
                            <i class="fa-brands fa-whatsapp text-success me-1"></i> Hubungi WhatsApp Redaksi
                        </a>
                    </div>
                </div>

                <!-- Sidebar Banner Slot 2 (Half Page 300x600) -->
                <?= render_banner('sidebar_bottom', ['class' => 'mb-4']) ?>

            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Initialize Swiper Hero Slider
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.hero-slider', {
            loop: true,
            speed: 800,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
<?= $this->endSection() ?>

