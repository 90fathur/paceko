<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    
    <!-- Category Header Banner -->
    <div class="p-4 p-md-5 mb-5 rounded-4 border shadow-sm text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0b1120 0%, #1e293b 50%, #E50914 100%);">
        <div class="position-relative" style="z-index: 2;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small text-white-50 mb-2">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50">Beranda</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Kategori</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-extrabold mb-2" style="font-family: var(--font-heading);">
                <?= esc($category['name']) ?>
            </h1>
            <p class="text-white-50 mb-0 small">
                Menampilkan kumpulan berita terkini seputar <strong><?= esc($category['name']) ?></strong> • Total <?= number_format($totalPosts) ?> artikel
            </p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Column (8 cols) -->
        <div class="col-lg-8">
            <?php if (!empty($posts)): ?>
                <div class="row g-4">
                    <?php foreach ($posts as $news): ?>
                        <div class="col-md-6 col-12">
                            <article class="paceko-card h-100 d-flex flex-column">
                                <div class="position-relative" style="height: 190px; overflow: hidden;">
                                    <img src="<?= get_post_image($news) ?>" alt="<?= esc($news['post_title']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                                    <span class="category-pill position-absolute top-0 start-0 m-3 shadow-sm bg-danger text-white">
                                        <?= esc($category['name']) ?>
                                    </span>
                                </div>
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <div class="d-flex align-items-center gap-3 text-muted small mb-2" style="font-size: 0.78rem;">
                                        <span><i class="fa-regular fa-clock text-danger me-1"></i> <?= time_ago_id($news['post_date']) ?></span>
                                        <span><i class="fa-regular fa-eye text-danger me-1"></i> <?= number_format($news['views']) ?></span>
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
                                        <a href="<?= base_url('berita/' . esc($news['slug'])) ?>" class="text-danger fw-semibold">Baca &rarr;</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav class="my-5 d-flex justify-content-center">
                        <ul class="pagination pagination-sm">
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link text-danger" href="<?= $baseUrlPagination . '?page=' . ($currentPage - 1) ?>">&laquo; Sebelumnya</a>
                                </li>
                            <?php endif; ?>

                            <?php 
                            $start = max(1, $currentPage - 2);
                            $end   = min($totalPages, $currentPage + 2);
                            for ($i = $start; $i <= $end; $i++): 
                            ?>
                                <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link <?= ($i === $currentPage) ? 'bg-danger border-danger text-white' : 'text-danger' ?>" href="<?= $baseUrlPagination . '?page=' . $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link text-danger" href="<?= $baseUrlPagination . '?page=' . ($currentPage + 1) ?>">Berikutnya &raquo;</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php else: ?>
                <div class="p-5 text-center bg-white rounded-4 border">
                    <div class="display-4 text-muted mb-3"><i class="fa-regular fa-folder-open"></i></div>
                    <h5 class="fw-bold">Belum Ada Berita</h5>
                    <p class="text-muted small">Belum ada artikel yang diterbitkan dalam kategori ini.</p>
                    <a href="<?= base_url() ?>" class="btn btn-danger btn-sm rounded-pill px-4">Kembali ke Beranda</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar (4 cols) -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 80px; z-index: 1000;">
                
                <!-- Berita Terpopuler Widget -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3 border-0 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fs-6 fw-bold text-uppercase d-flex align-items-center gap-2">
                            <i class="fa-solid fa-trophy text-warning"></i> Berita Terpopuler
                        </h5>
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

                <!-- Sidebar Banner Slot (300x250) -->
                <?= render_banner('sidebar', ['class' => 'mb-4']) ?>

                <!-- Kategori Lainnya -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fs-6 fw-bold text-uppercase text-dark">
                            <i class="fa-solid fa-tags text-danger me-2"></i> Kategori Lainnya
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!empty($navCategories)): ?>
                                <?php foreach ($navCategories as $cat): ?>
                                    <a href="<?= base_url('kategori/' . esc($cat['slug'])) ?>" class="btn btn-sm <?= ($cat['slug'] === $category['slug']) ? 'btn-danger text-white' : 'btn-light border' ?> rounded-pill d-inline-flex align-items-center gap-2 py-1 px-3">
                                        <span><?= esc($cat['name']) ?></span>
                                        <span class="badge <?= ($cat['slug'] === $category['slug']) ? 'bg-white text-danger' : 'bg-danger text-white' ?> rounded-pill"><?= number_format($cat['count']) ?></span>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

