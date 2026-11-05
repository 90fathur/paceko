<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    
    <!-- Search Form Banner -->
    <div class="p-4 p-md-5 mb-5 rounded-4 border shadow-sm bg-white">
        <h1 class="fs-3 fw-bold mb-3 text-dark">
            <i class="fa-solid fa-magnifying-glass text-danger me-2"></i> Pencarian Berita
        </h1>
        <form action="<?= base_url('cari') ?>" method="GET" class="mb-3">
            <div class="input-group input-group-lg">
                <input type="text" name="q" value="<?= esc($keyword) ?>" class="form-control rounded-start-pill" placeholder="Ketik kata kunci berita..." required>
                <button class="btn btn-danger rounded-end-pill px-4" type="submit">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari Berita
                </button>
            </div>
        </form>
        <?php if (!empty($keyword)): ?>
            <p class="text-muted small mb-0">
                Menampilkan hasil untuk kata kunci: <strong class="text-danger">"<?= esc($keyword) ?>"</strong> • Ditemukan <?= number_format($totalPosts) ?> artikel
            </p>
        <?php endif; ?>
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
                                        <?= esc($news['category_name']) ?>
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
                                    <a class="page-link text-danger" href="<?= $baseUrlPagination . '&page=' . ($currentPage - 1) ?>">&laquo; Sebelumnya</a>
                                </li>
                            <?php endif; ?>

                            <?php 
                            $start = max(1, $currentPage - 2);
                            $end   = min($totalPages, $currentPage + 2);
                            for ($i = $start; $i <= $end; $i++): 
                            ?>
                                <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link <?= ($i === $currentPage) ? 'bg-danger border-danger text-white' : 'text-danger' ?>" href="<?= $baseUrlPagination . '&page=' . $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link text-danger" href="<?= $baseUrlPagination . '&page=' . ($currentPage + 1) ?>">Berikutnya &raquo;</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php else: ?>
                <div class="p-5 text-center bg-white rounded-4 border">
                    <div class="display-4 text-muted mb-3"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <h5 class="fw-bold">Tidak Ada Berita Ditemukan</h5>
                    <p class="text-muted small">Kata kunci <strong>"<?= esc($keyword) ?>"</strong> tidak cocok dengan berita manapun. Coba gunakan kata kunci lain.</p>
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

            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

