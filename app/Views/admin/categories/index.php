<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Kategori Berita</h1>
        <p class="text-muted small mb-0">Total <?= count($categories) ?> kategori kanal berita di PACEKO.com</p>
    </div>
    <button class="btn btn-danger btn-compact d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </button>
</div>

<div class="card-compact">
    <div class="table-responsive">
        <table class="table table-compact">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Nama Kategori</th>
                    <th>Slug URL</th>
                    <th>Deskripsi</th>
                    <th style="width: 120px;">Jumlah Berita</th>
                    <th class="text-end" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($categories as $cat): 
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold text-dark">
                            <a href="<?= base_url('kategori/' . esc($cat['slug'])) ?>" target="_blank" class="text-dark text-decoration-none">
                                <?= esc($cat['name']) ?>
                            </a>
                        </td>
                        <td><code><?= esc($cat['slug']) ?></code></td>
                        <td class="text-muted"><?= esc($cat['description'] ?: '-') ?></td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger badge-compact">
                                <?= number_format($cat['count']) ?> artikel
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary btn-compact" onclick="openEditCategory(<?= $cat['term_id'] ?>, '<?= esc($cat['name'], 'js') ?>', '<?= esc($cat['slug'], 'js') ?>', '<?= esc($cat['description'] ?? '', 'js') ?>')" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <?php if ($cat['count'] == 0): ?>
                                    <button onclick="confirmDelete('<?= base_url('admin/categories/delete/' . $cat['term_id']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalAddCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/categories/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-compact" placeholder="Contoh: Pemerintahan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Slug URL (Opsional)</label>
                        <input type="text" name="slug" class="form-control form-control-compact" placeholder="Contoh: pemerintahan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi Singkat</label>
                        <textarea name="description" rows="2" class="form-control form-control-compact" placeholder="Keterangan kanal berita..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-compact" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-compact">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="modalEditCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditCategory" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editCatName" class="form-control form-control-compact" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Slug URL</label>
                        <input type="text" name="slug" id="editCatSlug" class="form-control form-control-compact">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi Singkat</label>
                        <textarea name="description" id="editCatDesc" rows="2" class="form-control form-control-compact"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-compact" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-compact">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openEditCategory(id, name, slug, desc) {
    $('#editCatName').val(name);
    $('#editCatSlug').val(slug);
    $('#editCatDesc').val(desc);
    $('#formEditCategory').attr('action', '<?= rtrim(base_url('admin/categories/update'), '/') ?>/' + id);
    new bootstrap.Modal(document.getElementById('modalEditCategory')).show();
}
</script>
<?= $this->endSection() ?>

