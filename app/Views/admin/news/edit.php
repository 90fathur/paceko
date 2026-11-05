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
            <div class="card-compact p-3">
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
        </div>

        <!-- Sidebar Options (4 cols) -->
        <div class="col-lg-4">
            <!-- Publish Actions -->
            <div class="card-compact p-3 mb-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Status Publikasi</h6>
                
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Status Berita</label>
                    <select name="status" class="form-select form-select-sm form-control-compact">
                        <option value="publish" <?= old('status', $news['post_status']) === 'publish' ? 'selected' : '' ?>>Publish (Tayang di Portal)</option>
                        <option value="draft" <?= old('status', $news['post_status']) === 'draft' ? 'selected' : '' ?>>Draft (Simpan Konsep)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kategori Berita <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select form-select-sm form-control-compact" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['term_id'] ?>" <?= old('category_id', $news['category_id']) == $cat['term_id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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

            <!-- Featured Image Upload -->
            <div class="card-compact p-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Foto Utama (Featured Image)</h6>
                <div class="mb-3">
                    <div id="imagePreviewContainer" class="border rounded-3 p-2 text-center bg-light mb-2" style="min-height: 140px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img id="imagePreview" src="<?= get_post_image($news) ?>" alt="Pratinjau Foto" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                    </div>
                    <label class="form-label small text-muted">Ganti Foto Utama:</label>
                    <input type="file" name="featured_image" id="featuredImageInput" class="form-control form-control-sm form-control-compact" accept="image/*">
                    <span class="text-muted small d-block mt-1" style="font-size: 0.7rem;">Biarkan kosong jika tidak ingin mengubah foto.</span>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Featured Image Live Preview
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

    // Summernote Rich Text Editor with AJAX Image Upload
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

