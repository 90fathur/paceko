<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Susunan Redaksi</li>
                    </ol>
                </nav>

                <div class="text-center mb-4 pb-4 border-bottom">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="PACEKO.com Logo" class="img-fluid mb-3" style="max-height: 55px;">
                    <h1 class="fs-2 fw-bold text-dark">Susunan Dewan Redaksi</h1>
                    <p class="text-muted">PT. PACEKO MEDIA INOVATIF DIGITAL</p>
                </div>

                <div class="article-content fs-6">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 35%;">Jabatan</th>
                                    <th>Nama / Personil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Pembina / Penasihat Hukum</td>
                                    <td>Adv. Redaksi PACEKO & Rekan, S.H., M.H.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Pemimpin Umum / Perusahaan</td>
                                    <td>Fathur Rahman, S.Kom.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Pemimpin Redaksi / Penanggung Jawab</td>
                                    <td>M. Ridwan As'ad, S.Sos. (Wartawan Utama)</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Redaktur Pelaksana</td>
                                    <td>Ahmad Ilham Maulana</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Sekretaris Redaksi</td>
                                    <td>Nurhikmah, S.Pd.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Biro Daerah Polewali Mandar</td>
                                    <td>Samsul Bahri, Hasrul</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Biro Daerah Mamuju (Provinsi)</td>
                                    <td>Faisal Akbar</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Biro Majene & Mamasa</td>
                                    <td>Syamsuddin</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">IT & Desain Grafis Multimedia</td>
                                    <td>Tim IT Paceko Media Digital</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-danger mt-4 small" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        <strong>Perhatian:</strong> Wartawan PACEKO.com selalu dibekali Kartu Tanda Anggota (KTA) resmi dan namanya tercantum dalam Boks Redaksi di atas. Dilarang memberikan imbalan dalam bentuk apapun terkait peliputan berita.
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

