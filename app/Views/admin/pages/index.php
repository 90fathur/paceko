<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Kelola Halaman Statis</h1>
        <p class="text-muted small mb-0">Total <?= count($pages) ?> halaman informasi profil, redaksi, dan kebijakan</p>
    </div>
    <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-danger btn-compact d-flex align-items-center gap-1 shadow-sm">
        <i class="fa-solid fa-plus"></i> Tambah Halaman Baru
    </a>
</div>

<div class="card-compact">
    <div class="table-responsive">
        <table class="table table-compact">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Judul Halaman</th>
                    <th>Slug URL</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pages)): ?>
                    <?php 
                    $no = 1;
                    foreach ($pages as $p): 
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold text-dark">
                                <a href="<?= base_url('halaman/' . esc($p['post_name'])) ?>" target="_blank" class="text-dark text-decoration-none">
                                    <?= esc($p['post_title']) ?>
                                </a>
                            </td>
                            <td><code>/halaman/<?= esc($p['post_name']) ?></code></td>
                            <td>
                                <?php if ($p['post_status'] === 'publish'): ?>
                                    <span class="badge bg-success-subtle text-success badge-compact">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning badge-compact">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted" style="white-space: nowrap;">
                                <?= date('d/m/Y H:i', strtotime($p['post_date'])) ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('halaman/' . esc($p['post_name'])) ?>" target="_blank" class="btn btn-outline-secondary btn-compact" title="Lihat">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pages/edit/' . $p['ID']) ?>" class="btn btn-outline-primary btn-compact" title="Edit">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <button onclick="confirmDelete('<?= base_url('admin/pages/delete/' . $p['ID']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada halaman dibuat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

