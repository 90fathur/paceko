<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Kelola Wartawan & Pengguna</h1>
        <p class="text-muted small mb-0">Total <?= count($users) ?> personil redaksi terdaftar di sistem</p>
    </div>
    <button class="btn btn-danger btn-compact d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddUser">
        <i class="fa-solid fa-user-plus"></i> Tambah Wartawan Baru
    </button>
</div>

<div class="card-compact">
    <div class="table-responsive">
        <table class="table table-compact">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Nama Wartawan / Pengguna</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Terdaftar Sejak</th>
                    <th class="text-end" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($users as $u): 
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 0.72rem;">
                                    <?= strtoupper(substr($u['display_name'] ?: $u['user_login'], 0, 1)) ?>
                                </div>
                                <span class="fw-bold text-dark"><?= esc($u['display_name']) ?></span>
                            </div>
                        </td>
                        <td><code><?= esc($u['user_login']) ?></code></td>
                        <td><?= esc($u['user_email'] ?: '-') ?></td>
                        <td class="text-muted small" style="white-space: nowrap;">
                            <?= date('d/m/Y', strtotime($u['user_registered'])) ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-warning btn-compact text-dark" onclick="openResetPassword(<?= $u['ID'] ?>, '<?= esc($u['user_login'], 'js') ?>')" title="Reset Password">
                                    <i class="fa-solid fa-key"></i>
                                </button>
                                <button class="btn btn-outline-primary btn-compact" onclick="openEditUser(<?= $u['ID'] ?>, '<?= esc($u['display_name'], 'js') ?>', '<?= esc($u['user_email'], 'js') ?>')" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <?php if ($u['ID'] != 1 && $u['ID'] != session()->get('user_id')): ?>
                                    <button onclick="confirmDelete('<?= base_url('admin/users/delete/' . $u['ID']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
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

<!-- Modal Tambah User -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Tambah Wartawan / Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/users/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username Login <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control form-control-compact" placeholder="Contoh: wartawan_polman" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap / Byline <span class="text-danger">*</span></label>
                        <input type="text" name="display_name" class="form-control form-control-compact" placeholder="Contoh: Muhammad Ridwan, S.Kom." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-compact" placeholder="email@paceko.com" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold">Kata Sandi Awal <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control form-control-compact" minlength="6" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-compact" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-compact">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Edit Data Wartawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap / Byline <span class="text-danger">*</span></label>
                        <input type="text" name="display_name" id="editUserDisplay" class="form-control form-control-compact" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="editUserEmail" class="form-control form-control-compact" required>
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

<!-- Modal Reset Password -->
<div class="modal fade" id="modalResetPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold">Reset Kata Sandi Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formResetPassword" action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <p class="small text-muted mb-3">Atur kata sandi baru untuk akun: <strong class="text-dark" id="resetTargetUsername"></strong></p>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Kata Sandi Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control form-control-compact" minlength="6" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-compact" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning btn-compact text-dark fw-bold">Reset Kata Sandi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openEditUser(id, display, email) {
    $('#editUserDisplay').val(display);
    $('#editUserEmail').val(email);
    $('#formEditUser').attr('action', '<?= base_url('admin/users/update/') ?>' + id);
    new bootstrap.Modal(document.getElementById('modalEditUser')).show();
}

function openResetPassword(id, username) {
    $('#resetTargetUsername').text(username);
    $('#formResetPassword').attr('action', '<?= base_url('admin/users/reset-password/') ?>' + id);
    new bootstrap.Modal(document.getElementById('modalResetPassword')).show();
}
</script>
<?= $this->endSection() ?>

