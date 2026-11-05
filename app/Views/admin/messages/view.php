<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Detail Pesan Masuk</h1>
        <p class="text-muted small mb-0">Diterima pada <?= date('d F Y, H:i', strtotime($message['created_at'])) ?> WITA</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/messages') ?>" class="btn btn-outline-secondary btn-compact">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Kotak Masuk
        </a>
        <button onclick="confirmDelete('<?= base_url('admin/messages/delete/' . $message['id']) ?>')" class="btn btn-outline-danger btn-compact">
            <i class="fa-solid fa-trash me-1"></i> Hapus Pesan
        </button>
    </div>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card-compact p-4">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                <div>
                    <h5 class="fw-bold mb-1 text-dark"><?= esc($message['subject']) ?></h5>
                    <div class="small text-muted">
                        Dari: <strong class="text-dark"><?= esc($message['name']) ?></strong> &bull; <?= esc($message['email']) ?>
                        <?php if (!empty($message['phone'])): ?>
                            &bull; Telepon: <span class="text-success"><?= esc($message['phone']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <span class="badge bg-success-subtle text-success badge-compact">Sudah Dibaca</span>
                </div>
            </div>

            <div class="p-3 bg-light rounded-3 mb-4" style="font-size: 0.875rem; line-height: 1.7; white-space: pre-wrap;">
                <?= esc($message['message']) ?>
            </div>

            <div class="d-flex gap-2">
                <a href="mailto:<?= esc($message['email']) ?>?subject=Re:%20<?= urlencode($message['subject']) ?>" class="btn btn-danger btn-compact">
                    <i class="fa-solid fa-reply me-1"></i> Balas via Email
                </a>
                <?php if (!empty($message['phone'])): ?>
                    <a href="https://api.whatsapp.com/send?phone=<?= preg_replace('/[^0-9]/', '', $message['phone']) ?>&text=Halo%20<?= urlencode($message['name']) ?>%20dari%20Redaksi%20PACEKO.com" target="_blank" class="btn btn-success btn-compact">
                        <i class="fa-brands fa-whatsapp me-1"></i> Hubungi WhatsApp
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

