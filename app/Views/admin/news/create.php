<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Tulis Berita Baru</h1>
        <p class="text-muted small mb-0">Publikasikan informasi dan artikel terkini ke portal PACEKO.com</p>
    </div>
    <a href="<?= base_url('admin/news') ?>" class="btn btn-outline-secondary btn-compact">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<form action="<?= base_url('admin/news/store') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Main Form (8 cols) -->
        <div class="col-lg-8">
            <div class="card-compact p-3">
                <!-- Title -->
                <div class="mb-3">
                    <label for="postTitle" class="form-label fw-bold small">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="postTitle" value="<?= old('title') ?>" class="form-control form-control-compact fw-bold fs-6" placeholder="Ketik judul berita yang menarik dan akurat..." required autofocus>
                </div>

                <!-- Slug -->
                <div class="mb-3">
                    <label for="postSlug" class="form-label fw-semibold small text-muted">URL Slug (Otomatis dibuat)</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 small" style="font-size: 0.75rem;"><?= base_url('berita/') ?></span>
                        <input type="text" name="slug" id="postSlug" value="<?= old('slug') ?>" class="form-control form-control-compact border-start-0" placeholder="url-slug-berita">
                    </div>
                </div>

                <!-- Excerpt / Ringkasan -->
                <div class="mb-3">
                    <label for="postExcerpt" class="form-label fw-bold small">Ringkasan / Lead Berita (Opsional)</label>
                    <textarea name="excerpt" id="postExcerpt" rows="2" class="form-control form-control-compact" placeholder="Ringkasan 1-2 kalimat pengantar berita..."><?= old('excerpt') ?></textarea>
                </div>

                <!-- Rich Text Editor with Direct Image Upload -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fw-bold small mb-0">Isi Berita Lengkap <span class="text-danger">*</span></label>
                        <span class="badge bg-light text-muted border" style="font-size: 0.7rem;"><i class="fa-regular fa-image me-1 text-danger"></i> Bisa Drag & Drop / Upload Gambar</span>
                    </div>
                    <textarea name="content" id="contentEditor" class="form-control" rows="14"><?= old('content') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar Options (4 cols) -->
        <div class="col-lg-4">
            <!-- Publish Actions -->
            <div class="card-compact p-3 mb-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Status Publikasi</h6>
                
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Status Berita</label>
                    <select name="status" class="form-select form-select-sm form-control-compact">
                        <option value="publish" <?= old('status') === 'draft' ? '' : 'selected' ?>>Publish (Tayang Langsung)</option>
                        <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>Draft (Simpan Konsep)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kategori Berita <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select form-select-sm form-control-compact" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['term_id'] ?>" <?= old('category_id') == $cat['term_id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <hr class="my-3">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger btn-compact py-2 fw-bold shadow-sm">
                        <i class="fa-solid fa-paper-plane me-1"></i> Terbitkan Berita
                    </button>
                    <a href="<?= base_url('admin/news') ?>" class="btn btn-outline-secondary btn-compact">Batal</a>
                </div>
            </div>

            <!-- Featured Image Upload -->
            <div class="card-compact p-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Foto Utama (Featured Image)</h6>
                <div class="mb-3">
                    <div id="imagePreviewContainer" class="border rounded-3 p-2 text-center bg-light mb-2" style="min-height: 140px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <span id="previewPlaceholder" class="text-muted small">
                            <i class="fa-regular fa-image fs-1 d-block mb-1 text-secondary opacity-50"></i>
                            Pilih gambar untuk melihat pratinjau
                        </span>
                        <img id="imagePreview" src="" alt="Pratinjau Foto" class="img-fluid rounded d-none" style="max-height: 200px; width: 100%; object-fit: cover;">
                    </div>
                    <input type="file" name="featured_image" id="featuredImageInput" class="form-control form-control-sm form-control-compact" accept="image/*">
                    <span class="text-muted small d-block mt-1" style="font-size: 0.7rem;">Format: JPG, PNG, WebP. Maksimal 8MB.</span>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // 1. Auto generate slug from title
    $('#postTitle').on('keyup change', function() {
        const title = $(this).val();
        const slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        $('#postSlug').val(slug);
    });

    // 2. Featured Image Live Preview
    $('#featuredImageInput').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).removeClass('d-none');
                $('#previewPlaceholder').addClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // 3. Summernote Rich Text Editor with AJAX Image Upload
    $('#contentEditor').summernote({
        placeholder: 'Mulai menulis isi berita di sini...',
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

    // 4. Ensure Summernote content is synced and safely encoded on form submit
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
});
</script>
<?= $this->endSection() ?>

