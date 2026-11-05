<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
                    </ol>
                </nav>

                <div class="text-center mb-4 pb-4 border-bottom">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="PACEKO.com Logo" class="img-fluid mb-3" style="max-height: 60px;">
                    <h1 class="fs-2 fw-bold text-dark">Tentang PACEKO.com</h1>
                    <p class="text-muted">Media Informasi, Inspirasi dan Inovatif</p>
                </div>

                <div class="article-content fs-6">
                    <p>
                        <strong>PACEKO.com</strong> adalah media siber independen yang berbasis di Sulawesi Barat, didirikan dengan tekad menghadirkan informasi yang akurat, berimbang, dan mencerdaskan kehidupan masyarakat. Mengusung tagline <em>"Media Informasi, Inspirasi dan Inovatif"</em>, PACEKO.com tidak hanya sekadar mengabarkan peristiwa aktual, namun juga mengangkat potensi daerah, kearifan lokal, serta inspirasi pembangunan bangsa.
                    </p>

                    <h4 class="fw-bold mt-4 text-danger">Visi Media</h4>
                    <p>
                        Menjadi portal berita digital terkemuka dan terpercaya di Sulawesi Barat dan Kawasan Indonesia Timur yang mengedepankan integritas, keterbukaan informasi publik, serta transformasi digital jurnalisme bermartabat.
                    </p>

                    <h4 class="fw-bold mt-4 text-danger">Misi Media</h4>
                    <ol>
                        <li>Menyajikan berita dan informasi yang cepat, akurat, faktual, dan independen.</li>
                        <li>Mengawal kebijakan publik dan pembangunan daerah secara kritis, objektif, dan konstruktif.</li>
                        <li>Menjadi ruang inspirasi dan inovasi bagi generasi muda, pelaku UMKM, dan masyarakat sipil.</li>
                        <li>Menjunjung tinggi Kode Etik Jurnalistik dan Undang-Undang Pokok Pers No. 40 Tahun 1999.</li>
                    </ol>

                    <div class="p-4 bg-light rounded-4 border mt-5">
                        <h5 class="fw-bold text-dark mb-2">Kantor Redaksi</h5>
                        <p class="small text-secondary mb-1"><i class="fa-solid fa-location-dot text-danger me-2"></i> Polewali Mandar, Sulawesi Barat, Indonesia</p>
                        <p class="small text-secondary mb-1"><i class="fa-solid fa-envelope text-danger me-2"></i> Email: redaksi@paceko.com</p>
                        <p class="small text-secondary mb-0"><i class="fa-solid fa-globe text-danger me-2"></i> Website Resmi: https://paceko.com</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

