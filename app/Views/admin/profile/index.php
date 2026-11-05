<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Profil Pengguna</h1>
        <p class="text-muted small mb-0">Kelola informasi akun redaksi dan keamanan sandi</p>
    </div>
</div>

<div class="row g-4">
    <!-- Col 1: Profile Info -->
    <div class="col-lg-6">
        <div class="card-compact p-4">
            <h6 class="fw-bold small border-bottom pb-2 mb-3">Informasi Akun Redaksi</h6>
            <form action="<?= base_url('admin/profile/update') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Username Login</label>
                    <input type="text" value="<?= esc($user['user_login']) ?>" class="form-control form-control-compact bg-light" disabled>
                    <span class="text-muted small" style="font-size: 0.7rem;">Username tidak dapat diubah.</span>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Tampilan (Display Name) <span class="text-danger">*</span></label>
                    <input type="text" name="display_name" value="<?= esc($user['display_name']) ?>" class="form-control form-control-compact" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" name="user_email" value="<?= esc($user['user_email']) ?>" class="form-control form-control-compact" required>
                </div>

                <button type="submit" class="btn btn-danger btn-compact">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Profil
                </button>
            </form>
        </div>
    </div>

    <!-- Col 2: Change Password -->
    <div class="col-lg-6">
        <div class="card-compact p-4">
            <h6 class="fw-bold small border-bottom pb-2 mb-3">Ganti Kata Sandi</h6>
            <form action="<?= base_url('admin/profile/update-password') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                    <input type="password" name="current_password" class="form-control form-control-compact" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Kata Sandi Baru <span class="text-danger">*</span></label>
                    <input type="password" name="new_password" class="form-control form-control-compact" minlength="6" required>
                    <span class="text-muted small" style="font-size: 0.7rem;">Minimal 6 karakter.</span>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                    <input type="password" name="confirm_password" class="form-control form-control-compact" minlength="6" required>
                </div>

                <button type="submit" class="btn btn-dark btn-compact">
                    <i class="fa-solid fa-key me-1"></i> Perbarui Kata Sandi
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

