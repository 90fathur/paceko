<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Pengaturan Menu & Dropdown Dinamis</h1>
        <p class="text-muted small mb-0">Kelola navigasi bilah menu utama portal PACEKO.com lengkap dengan sub-menu dropdown</p>
    </div>
</div>

<div class="row g-4">
    <!-- Col 1: Form Tambah Menu (4 cols) -->
    <div class="col-lg-4">
        <!-- Form Tambah Menu Baru -->
        <div class="card-compact p-3 mb-4">
            <h6 class="fw-bold small border-bottom pb-2 mb-3">
                <i class="fa-solid fa-plus-circle text-danger me-1"></i> Tambah Menu Baru
            </h6>
            <form action="<?= base_url('admin/menus/store') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Menu <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="inputMenuTitle" class="form-control form-control-compact" placeholder="Contoh: Liputan Daerah" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">URL Tautan / Link <span class="text-danger">*</span></label>
                    <input type="text" name="url" id="inputMenuUrl" class="form-control form-control-compact" placeholder="Contoh: /kategori/daerah atau #" required>
                    <span class="text-muted small" style="font-size: 0.7rem;">Gunakan <code>#</code> jika menu ini hanya judul dropdown.</span>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Induk Menu (Dropdown Parent)</label>
                    <select name="parent_id" id="inputMenuParent" class="form-select form-select-sm form-control-compact">
                        <option value="0">-- Menu Utama (Tingkat Atas) --</option>
                        <?php foreach ($parentMenus as $parent): ?>
                            <option value="<?= $parent['id'] ?>">
                                ↳ Dropdown di bawah: <?= esc($parent['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-muted small" style="font-size: 0.7rem;">Pilih induk menu untuk menjadikannya sub-menu dropdown.</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-semibold">Nomor Urutan</label>
                        <input type="number" name="order_num" value="1" min="1" class="form-control form-control-compact">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-semibold">Target Tab</label>
                        <select name="target" class="form-select form-select-sm form-control-compact">
                            <option value="_self">Tab Sama (_self)</option>
                            <option value="_blank">Tab Baru (_blank)</option>
                        </select>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="menuActiveCheck" checked>
                    <label class="form-check-label small" for="menuActiveCheck">
                        Aktifkan dan tampilkan di navbar
                    </label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-compact py-2 fw-bold shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Tambahkan ke Navigasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Tambah Cepat dari Kategori -->
        <div class="card-compact p-3 mb-4">
            <h6 class="fw-bold small border-bottom pb-2 mb-2">
                <i class="fa-solid fa-tags text-danger me-1"></i> Tambah Cepat dari Kategori
            </h6>
            <p class="text-muted small mb-2" style="font-size: 0.72rem;">Klik tombol <strong>+</strong> untuk mengisi form otomatis:</p>
            <div class="d-flex flex-wrap gap-1" style="max-height: 180px; overflow-y: auto;">
                <?php foreach (array_slice($categories, 0, 15) as $cat): ?>
                    <button type="button" class="btn btn-sm btn-light border btn-compact" onclick="quickFillMenu('<?= esc($cat['name'], 'js') ?>', '/kategori/<?= esc($cat['slug'], 'js') ?>')">
                        <i class="fa-solid fa-plus text-danger me-1"></i> <?= esc($cat['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tambah Cepat dari Halaman Statis -->
        <?php if (!empty($pages)): ?>
        <div class="card-compact p-3">
            <h6 class="fw-bold small border-bottom pb-2 mb-2">
                <i class="fa-solid fa-file-lines text-danger me-1"></i> Tambah Cepat dari Halaman
            </h6>
            <div class="d-flex flex-wrap gap-1">
                <?php foreach ($pages as $p): ?>
                    <button type="button" class="btn btn-sm btn-light border btn-compact" onclick="quickFillMenu('<?= esc($p['post_title'], 'js') ?>', '/halaman/<?= esc($p['post_name'], 'js') ?>')">
                        <i class="fa-solid fa-plus text-danger me-1"></i> <?= esc($p['post_title']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Col 2: Hierarchical Table of Menus (8 cols) -->
    <div class="col-lg-8">
        <div class="card-compact">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-bars-staggered me-1 text-danger"></i> Struktur Menu Navigasi Portal</span>
                <span class="badge bg-light text-muted border badge-compact">Tersusun Hierarki Dropdown</span>
            </div>
            <div class="table-responsive">
                <table class="table table-compact">
                    <thead>
                        <tr>
                            <th style="width: 50px;">Urut</th>
                            <th>Nama Menu Navigasi</th>
                            <th>URL Tautan</th>
                            <th style="width: 100px;">Tipe</th>
                            <th style="width: 80px;">Status</th>
                            <th class="text-end" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($menuTree)): ?>
                            <?php foreach ($menuTree as $menu): ?>
                                <!-- Parent Menu Row -->
                                <tr class="table-light">
                                    <td class="fw-bold text-center"><?= $menu['order_num'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (!empty($menu['children'])): ?>
                                                <i class="fa-solid fa-caret-down text-danger"></i>
                                            <?php else: ?>
                                                <i class="fa-solid fa-circle text-muted" style="font-size: 0.5rem;"></i>
                                            <?php endif; ?>
                                            <span class="fw-bold text-dark fs-7"><?= esc($menu['title']) ?></span>
                                            <?php if (!empty($menu['children'])): ?>
                                                <span class="badge bg-danger rounded-pill badge-compact"><?= count($menu['children']) ?> Dropdown</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><code><?= esc($menu['url']) ?></code></td>
                                    <td>
                                        <span class="badge bg-dark badge-compact">Menu Utama</span>
                                    </td>
                                    <td>
                                        <?php if ($menu['is_active']): ?>
                                            <span class="badge bg-success-subtle text-success badge-compact">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary badge-compact">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary btn-compact" onclick="openEditMenu(<?= htmlspecialchars(json_encode($menu), ENT_QUOTES, 'UTF-8') ?>)" title="Edit">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                            <button onclick="confirmDelete('<?= base_url('admin/menus/delete/' . $menu['id']) ?>', 'Hapus menu ini beserta seluruh sub-menunya?')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Submenus / Dropdown Children Rows -->
                                <?php if (!empty($menu['children'])): ?>
                                    <?php foreach ($menu['children'] as $child): ?>
                                        <tr>
                                            <td class="text-muted text-center" style="font-size: 0.72rem;"><?= $child['order_num'] ?></td>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-danger fw-bold">↳</span>
                                                    <span class="text-secondary"><?= esc($child['title']) ?></span>
                                                </div>
                                            </td>
                                            <td><code class="text-secondary"><?= esc($child['url']) ?></code></td>
                                            <td>
                                                <span class="badge bg-light text-muted border badge-compact">Sub-menu</span>
                                            </td>
                                            <td>
                                                <?php if ($child['is_active']): ?>
                                                    <span class="badge bg-success-subtle text-success badge-compact">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary-subtle text-secondary badge-compact">Nonaktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary btn-compact" onclick="openEditMenu(<?= htmlspecialchars(json_encode($child), ENT_QUOTES, 'UTF-8') ?>)" title="Edit">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <button onclick="confirmDelete('<?= base_url('admin/menus/delete/' . $child['id']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada menu navigasi dibuat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="modalEditMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Edit Menu Navigasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditMenu" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="editMenuTitle" class="form-control form-control-compact" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">URL Tautan / Link <span class="text-danger">*</span></label>
                        <input type="text" name="url" id="editMenuUrl" class="form-control form-control-compact" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Induk Menu (Dropdown Parent)</label>
                        <select name="parent_id" id="editMenuParent" class="form-select form-select-sm form-control-compact">
                            <option value="0">-- Menu Utama (Tingkat Atas) --</option>
                            <?php foreach ($parentMenus as $parent): ?>
                                <option value="<?= $parent['id'] ?>">
                                    ↳ Dropdown di bawah: <?= esc($parent['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Nomor Urutan</label>
                            <input type="number" name="order_num" id="editMenuOrder" class="form-control form-control-compact">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Target Tab</label>
                            <select name="target" id="editMenuTarget" class="form-select form-select-sm form-control-compact">
                                <option value="_self">Tab Sama (_self)</option>
                                <option value="_blank">Tab Baru (_blank)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="editMenuActive">
                        <label class="form-check-label small" for="editMenuActive">
                            Aktifkan dan tampilkan di navbar
                        </label>
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
function quickFillMenu(title, url) {
    $('#inputMenuTitle').val(title);
    $('#inputMenuUrl').val(url);
    $('#inputMenuTitle').focus();
}

function openEditMenu(m) {
    $('#editMenuTitle').val(m.title);
    $('#editMenuUrl').val(m.url);
    $('#editMenuParent').val(m.parent_id);
    $('#editMenuOrder').val(m.order_num);
    $('#editMenuTarget').val(m.target);
    $('#editMenuActive').prop('checked', m.is_active == 1);
    $('#formEditMenu').attr('action', '<?= base_url('admin/menus/update/') ?>' + m.id);
    new bootstrap.Modal(document.getElementById('modalEditMenu')).show();
}
</script>
<?= $this->endSection() ?>

