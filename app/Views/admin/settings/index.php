<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Pengaturan Website & Identitas</h1>
        <p class="text-muted small mb-0">Kelola logo, favicon, informasi redaksi, dan profil PACEKO.com</p>
    </div>
</div>

<form action="<?= base_url('admin/settings/update') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Col 1: Logo & Media Sosial (4 cols) -->
        <div class="col-lg-4">
            <!-- Ganti Logo Card -->
            <div class="card-compact p-3 mb-4">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Logo Resmi Portal</h6>
                <div class="text-center p-3 bg-light rounded-3 mb-3 border">
                    <img id="logoPreview" src="<?= base_url($settings['site_logo'] ?? 'assets/images/logo.png') ?>" alt="Logo PACEKO.com" class="img-fluid" style="max-height: 55px;">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Unggah Logo Baru</label>
                    <input type="file" name="site_logo" id="logoInput" class="form-control form-control-sm form-control-compact" accept="image/*">
                    <span class="text-muted small d-block mt-1" style="font-size: 0.7rem;">Format: PNG transparan atau WebP. Maks 3MB.</span>
                </div>
            </div>

            <!-- Ganti Favicon Card -->
            <div class="card-compact p-3 mb-4">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Favicon Browser</h6>
                <div class="d-flex align-items-center gap-3 p-2 bg-light rounded-3 mb-3 border">
                    <img id="faviconPreview" src="<?= base_url($settings['site_favicon'] ?? 'assets/images/logo.png') ?>" alt="Favicon" style="width: 36px; height: 36px; object-fit: contain;">
                    <span class="text-muted small" style="font-size: 0.75rem;">Ikon kecil yang muncul di tab browser pengguna.</span>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Unggah Favicon</label>
                    <input type="file" name="site_favicon" id="faviconInput" class="form-control form-control-sm form-control-compact" accept="image/*">
                </div>
            </div>

            <!-- Keamanan & Proteksi Konten Card -->
            <div class="card-compact p-3 mb-4">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">
                    <i class="fa-solid fa-shield-halved text-danger me-1"></i> Proteksi Konten Berita
                </h6>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="enableAntiCopy" name="enable_anti_copy" value="1" <?= ($settings['enable_anti_copy'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <label class="form-check-label small fw-bold" for="enableAntiCopy">Anti Copy-Paste (Semua Perangkat)</label>
                </div>
                <p class="text-muted small mb-0" style="font-size: 0.72rem;">
                    Mencegah pencurian dan copy-paste konten berita di semua platform (iPhone/iOS Safari, Android, dan PC Desktop) melalui blokir seleksi teks, klik kanan, shortcut keyboard (Ctrl/Cmd+C, Ctrl/Cmd+U, Ctrl/Cmd+P), dan menu callout tap-and-hold iPhone.
                </p>
            </div>

            <!-- Media Sosial -->
            <div class="card-compact p-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Media Sosial Redaksi</h6>
                
                <div class="mb-2">
                    <label class="form-label small fw-semibold"><i class="fa-brands fa-facebook text-primary me-1"></i> Facebook</label>
                    <input type="url" name="social_facebook" value="<?= esc($settings['social_facebook'] ?? '') ?>" class="form-control form-control-compact" placeholder="https://facebook.com/...">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-semibold"><i class="fa-brands fa-instagram text-danger me-1"></i> Instagram</label>
                    <input type="url" name="social_instagram" value="<?= esc($settings['social_instagram'] ?? '') ?>" class="form-control form-control-compact" placeholder="https://instagram.com/...">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-semibold"><i class="fa-brands fa-x-twitter text-dark me-1"></i> X / Twitter</label>
                    <input type="url" name="social_twitter" value="<?= esc($settings['social_twitter'] ?? '') ?>" class="form-control form-control-compact" placeholder="https://twitter.com/...">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-semibold"><i class="fa-brands fa-youtube text-danger me-1"></i> YouTube</label>
                    <input type="url" name="social_youtube" value="<?= esc($settings['social_youtube'] ?? '') ?>" class="form-control form-control-compact" placeholder="https://youtube.com/...">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-semibold"><i class="fa-brands fa-whatsapp text-success me-1"></i> Saluran WhatsApp / Kontak</label>
                    <input type="url" name="social_whatsapp" value="<?= esc($settings['social_whatsapp'] ?? '') ?>" class="form-control form-control-compact" placeholder="https://wa.me/...">
                </div>
            </div>
        </div>

        <!-- Col 2: Info Portal, Kontak, SEO (8 cols) -->
        <div class="col-lg-8">
            <div class="card-compact p-4 mb-4">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Identitas & Informasi Media</h6>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Portal / Website <span class="text-danger">*</span></label>
                        <input type="text" name="site_title" value="<?= esc($settings['site_title'] ?? 'PACEKO.com') ?>" class="form-control form-control-compact fw-bold" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Slogan / Tagline <span class="text-danger">*</span></label>
                        <input type="text" name="site_tagline" value="<?= esc($settings['site_tagline'] ?? 'Media Informasi, Inspirasi dan Inovatif') ?>" class="form-control form-control-compact" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Alamat Email Redaksi <span class="text-danger">*</span></label>
                        <input type="email" name="contact_email" value="<?= esc($settings['contact_email'] ?? 'redaksi@paceko.com') ?>" class="form-control form-control-compact" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nomor Telepon / WhatsApp Redaksi</label>
                        <input type="text" name="contact_phone" value="<?= esc($settings['contact_phone'] ?? '+62 821-8888-9999') ?>" class="form-control form-control-compact">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Alamat Lengkap Kantor Redaksi</label>
                    <input type="text" name="office_address" value="<?= esc($settings['office_address'] ?? 'Polewali Mandar, Sulawesi Barat, Indonesia') ?>" class="form-control form-control-compact">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Profil Singkat Footer</label>
                    <textarea name="footer_text" rows="3" class="form-control form-control-compact"><?= esc($settings['footer_text'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-danger"><i class="fa-solid fa-bullhorn me-1"></i> Teks Berjalan Tambahan (Pesan / Pengumuman Darurat)</label>
                    <input type="text" name="running_text_extra" value="<?= esc($settings['running_text_extra'] ?? '') ?>" class="form-control form-control-compact" placeholder="Teks pengumuman khusus yang akan ikut berputar di running text portal...">
                </div>

                <hr class="my-4">

                <h6 class="fw-bold small border-bottom pb-2 mb-3">Optimasi Mesin Pencari (SEO & Meta)</h6>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Meta Deskripsi (Google Search Description)</label>
                    <textarea name="site_description" rows="2" class="form-control form-control-compact"><?= esc($settings['site_description'] ?? '') ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Kata Kunci (Meta Keywords)</label>
                    <input type="text" name="site_keywords" value="<?= esc($settings['site_keywords'] ?? '') ?>" class="form-control form-control-compact" placeholder="paceko, berita sulbar, berita polman, polewali mandar">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-danger btn-compact px-4 py-2 fw-bold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Semua Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Live preview for Logo
    $('#logoInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#logoPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Live preview for Favicon
    $('#faviconInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#faviconPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?= $this->endSection() ?>

