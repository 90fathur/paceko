<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Kelola Banner Iklan & Sponsor</h1>
        <p class="text-muted small mb-0">Total <?= count($banners) ?> slot banner iklan terdaftar di portal PACEKO.com</p>
    </div>
    <button class="btn btn-danger btn-compact d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddBanner">
        <i class="fa-solid fa-plus"></i> Pasang Banner Baru
    </button>
</div>

<!-- Panduan Standar Ukuran Banner Iklan -->
<div class="card border-0 shadow-sm rounded-3 mb-4 bg-light">
    <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fw-bold small text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-ruler-combined text-danger"></i> Panduan Standar Ukuran Penempatan Iklan PACEKO.com
            </span>
            <span class="badge bg-danger-subtle text-danger" style="font-size: 0.68rem;">Format: JPG, PNG, WEBP, GIF (Maks. 5MB)</span>
        </div>
        <div class="row g-2 text-secondary" style="font-size: 0.75rem;">
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">1. Header Atas</span>
                    <span class="text-danger font-monospace fw-semibold">728 × 90 px</span> (Leaderboard)
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">2. Billboard Beranda</span>
                    <span class="text-danger font-monospace fw-semibold">970 × 250 px</span> (Top Billboard)
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">3. Antar Seksi Beranda</span>
                    <span class="text-danger font-monospace fw-semibold">970 × 250 / 728 × 90 px</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">4. Sidebar Atas</span>
                    <span class="text-danger font-monospace fw-semibold">300 × 250 px</span> (Kotak)
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">5. Sidebar Bawah</span>
                    <span class="text-danger font-monospace fw-semibold">300 × 600 px</span> (Half Page)
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">6. Tengah Berita</span>
                    <span class="text-danger font-monospace fw-semibold">728 × 90 px</span> (In-Article)
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">7. Bawah Berita</span>
                    <span class="text-danger font-monospace fw-semibold">728 × 90 px</span> (After-Article)
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2 bg-white rounded border">
                    <span class="d-block fw-bold text-dark">8. Sebelum Footer</span>
                    <span class="text-danger font-monospace fw-semibold">970 × 90 px</span> (Footer)
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-compact">
    <div class="table-responsive">
        <table class="table table-compact">
            <thead>
                <tr>
                    <th style="width: 70px;">Pratinjau</th>
                    <th>Judul Iklan / Sponsor</th>
                    <th>Posisi Penempatan</th>
                    <th>Link Tujuan</th>
                    <th>Masa Tayang</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($banners)): ?>
                    <?php foreach ($banners as $b): ?>
                        <tr>
                            <td>
                                <div style="width: 60px; height: 35px; border-radius: 4px; overflow: hidden; background: #e2e8f0;">
                                    <img src="<?= base_url($b['image_url']) ?>" alt="" class="w-100 h-100 object-fit-cover">
                                </div>
                            </td>
                            <td class="fw-bold text-dark"><?= esc($b['title']) ?></td>
                            <td>
                                <?php
                                $posNames = [
                                    'header'         => ['Header (728x90)', 'bg-primary'],
                                    'home_top'       => ['Billboard Beranda (970x250)', 'bg-info text-dark'],
                                    'home_middle'    => ['Antar Seksi Berita (970x250)', 'bg-danger'],
                                    'sidebar'        => ['Sidebar Atas (300x250)', 'bg-success'],
                                    'sidebar_bottom' => ['Sidebar Bawah (300x600)', 'bg-dark'],
                                    'in_article'     => ['Tengah Berita (728x90)', 'bg-warning text-dark'],
                                    'after_article'  => ['Bawah Berita (728x90)', 'bg-secondary'],
                                    'footer'         => ['Sebelum Footer (970x90)', 'bg-secondary']
                                ];
                                $pos = $posNames[$b['position']] ?? [$b['position'], 'bg-light text-dark'];
                                ?>
                                <span class="badge <?= $pos[1] ?> badge-compact"><?= $pos[0] ?></span>
                            </td>
                            <td>
                                <a href="<?= esc($b['target_url']) ?>" target="_blank" class="small text-truncate d-inline-block text-secondary" style="max-width: 180px;">
                                    <?= esc($b['target_url']) ?>
                                </a>
                            </td>
                            <td class="small text-muted" style="white-space: nowrap;">
                                <?= $b['start_date'] ? date('d/m/Y', strtotime($b['start_date'])) : 'Sekarang' ?> s/d <?= $b['end_date'] ? date('d/m/Y', strtotime($b['end_date'])) : 'Selamanya' ?>
                            </td>
                            <td>
                                <?php if ($b['status'] === 'active'): ?>
                                    <span class="badge bg-success-subtle text-success badge-compact">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger badge-compact">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary btn-compact" onclick="openEditBanner(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8') ?>)" title="Edit">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                    <button onclick="confirmDelete('<?= base_url('admin/banners/delete/' . $b['id']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada banner iklan dipasang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Banner -->
<div class="modal fade" id="modalAddBanner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Pasang Banner Iklan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/banners/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul / Mitra Sponsor <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-compact" placeholder="Contoh: Bank Sulbar / Pemda Polman / Kopi Mamasa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Posisi Penempatan &amp; Ukuran <span class="text-danger">*</span></label>
                        <select name="position" class="form-select form-select-sm form-control-compact" required>
                            <option value="header">1. Header Atas (Leaderboard 728 × 90 px)</option>
                            <option value="home_top">2. Billboard Beranda Atas (970 × 250 px)</option>
                            <option value="home_middle">3. Antar Seksi Beranda (970 × 250 / 728 × 90 px)</option>
                            <option value="sidebar">4. Sidebar Atas (Medium Rectangle 300 × 250 px)</option>
                            <option value="sidebar_bottom">5. Sidebar Bawah (Half Page 300 × 600 px)</option>
                            <option value="in_article">6. Tengah Isi Bacaan Berita (728 × 90 px)</option>
                            <option value="after_article">7. Bawah Artikel Berita (728 × 90 px)</option>
                            <option value="footer">8. Sebelum Footer Portal (970 × 90 px)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">File Gambar Banner <span class="text-danger">*</span></label>
                        <input type="file" name="banner_image" class="form-control form-control-sm form-control-compact" accept="image/*" required>
                        <span class="text-muted small" style="font-size: 0.7rem;">Format: JPG, PNG, GIF, WebP, SVG. Maks 5MB.</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Link Target URL</label>
                        <input type="url" name="target_url" class="form-control form-control-compact" placeholder="https://contoh-sponsor.com">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control form-control-compact">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tanggal Berakhir</label>
                            <input type="date" name="end_date" class="form-control form-control-compact">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Status Tayang</label>
                        <select name="status" class="form-select form-select-sm form-control-compact">
                            <option value="active">Aktif (Ditayangkan)</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-compact" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-compact">Simpan Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Banner -->
<div class="modal fade" id="modalEditBanner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Edit Banner Iklan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditBanner" action="" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul / Mitra Sponsor <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="editBannerTitle" class="form-control form-control-compact" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Posisi Penempatan &amp; Ukuran <span class="text-danger">*</span></label>
                        <select name="position" id="editBannerPosition" class="form-select form-select-sm form-control-compact" required>
                            <option value="header">1. Header Atas (Leaderboard 728 × 90 px)</option>
                            <option value="home_top">2. Billboard Beranda Atas (970 × 250 px)</option>
                            <option value="home_middle">3. Antar Seksi Beranda (970 × 250 / 728 × 90 px)</option>
                            <option value="sidebar">4. Sidebar Atas (Medium Rectangle 300 × 250 px)</option>
                            <option value="sidebar_bottom">5. Sidebar Bawah (Half Page 300 × 600 px)</option>
                            <option value="in_article">6. Tengah Isi Bacaan Berita (728 × 90 px)</option>
                            <option value="after_article">7. Bawah Artikel Berita (728 × 90 px)</option>
                            <option value="footer">8. Sebelum Footer Portal (970 × 90 px)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ganti Gambar Banner (Opsional)</label>
                        <input type="file" name="banner_image" class="form-control form-control-sm form-control-compact" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Link Target URL</label>
                        <input type="url" name="target_url" id="editBannerTarget" class="form-control form-control-compact">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="editBannerStart" class="form-control form-control-compact">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tanggal Berakhir</label>
                            <input type="date" name="end_date" id="editBannerEnd" class="form-control form-control-compact">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Status Tayang</label>
                        <select name="status" id="editBannerStatus" class="form-select form-select-sm form-control-compact">
                            <option value="active">Aktif (Ditayangkan)</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
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
function openEditBanner(b) {
    $('#editBannerTitle').val(b.title);
    $('#editBannerPosition').val(b.position);
    $('#editBannerTarget').val(b.target_url);
    $('#editBannerStart').val(b.start_date || '');
    $('#editBannerEnd').val(b.end_date || '');
    $('#editBannerStatus').val(b.status);
    $('#formEditBanner').attr('action', '<?= base_url('admin/banners/update/') ?>' + b.id);
    new bootstrap.Modal(document.getElementById('modalEditBanner')).show();
}
</script>
<?= $this->endSection() ?>

