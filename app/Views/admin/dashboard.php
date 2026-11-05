<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Dashboard Redaksi</h1>
        <p class="text-muted small mb-0">Selamat datang di Panel Admin PACEKO.com</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/news/create') ?>" class="btn btn-danger btn-compact d-flex align-items-center gap-1 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tulis Berita
        </a>
    </div>
</div>

<!-- 4 Compact Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card-compact p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.6875rem;">Total Berita Terbit</span>
                    <h3 class="fs-4 fw-extrabold mb-0 mt-1 text-dark"><?= number_format($stats['total_posts']) ?></h3>
                    <span class="text-success small" style="font-size: 0.72rem;"><i class="fa-solid fa-check-circle me-1"></i> Aktif di Portal</span>
                </div>
                <div class="rounded-3 bg-danger bg-opacity-10 text-danger p-3 fs-5">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card-compact p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.6875rem;">Total Tayangan / Views</span>
                    <h3 class="fs-4 fw-extrabold mb-0 mt-1 text-dark"><?= number_format($stats['total_views']) ?></h3>
                    <span class="text-primary small" style="font-size: 0.72rem;"><i class="fa-solid fa-chart-line me-1"></i> Pembaca Portal</span>
                </div>
                <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 fs-5">
                    <i class="fa-solid fa-eye"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card-compact p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.6875rem;">Total Kategori</span>
                    <h3 class="fs-4 fw-extrabold mb-0 mt-1 text-dark"><?= number_format($stats['total_categories']) ?></h3>
                    <span class="text-secondary small" style="font-size: 0.72rem;"><i class="fa-solid fa-folder me-1"></i> Kanal Berita</span>
                </div>
                <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-3 fs-5">
                    <i class="fa-solid fa-tags"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card-compact p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.6875rem;">Draft / Konsep</span>
                    <h3 class="fs-4 fw-extrabold mb-0 mt-1 text-dark"><?= number_format($stats['total_drafts']) ?></h3>
                    <span class="text-secondary small" style="font-size: 0.72rem;"><i class="fa-solid fa-clock me-1"></i> Belum Terbit</span>
                </div>
                <div class="rounded-3 bg-secondary bg-opacity-10 text-secondary p-3 fs-5">
                    <i class="fa-solid fa-file-pen"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Posts Table (8 cols) -->
    <div class="col-lg-8">
        <div class="card-compact">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-clock-rotate-left me-1 text-danger"></i> Berita Terkini Ditambahkan</span>
                <a href="<?= base_url('admin/news') ?>" class="text-danger fw-semibold" style="font-size: 0.75rem;">Lihat Semua &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-compact">
                    <thead>
                        <tr>
                            <th style="width: 50px;">Foto</th>
                            <th>Judul Berita</th>
                            <th>Kategori</th>
                            <th>Views</th>
                            <th>Tanggal</th>
                            <th class="text-end" style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentNews)): ?>
                            <?php foreach ($recentNews as $post): ?>
                                <tr>
                                    <td>
                                        <div style="width: 42px; height: 32px; border-radius: 4px; overflow: hidden; background: #e2e8f0;">
                                            <img src="<?= get_post_image($post) ?>" alt="" class="w-100 h-100 object-fit-cover" loading="lazy">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('berita/' . esc($post['slug'])) ?>" target="_blank" class="fw-semibold text-dark text-decoration-none">
                                            <?= esc($post['post_title']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border badge-compact">
                                            <?= esc($post['category_name']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted"><i class="fa-regular fa-eye me-1"></i><?= number_format($post['views']) ?></span>
                                    </td>
                                    <td class="text-muted" style="white-space: nowrap;">
                                        <?= date('d/m/Y H:i', strtotime($post['post_date'])) ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('admin/news/edit/' . $post['ID']) ?>" class="btn btn-outline-secondary btn-compact" title="Edit">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <button onclick="confirmDelete('<?= base_url('admin/news/delete/' . $post['ID']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada berita.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Viewed Articles (4 cols) -->
    <div class="col-lg-4">
        <div class="card-compact">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-fire me-1 text-danger"></i> 6 Berita Paling Banyak Dibaca</span>
            </div>
            <div class="card-body p-2">
                <div class="list-group list-group-flush">
                    <?php 
                    $pRank = 1;
                    foreach ($popularNews as $pop): 
                    ?>
                        <div class="list-group-item px-2 py-2 border-0 border-bottom d-flex align-items-start gap-2">
                            <span class="badge bg-danger rounded-circle mt-1" style="width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.65rem;">
                                <?= $pRank++ ?>
                            </span>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <a href="<?= base_url('berita/' . esc($pop['slug'])) ?>" target="_blank" class="d-block fw-semibold text-dark text-truncate text-decoration-none" style="font-size: 0.78rem;">
                                    <?= esc($pop['post_title']) ?>
                                </a>
                                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.7rem;">
                                    <span><?= esc($pop['category_name']) ?></span>
                                    <span class="text-danger fw-semibold"><i class="fa-regular fa-eye me-1"></i><?= number_format($pop['views']) ?> views</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

