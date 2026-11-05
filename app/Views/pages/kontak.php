<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kontak Kami</li>
                    </ol>
                </nav>

                <h1 class="fs-2 fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Hubungi Redaksi & Iklan</h1>
                <p class="text-muted mb-4">Kami menyambut baik kritik, saran, siaran pers, hak jawab, dan kemitraan iklan dari Anda.</p>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show p-3 mb-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show p-3 mb-4" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 border h-100">
                            <div class="text-danger fs-3 mb-2"><i class="fa-solid fa-location-dot"></i></div>
                            <h5 class="fw-bold text-dark">Alamat Redaksi</h5>
                            <p class="small text-secondary mb-0">
                                <?= esc(get_setting('office_address', 'Polewali Mandar, Sulawesi Barat, Indonesia')) ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 border h-100">
                            <div class="text-danger fs-3 mb-2"><i class="fa-solid fa-envelope-open-text"></i></div>
                            <h5 class="fw-bold text-dark">Kontak & Email</h5>
                            <p class="small text-secondary mb-1">Email: <strong><?= esc(get_setting('contact_email', 'redaksi@paceko.com')) ?></strong></p>
                            <p class="small text-secondary mb-0">Telepon / WhatsApp: <strong><?= esc(get_setting('contact_phone', '+62 821-8888-9999')) ?></strong></p>
                        </div>
                    </div>
                </div>

                <!-- Contact / Citizen Journalism Form -->
                <div class="p-4 p-md-5 rounded-4 bg-light border mb-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="fs-4 text-danger"><i class="fa-solid fa-paper-plane"></i></span>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">Kirim Pesan / Pengaduan / Siaran Pers</h4>
                            <span class="text-muted small">Pesan Anda akan langsung masuk ke panel redaksi PACEKO.com</span>
                        </div>
                    </div>

                    <form action="<?= base_url('kontak/kirim') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Anda atau Instansi" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="alamat@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Nomor WhatsApp / HP</label>
                                <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Subjek / Topik <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" placeholder="Contoh: Rilis Berita / Pengaduan Warga / Pasang Iklan" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Isi Pesan / Informasi <span class="text-danger">*</span></label>
                                <textarea name="message" rows="5" class="form-control" placeholder="Tuliskan pesan, kronologi peristiwa, atau penawaran kerjasama Anda di sini..." required></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pesan ke Redaksi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card border-0 bg-danger text-white rounded-4 p-4 text-center">
                    <h5 class="fw-bold mb-2">Kerjasama Iklan & Advertorial</h5>
                    <p class="small text-white-50 mb-3">
                        Tingkatkan jangkauan promosi brand, instansi pemerintah, BUMN, atau usaha Anda bersama jutaan pembaca PACEKO.com.
                    </p>
                    <div>
                        <a href="<?= esc(get_setting('social_whatsapp', 'https://api.whatsapp.com/send?text=Halo%20Admin%20PACEKO')) ?>" target="_blank" class="btn btn-light text-danger fw-bold rounded-pill px-4 btn-sm">
                            <i class="fa-brands fa-whatsapp text-success me-1"></i> Hubungi WhatsApp Marketing
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
