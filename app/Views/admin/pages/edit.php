<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Edit Halaman</h1>
        <p class="text-muted small mb-0">Halaman: <?= esc($page['post_title']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('halaman/' . esc($page['post_name'])) ?>" target="_blank" class="btn btn-outline-danger btn-compact">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Pratinjau
        </a>
        <a href="<?= base_url('admin/pages') ?>" class="btn btn-outline-secondary btn-compact">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= base_url('admin/pages/update/' . $page['ID']) ?>" method="POST">
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-compact p-4">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="pageTitle" value="<?= old('title', $page['post_title']) ?>" class="form-control form-control-compact fw-bold fs-6" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">URL Slug</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 small" style="font-size: 0.75rem;"><?= base_url('halaman/') ?></span>
                        <input type="text" name="slug" id="pageSlug" value="<?= old('slug', $page['post_name']) ?>" class="form-control form-control-compact border-start-0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Ringkasan / Deskripsi Pengantar</label>
                    <textarea name="excerpt" rows="2" class="form-control form-control-compact"><?= old('excerpt', $page['post_excerpt']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Isi Konten Halaman <span class="text-danger">*</span></label>
                    <textarea name="content" id="pageContentEditor" class="form-control" rows="14"><?= old('content', $page['post_content']) ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-compact p-3">
                <h6 class="fw-bold small border-bottom pb-2 mb-3">Status Publikasi</h6>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Status</label>
                    <select name="status" class="form-select form-select-sm form-control-compact">
                        <option value="publish" <?= old('status', $page['post_status']) === 'publish' ? 'selected' : '' ?>>Publish (Tayang Langsung)</option>
                        <option value="draft" <?= old('status', $page['post_status']) === 'draft' ? 'selected' : '' ?>>Draft (Konsep)</option>
                    </select>
                </div>

                <hr class="my-3">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger btn-compact py-2 fw-bold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('admin/pages') ?>" class="btn btn-outline-secondary btn-compact">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#pageContentEditor').summernote({
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

    $('form').on('submit', function() {
        if ($('#pageContentEditor').summernote('isEmpty')) {
            $('#pageContentEditor').val('');
        } else {
            var rawHtml = $('#pageContentEditor').summernote('code');
            try {
                var safeBase64 = 'base64:' + btoa(unescape(encodeURIComponent(rawHtml)));
                $('#pageContentEditor').val(safeBase64);
            } catch (e) {
                $('#pageContentEditor').val(rawHtml);
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
            success: function(response) {
                if (response.success && response.url) {
                    $('#pageContentEditor').summernote('insertImage', response.url, function ($image) {
                        $image.addClass('img-fluid rounded my-3');
                    });
                }
            }
        });
    }
});
</script>
<?= $this->endSection() ?>

