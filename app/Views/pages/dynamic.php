<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($page['post_title']) ?></li>
                    </ol>
                </nav>

                <h1 class="fs-2 fw-bold text-dark mb-4 pb-3 border-bottom" style="font-family: var(--font-heading);">
                    <?= esc($page['post_title']) ?>
                </h1>

                <?php if (!empty($page['post_excerpt'])): ?>
                    <p class="lead text-secondary mb-4"><?= esc($page['post_excerpt']) ?></p>
                <?php endif; ?>

                <div class="article-content fs-6">
                    <?= $page['post_content'] ?>
                </div>

                <div class="mt-5 pt-3 border-top text-muted small">
                    Diperbarui terakhir: <?= date('d F Y', strtotime($page['post_modified'] ?: $page['post_date'])) ?>
                </div>
            </article>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

