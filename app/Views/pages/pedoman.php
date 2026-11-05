<?= $this->extend('layout/frontend') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pedoman Media Siber</li>
                    </ol>
                </nav>

                <h1 class="fs-2 fw-bold text-dark mb-4 pb-3 border-bottom">Pedoman Pemberitaan Media Siber</h1>

                <div class="article-content fs-6">
                    <p>
                        Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB. Keberadaan media siber di Indonesia juga merupakan bagian dari kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers.
                    </p>

                    <h5 class="fw-bold mt-4 text-danger">1. Ruang Lingkup</h5>
                    <p>
                        Media Siber adalah segala bentuk media yang menggunakan wahana internet dan melaksanakan kegiatan jurnalistik, serta memenuhi persyaratan Undang-Undang Pokok Pers dan Standar Perusahaan Pers yang ditetapkan Dewan Pers.
                    </p>

                    <h5 class="fw-bold mt-4 text-danger">2. Verifikasi dan Keberimbangan Berita</h5>
                    <ul>
                        <li>Pada prinsipnya setiap berita harus melalui verifikasi.</li>
                        <li>Berita yang dapat merugikan pihak lain memerlukan verifikasi pada berita yang sama untuk memenuhi prinsip akurasi dan keberimbangan.</li>
                    </ul>

                    <h5 class="fw-bold mt-4 text-danger">3. Ralat, Koreksi, dan Hak Jawab</h5>
                    <p>
                        Ralat, koreksi, dan hak jawab mengacu pada Undang-Undang Pers, Kode Etik Jurnalistik, dan Pedoman Hak Jawab yang ditetapkan Dewan Pers. Ralat atau koreksi harus ditautkan pada berita yang diralat.
                    </p>

                    <h5 class="fw-bold mt-4 text-danger">4. Pencabutan Berita</h5>
                    <p>
                        Berita yang sudah dipublikasikan tidak dapat dicabut karena alasan penyensoran dari pihak luar redaksi, kecuali terkait masalah SARA, kesusilaan, masa depan anak, atau atas rekomendasi Dewan Pers.
                    </p>
                </div>
            </article>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

