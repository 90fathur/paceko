<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Edit Berita</h1>
        <p class="text-muted small mb-0">ID Berita: #<?= esc($news['ID']) ?> • Diperbarui terakhir: <?= date('d M Y H:i', strtotime($news['post_date'])) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('berita/' . esc($news['slug'])) ?>" target="_blank" class="btn btn-outline-danger btn-compact">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Lihat di Portal
        </a>
        <a href="<?= base_url('admin/news') ?>" class="btn btn-outline-secondary btn-compact">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= base_url('admin/news/update/' . $news['ID']) ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Main Form (8 cols) -->
        <div class="col-lg-8">
            <div class="card-compact p-3 mb-4">
                <!-- Title -->
                <div class="mb-3">
                    <label for="postTitle" class="form-label fw-bold small">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="postTitle" value="<?= old('title', $news['post_title']) ?>" class="form-control form-control-compact fw-bold fs-6" required>
                </div>

                <!-- Slug -->
                <div class="mb-3">
                    <label for="postSlug" class="form-label fw-semibold small text-muted">URL Slug</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 small" style="font-size: 0.75rem;"><?= base_url('berita/') ?></span>
                        <input type="text" name="slug" id="postSlug" value="<?= old('slug', $news['slug']) ?>" class="form-control form-control-compact border-start-0">
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="mb-3">
                    <label for="postExcerpt" class="form-label fw-bold small">Ringkasan / Lead Berita</label>
                    <textarea name="excerpt" id="postExcerpt" rows="2" class="form-control form-control-compact"><?= old('excerpt', $news['post_excerpt']) ?></textarea>
                </div>

                <!-- Rich Text Editor with Direct Image Upload -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fw-bold small mb-0">Isi Berita Lengkap <span class="text-danger">*</span></label>
                        <span class="badge bg-light text-muted border" style="font-size: 0.7rem;"><i class="fa-regular fa-image me-1 text-danger"></i> Bisa Drag & Drop / Upload Gambar</span>
                    </div>
                    <textarea name="content" id="contentEditor" class="form-control" rows="14"><?= old('content', $news['post_content']) ?></textarea>
                </div>
            </div>

            <!-- SEO & Google SERP Optimization Card -->
            <div class="card-compact p-3 border-danger-subtle mb-4">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                    <h6 class="fw-bold small mb-0 text-dark">
                        <i class="fa-brands fa-google text-danger me-1"></i> Optimasi SEO &amp; Pratinjau Google Search
                    </h6>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 0.65rem;">Google Snippet Live</span>
                </div>

                <!-- SERP Google Preview Box -->
                <div class="p-3 mb-3 bg-white rounded-3 border" style="font-family: Arial, sans-serif; max-width: 100%;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 24px; height: 24px;">
                            <img src="<?= base_url('assets/images/logo.png') ?>" alt="PACEKO" style="width: 14px; height: 14px;" onerror="this.src='https://www.google.com/favicon.ico'">
                        </div>
                        <div class="text-truncate" style="font-size: 0.8rem; line-height: 1.2;">
                            <span class="fw-bold text-dark d-block">PACEKO.com</span>
                            <span class="text-secondary small text-truncate d-block" id="serpUrlPreview">https://paceko.com &rsaquo; berita &rsaquo; <span id="serpSlugText"><?= esc($news['slug']) ?></span></span>
                        </div>
                    </div>
                    <div class="fw-semibold text-primary text-decoration-none mt-1 mb-1 text-truncate" id="serpTitlePreview" style="font-size: 1.05rem; cursor: pointer; color: #1a0dab !important;">
                        <?= esc(!empty($news['seo_title']) ? $news['seo_title'] : $news['post_title']) ?> - PACEKO.com
                    </div>
                    <div class="text-secondary small" id="serpDescPreview" style="font-size: 0.82rem; line-height: 1.4; color: #4d5156 !important;">
                        <?= esc(!empty($news['seo_description']) ? $news['seo_description'] : (!empty($news['post_excerpt']) ? $news['post_excerpt'] : clean_excerpt($news['post_content'], 140))) ?>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- SEO Title -->
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="seoTitle" class="form-label small fw-semibold mb-0">Judul SEO (Meta Title)</label>
                            <span class="text-muted" style="font-size: 0.68rem;" id="seoTitleCount">0 / 60</span>
                        </div>
                        <input type="text" name="seo_title" id="seoTitle" value="<?= old('seo_title', $news['seo_title'] ?? '') ?>" class="form-control form-control-sm form-control-compact" placeholder="Kosongkan untuk gunakan judul berita utama">
                    </div>

                    <!-- Focus Keywords -->
                    <div class="col-md-6">
                        <label for="seoKeywords" class="form-label small fw-semibold mb-1">Kata Kunci Fokus (Keywords)</label>
                        <input type="text" name="seo_keywords" id="seoKeywords" value="<?= old('seo_keywords', $news['seo_keywords'] ?? '') ?>" class="form-control form-control-sm form-control-compact" placeholder="Contoh: berita polman, pendidikan sulbar">
                    </div>

                    <!-- SEO Description -->
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="seoDescription" class="form-label small fw-semibold mb-0">Deskripsi SEO (Meta Description)</label>
                            <span class="text-muted" style="font-size: 0.68rem;" id="seoDescCount">0 / 160</span>
                        </div>
                        <textarea name="seo_description" id="seoDescription" rows="2" class="form-control form-control-sm form-control-compact" placeholder="Kosongkan untuk gunakan ringkasan / lead berita otomatis"><?= old('seo_description', $news['seo_description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options (4 cols) -->
        <div class="col-lg-4">
            <!-- Publish Actions & Category Card -->
            <div class="card-compact p-3 mb-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Status Publikasi &amp; Kategori</h6>
                
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Status Berita</label>
                    <select name="status" class="form-select form-select-sm form-control-compact">
                        <option value="publish" <?= old('status', $news['post_status']) === 'publish' ? 'selected' : '' ?>>Publish (Tayang di Portal)</option>
                        <option value="draft" <?= old('status', $news['post_status']) === 'draft' ? 'selected' : '' ?>>Draft (Simpan Konsep)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kategori Berita <span class="text-danger">*</span></label>
                    <select name="category_id" id="categorySelect" class="form-select form-select-sm form-control-compact" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['term_id'] ?>" <?= old('category_id', $news['category_id']) == $cat['term_id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Quick Pick Category Pills -->
                    <div class="mt-2">
                        <span class="text-muted d-block mb-1" style="font-size: 0.7rem;"><i class="fa-solid fa-bolt text-warning me-1"></i>Pilih Cepat Kategori:</span>
                        <div class="d-flex flex-wrap gap-1" id="quickCategoryPills">
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="3">Pendidikan</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="123">Pariwisata</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="120">Pemerintahan</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="5">Polhukam</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="2">Peristiwa</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="6">Sosial</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="4">Kesehatan</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary quick-cat-btn" data-cat-id="7">Inspirasi</button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Statistik</label>
                    <div class="p-2 bg-light rounded small text-secondary">
                        <i class="fa-regular fa-eye me-1 text-danger"></i> <?= number_format($news['views']) ?> tayangan
                    </div>
                </div>

                <hr class="my-3">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger btn-compact py-2 fw-bold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('admin/news') ?>" class="btn btn-outline-secondary btn-compact">Batal</a>
                </div>
            </div>

            <!-- Featured Image Upload & Smart Caption Card -->
            <div class="card-compact p-3 mb-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Foto Utama (Featured Image)</h6>
                <div class="mb-3">
                    <div id="imagePreviewContainer" class="border rounded-3 p-2 text-center bg-light mb-2" style="min-height: 140px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img id="imagePreview" src="<?= get_post_image($news) ?>" alt="Pratinjau Foto" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                    </div>
                    <label class="form-label small text-muted">Ganti Foto Utama:</label>
                    <input type="file" name="featured_image" id="featuredImageInput" class="form-control form-control-sm form-control-compact" accept="image/*">
                    <span class="text-muted small d-block mt-1" style="font-size: 0.7rem;">Biarkan kosong jika tidak ingin mengubah foto.</span>
                </div>

                <!-- Smart Image Caption -->
                <div class="pt-2 border-top">
                    <label for="imageCaptionInput" class="form-label small fw-semibold mb-1 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-camera text-danger me-1"></i> Keterangan / Sumber Foto</span>
                        <span class="badge bg-light text-muted border" style="font-size: 0.65rem;">Cerdas &amp; Otomatis</span>
                    </label>
                    <input type="text" name="image_caption" id="imageCaptionInput" value="<?= old('image_caption', $news['image_caption'] ?? '') ?>" class="form-control form-control-sm form-control-compact" placeholder="Contoh: Foto: Diskominfo Polman / Dok. Pribadi">
                    <div class="d-flex flex-wrap gap-1 mt-1">
                        <span class="text-muted" style="font-size: 0.68rem;">Saran:</span>
                        <button type="button" class="btn btn-xs btn-light border py-0 px-1 text-secondary quick-caption-btn" style="font-size: 0.65rem;">Foto: Dok. PACEKO</button>
                        <button type="button" class="btn btn-xs btn-light border py-0 px-1 text-secondary quick-caption-btn" style="font-size: 0.65rem;">Foto: Istimewa</button>
                        <button type="button" class="btn btn-xs btn-light border py-0 px-1 text-secondary quick-caption-btn" style="font-size: 0.65rem;">Foto: Humas Pemkab</button>
                        <button type="button" class="btn btn-xs btn-light border py-0 px-1 text-secondary quick-caption-btn" style="font-size: 0.65rem;">Tangkapan Layar</button>
                    </div>
                    <span class="text-muted small d-block mt-1" style="font-size: 0.68rem;">Bila dikosongkan, sistem cerdas akan otomatis membuat keterangan foto kontekstual dari kategori.</span>
                </div>
            </div>

            <!-- Tags / Topik Berita Card -->
            <div class="card-compact p-3 mb-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">
                    <i class="fa-solid fa-tags text-danger me-1"></i> Tag / Topik Berita
                </h6>
                <div class="mb-2">
                    <label for="tagsInput" class="form-label small fw-semibold">Kata Kunci Tag (Pisahkan koma)</label>
                    <input type="text" name="tags" id="tagsInput" value="<?= old('tags', $news['tags'] ?? '') ?>" class="form-control form-control-sm form-control-compact" placeholder="Misal: Pendidikan, Pariwisata, Polman, Sulbar">
                </div>
                <div class="mt-2">
                    <span class="text-muted d-block mb-1" style="font-size: 0.68rem;">Pilihan Tag Populer (Klik untuk tambah):</span>
                    <div class="d-flex flex-wrap gap-1" id="quickTagPills">
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Pendidikan">+ Pendidikan</button>
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Pariwisata">+ Pariwisata</button>
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Polewali Mandar">+ Polewali Mandar</button>
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Sulawesi Barat">+ Sulawesi Barat</button>
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Pemerintahan">+ Pemerintahan</button>
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Polhukam">+ Polhukam</button>
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Sosial">+ Sosial</button>
                        <button type="button" class="btn btn-xs btn-light border text-dark quick-tag-btn" data-tag="Inovasi">+ Inovasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // 1. Live Google SERP Preview update
    function updateSerp() {
        const titleVal = $('#seoTitle').val().trim() || $('#postTitle').val().trim() || 'Judul Berita';
        $('#serpTitlePreview').text(titleVal + ' - PACEKO.com');

        const slugVal = $('#postSlug').val().trim() || '<?= esc($news['slug']) ?>';
        $('#serpSlugText').text(slugVal);

        const descVal = $('#seoDescription').val().trim() || $('#postExcerpt').val().trim() || 'Pratinjau ringkasan berita di halaman pencarian Google akan tampil di sini.';
        $('#serpDescPreview').text(descVal);

        $('#seoTitleCount').text($('#seoTitle').val().length + ' / 60');
        $('#seoDescCount').text($('#seoDescription').val().length + ' / 160');
    }

    $('#postTitle, #postSlug, #postExcerpt, #seoTitle, #seoDescription').on('keyup change', function() {
        updateSerp();
    });

    // 2. Quick Category Selection Buttons
    $('.quick-cat-btn').on('click', function() {
        const catId = $(this).data('cat-id');
        $('#categorySelect').val(catId).trigger('change');
        highlightActiveCat(catId);
    });

    $('#categorySelect').on('change', function() {
        highlightActiveCat($(this).val());
    });

    function highlightActiveCat(catId) {
        $('.quick-cat-btn').removeClass('btn-danger text-white').addClass('btn-outline-secondary');
        $(`.quick-cat-btn[data-cat-id="${catId}"]`).removeClass('btn-outline-secondary').addClass('btn-danger text-white');
    }
    // Initialize active cat
    if ($('#categorySelect').val()) {
        highlightActiveCat($('#categorySelect').val());
    }

    // 3. Quick Image Caption Buttons
    $('.quick-caption-btn').on('click', function() {
        $('#imageCaptionInput').val($(this).text().trim());
    });

    // 4. Quick Tag Addition Buttons
    $('.quick-tag-btn').on('click', function() {
        const tag = $(this).data('tag');
        let currentTags = $('#tagsInput').val().split(',').map(t => t.trim()).filter(t => t.length > 0);
        if (!currentTags.includes(tag)) {
            currentTags.push(tag);
            $('#tagsInput').val(currentTags.join(', '));
        }
    });

    // 5. Featured Image Live Preview
    $('#featuredImageInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // 6. Summernote Rich Text Editor with AJAX Image Upload
    $('#contentEditor').summernote({
        placeholder: 'Isi berita...',
        tabsize: 2,
        height: 380,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                for (let i = 0; i < files.length; i++) {
                    uploadSummernoteImage(files[i]);
                }
            }
        }
    });

    // 7. Ensure Summernote content is synced and safely encoded on form submit
    $('form').on('submit', function() {
        if ($('#contentEditor').summernote('isEmpty')) {
            $('#contentEditor').val('');
        } else {
            var rawHtml = $('#contentEditor').summernote('code');
            try {
                // Encode to base64 to bypass ModSecurity / LiteSpeed WAF 403 blocks
                var safeBase64 = 'base64:' + btoa(unescape(encodeURIComponent(rawHtml)));
                $('#contentEditor').val(safeBase64);
            } catch (e) {
                $('#contentEditor').val(rawHtml);
            }
        }
    });

    // Handler for uploading image into Summernote
    function uploadSummernoteImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        $.ajax({
            url: '<?= base_url('admin/news/upload-image') ?>',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'Mengunggah Gambar...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
            },
            success: function(response) {
                Swal.close();
                if (response.success && response.url) {
                    $('#contentEditor').summernote('insertImage', response.url, function ($image) {
                        $image.addClass('img-fluid rounded my-3');
                    });
                } else {
                    Swal.fire('Gagal', response.message || 'Gagal mengunggah gambar', 'error');
                }
            },
            error: function(xhr) {
                Swal.close();
                let msg = 'Terjadi kesalahan saat mengunggah gambar.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    }

    updateSerp();
});
</script>
<?= $this->endSection() ?>
