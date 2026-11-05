<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-secondary"><i class="fa-solid fa-house"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('kategori/' . esc($post['category_slug'])) ?>" class="text-danger fw-semibold"><?= esc($post['category_name']) ?></a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 320px;" aria-current="page"><?= esc($post['post_title']) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Article (8 Cols) -->
        <div class="col-lg-8">
            <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                
                <!-- Category Badge -->
                <div class="mb-2">
                    <a href="<?= base_url('kategori/' . esc($post['category_slug'])) ?>" class="category-pill bg-danger text-white">
                        <?= esc($post['category_name']) ?>
                    </a>
                </div>

                <!-- Headline Title -->
                <h1 class="display-6 fw-extrabold text-dark mb-3 lh-sm" style="font-family: var(--font-heading);">
                    <?= esc($post['post_title']) ?>
                </h1>

                <!-- Lead/Excerpt if available -->
                <?php if (!empty($post['post_excerpt'])): ?>
                    <p class="lead text-secondary fw-normal mb-4" style="font-size: 1.15rem; line-height: 1.6;">
                        <?= esc($post['post_excerpt']) ?>
                    </p>
                <?php endif; ?>

                <!-- Byline & Meta Info -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 py-3 border-top border-bottom mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold text-dark small">Penulis / Redaksi:</span>
                            <span class="text-secondary small"><?= esc($post['author_name']) ?></span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-4 text-muted small">
                        <span><i class="fa-regular fa-calendar-days text-danger me-1"></i> <?= format_indo_date($post['post_date'], true) ?></span>
                        <span><i class="fa-regular fa-eye text-danger me-1"></i> <?= number_format($post['views']) ?> tayangan</span>
                        <span><i class="fa-regular fa-clock text-danger me-1"></i> <?= reading_time($post['post_content']) ?></span>
                    </div>
                </div>

                <!-- Featured Image with Smart Caption -->
                <figure class="mb-4 rounded-4 overflow-hidden shadow-sm border bg-light">
                    <img src="<?= get_post_image($post) ?>" alt="<?= esc($post['post_title']) ?>" class="img-fluid w-100" style="max-height: 480px; object-fit: cover;">
                    <figcaption class="figure-caption text-secondary small py-2 px-3 bg-light border-top d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-camera text-danger me-1"></i> <?= esc(get_image_caption($post)) ?></span>
                        <span class="badge bg-white text-secondary border font-monospace" style="font-size: 0.65rem;">PACEKO</span>
                    </figcaption>
                </figure>

                <!-- Social Share Bar (Top) -->
                <?php
                $shareUrl = current_url();
                $shareTitle = urlencode($post['post_title']);
                ?>
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 p-2 bg-light rounded-4 border">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-bold text-secondary ps-2 pe-1"><i class="fa-solid fa-share-nodes me-1 text-danger"></i> Bagikan:</span>
                        <a href="https://api.whatsapp.com/send?text=<?= $shareTitle ?>%20<?= urlencode($shareUrl) ?>" target="_blank" class="share-btn share-wa" title="Bagikan ke WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($shareUrl) ?>" target="_blank" class="share-btn share-fb" title="Bagikan ke Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= urlencode($shareUrl) ?>" target="_blank" class="share-btn share-x" title="Bagikan ke X (Twitter)">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="https://t.me/share/url?url=<?= urlencode($shareUrl) ?>&text=<?= $shareTitle ?>" target="_blank" class="share-btn share-tg" title="Bagikan ke Telegram">
                            <i class="fa-brands fa-telegram"></i>
                        </a>
                        <button class="share-btn share-copy border-0" id="btnCopyLink" onclick="copyArticleLink('<?= $shareUrl ?>')" title="Salin Tautan">
                            <i class="fa-solid fa-link"></i>
                        </button>
                        <span id="copyNotice" class="text-success small fw-bold ms-2 d-none"><i class="fa-solid fa-check"></i> Disalin!</span>
                    </div>

                    <!-- Reading Tools: Font Resizer & Print -->
                    <div class="d-flex align-items-center gap-2 ms-auto pe-2">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Font Resizer">
                            <button type="button" class="btn btn-outline-secondary" onclick="changeFontSize(-1)" title="Perkecil Huruf">A-</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="changeFontSize(0)" title="Ukuran Normal">A</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="changeFontSize(1)" title="Perbesar Huruf">A+</button>
                        </div>
                        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary" title="Cetak Berita">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </div>
                </div>

                <!-- Article Body Content -->
                <div class="article-content" id="articleBody">
                    <?= $post['post_content'] ?>
                </div>

                <!-- In-Article Sponsor Banner (728x90) -->
                <?= render_banner('in_article', ['class' => 'my-4']) ?>

                <!-- Dynamic Article Tags / Topik Terkait -->
                <?php $articleTags = get_post_tags($post); ?>
                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="fw-bold small text-secondary"><i class="fa-solid fa-tags text-danger me-1"></i> Topik Terkait:</span>
                        <?php foreach ($articleTags as $tag): ?>
                            <a href="<?= base_url('cari?q=' . urlencode($tag)) ?>" class="badge bg-light text-dark border p-2 text-decoration-none rounded-pill shadow-xs transition-all hover-danger">
                                #<?= esc($tag) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Author Bio Box -->
                <div class="p-4 bg-light rounded-4 border mt-4 d-flex gap-3 align-items-center">
                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 56px; height: 56px; flex-shrink: 0;">
                        <i class="fa-solid fa-feather-pointed"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark"><?= esc($post['author_name']) ?></h6>
                        <p class="small text-secondary mb-0">
                            Jurnalis dan kontributor redaksi PACEKO.com, berkomitmen menyajikan liputan mendalam, akurat, dan berimbang demi kemajuan Sulawesi Barat dan Indonesia.
                        </p>
                    </div>
                </div>

            </article>

            <!-- After-Article Sponsor Banner (728x90) -->
            <?= render_banner('after_article', ['class' => 'my-4']) ?>

            <!-- Berita Terkait (Related News) -->
            <?php if (!empty($relatedPosts)): ?>
            <div class="mt-5">
                <div class="section-header">
                    <h3 class="section-title"><i class="fa-solid fa-layer-group"></i> Berita Terkait</h3>
                </div>
                <div class="row g-3">
                    <?php foreach ($relatedPosts as $rel): ?>
                        <div class="col-md-6 col-12">
                            <article class="paceko-card h-100 p-3 d-flex gap-3 align-items-center">
                                <div style="width: 100px; height: 85px; flex-shrink: 0; border-radius: 8px; overflow: hidden;">
                                    <img src="<?= get_post_image($rel) ?>" alt="<?= esc($rel['post_title']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
                                </div>
                                <div class="flex-grow-1">
                                    <a href="<?= base_url('kategori/' . esc($rel['category_slug'])) ?>" class="category-pill mb-1">
                                        <?= esc($rel['category_name']) ?>
                                    </a>
                                    <h5 class="fs-7 fw-bold mb-1 lh-sm">
                                        <a href="<?= base_url('berita/' . esc($rel['slug'])) ?>" class="text-dark">
                                            <?= esc($rel['post_title']) ?>
                                        </a>
                                    </h5>
                                    <div class="small text-muted" style="font-size: 0.72rem;">
                                        <i class="fa-regular fa-clock text-danger me-1"></i> <?= time_ago_id($rel['post_date']) ?>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- Sidebar (4 Cols) -->
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

                <!-- Kategori Populer Widget -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fs-6 fw-bold text-uppercase text-dark">
                            <i class="fa-solid fa-tags text-danger me-2"></i> Kategori Berita
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

                <!-- Sidebar Banner Slot 1 (Medium Rectangle 300x250) -->
                <?= render_banner('sidebar', ['class' => 'mb-4']) ?>

                <!-- Sidebar Banner Slot 2 (Half Page 300x600) -->
                <?= render_banner('sidebar_bottom', ['class' => 'mb-4']) ?>

            </div>
        </div>
    </div>

</div>

<script>
function copyArticleLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        const notice = document.getElementById('copyNotice');
        notice.classList.remove('d-none');
        setTimeout(() => {
            notice.classList.add('d-none');
        }, 2500);
    });
}

// Font Resizer
let currentFontSize = 1.1; // rem
function changeFontSize(direction) {
    const el = document.getElementById('articleBody');
    if (!el) return;
    if (direction === 0) {
        currentFontSize = 1.1;
    } else {
        currentFontSize += direction * 0.1;
        if (currentFontSize < 0.9) currentFontSize = 0.9;
        if (currentFontSize > 1.6) currentFontSize = 1.6;
    }
    el.style.fontSize = currentFontSize + 'rem';
}
</script>
<?= $this->endSection() ?>

