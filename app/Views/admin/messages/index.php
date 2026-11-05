<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Pesan Masuk & Aspirasi Pembaca</h1>
        <p class="text-muted small mb-0">Total <?= count($messages) ?> pesan masuk dari masyarakat dan mitra redaksi</p>
    </div>
</div>

<div class="card-compact">
    <div class="table-responsive">
        <table class="table table-compact">
            <thead>
                <tr>
                    <th style="width: 30px;">Status</th>
                    <th>Nama Pengirim</th>
                    <th>Subjek / Topik</th>
                    <th>Email / Telepon</th>
                    <th>Waktu Masuk</th>
                    <th class="text-end" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $m): ?>
                        <tr class="<?= !$m['is_read'] ? 'fw-bold bg-light' : '' ?>">
                            <td class="text-center">
                                <?php if (!$m['is_read']): ?>
                                    <span class="badge bg-danger rounded-circle p-1" title="Belum Dibaca" style="width: 10px; height: 10px; display: inline-block;"></span>
                                <?php else: ?>
                                    <i class="fa-regular fa-envelope-open text-muted" title="Sudah Dibaca"></i>
                                <?php endif; ?>
                            </td>
                            <td class="text-dark"><?= esc($m['name']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/messages/view/' . $m['id']) ?>" class="text-dark text-decoration-none">
                                    <?= esc($m['subject']) ?>
                                </a>
                            </td>
                            <td class="text-muted small">
                                <?= esc($m['email']) ?><br>
                                <span class="text-success"><?= esc($m['phone'] ?: '') ?></span>
                            </td>
                            <td class="text-muted small" style="white-space: nowrap;">
                                <?= date('d/m/Y H:i', strtotime($m['created_at'])) ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('admin/messages/view/' . $m['id']) ?>" class="btn btn-outline-primary btn-compact" title="Baca Pesan">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button onclick="confirmDelete('<?= base_url('admin/messages/delete/' . $m['id']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pesan masuk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

