<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h1 class="fs-5 fw-bold mb-1">Kelola Berita</h1>
        <p class="text-muted small mb-0">Total <?= number_format($totalNews) ?> berita terdaftar di sistem</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <button type="button" id="btnBulkDelete" class="btn btn-outline-danger btn-compact d-none shadow-sm" onclick="submitBulkDelete()">
            <i class="fa-solid fa-trash me-1"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
        </button>
        <a href="<?= base_url('admin/news/create') ?>" class="btn btn-danger btn-compact d-flex align-items-center gap-1 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tulis Berita Baru
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="card-compact mb-3">
    <div class="card-body p-3">
        <form action="<?= base_url('admin/news') ?>" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5 col-12">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" value="<?= esc($filters['search'] ?? '') ?>" class="form-control form-control-compact border-start-0" placeholder="Cari judul berita...">
                </div>
            </div>
            <div class="col-md-3 col-6">
                <select name="category" class="form-select form-select-sm form-control-compact">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat['slug']) ?>" <?= ($filters['category'] ?? '') === $cat['slug'] ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?> (<?= number_format($cat['count']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="status" class="form-select form-select-sm form-control-compact">
                    <option value="">Semua Status</option>
                    <option value="publish" <?= ($filters['status'] ?? '') === 'publish' ? 'selected' : '' ?>>Publish</option>
                    <option value="draft" <?= ($filters['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
            <div class="col-md-2 col-12 d-flex gap-1">
                <button type="submit" class="btn btn-dark btn-compact flex-grow-1">Filter</button>
                <a href="<?= base_url('admin/news') ?>" class="btn btn-outline-secondary btn-compact" title="Reset"><i class="fa-solid fa-rotate-left"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- News Table with Bulk Delete Support -->
<form id="bulkDeleteForm" action="<?= base_url('admin/news/bulk-delete') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="card-compact">
        <div class="table-responsive">
            <table class="table table-compact align-middle">
                <thead>
                    <tr>
                        <th style="width: 38px;" class="text-center">
                            <input type="checkbox" id="selectAllNews" class="form-check-input" title="Pilih Semua di Halaman Ini">
                        </th>
                        <th style="width: 50px;">Foto</th>
                        <th>Judul Berita</th>
                        <th style="width: 140px;">Kategori</th>
                        <th style="width: 80px;">Views</th>
                        <th style="width: 90px;">Status</th>
                        <th style="width: 130px;">Tanggal</th>
                        <th class="text-end" style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($news)): ?>
                        <?php foreach ($news as $post): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="post_ids[]" value="<?= $post['ID'] ?>" class="form-check-input check-news-item">
                                </td>
                                <td>
                                    <div style="width: 44px; height: 34px; border-radius: 4px; overflow: hidden; background: #e2e8f0;">
                                        <img src="<?= get_post_image($post) ?>" alt="" class="w-100 h-100 object-fit-cover" loading="lazy">
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= base_url('berita/' . esc($post['slug'])) ?>" target="_blank" class="fw-semibold text-dark text-decoration-none">
                                        <?= esc($post['post_title']) ?>
                                    </a>
                                    <div class="text-muted" style="font-size: 0.7rem;">
                                        Oleh: <?= esc($post['author_name']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border badge-compact">
                                        <?= esc($post['category_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary"><i class="fa-regular fa-eye me-1"></i><?= number_format($post['views']) ?></span>
                                </td>
                                <td>
                                    <?php if ($post['post_status'] === 'publish'): ?>
                                        <span class="badge bg-success-subtle text-success badge-compact">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning badge-compact">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted" style="white-space: nowrap;">
                                    <?= date('d/m/Y H:i', strtotime($post['post_date'])) ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('berita/' . esc($post['slug'])) ?>" target="_blank" class="btn btn-outline-secondary btn-compact" title="Lihat di Portal">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <a href="<?= base_url('admin/news/edit/' . $post['ID']) ?>" class="btn btn-outline-primary btn-compact" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button" onclick="confirmDelete('<?= base_url('admin/news/delete/' . $post['ID']) ?>')" class="btn btn-outline-danger btn-compact" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open fs-3 d-block mb-2"></i>
                                Tidak ada berita ditemukan sesuai kriteria.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <?php if ($totalPages > 1): ?>
            <div class="card-footer bg-white border-top p-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <span class="text-muted small" style="font-size: 0.75rem;">
                    Halaman <?= $currentPage ?> dari <?= $totalPages ?> (Total <?= number_format($totalNews) ?> berita)
                </span>
                <ul class="pagination pagination-sm mb-0">
                    <?php
                    $queryParams = $_GET;
                    ?>
                    <?php if ($currentPage > 1): ?>
                        <?php $queryParams['page'] = $currentPage - 1; ?>
                        <li class="page-item"><a class="page-link" href="?<?= http_build_query($queryParams) ?>">&laquo;</a></li>
                    <?php endif; ?>

                    <?php 
                    $start = max(1, $currentPage - 2);
                    $end   = min($totalPages, $currentPage + 2);
                    for ($i = $start; $i <= $end; $i++): 
                        $queryParams['page'] = $i;
                    ?>
                        <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                            <a class="page-link <?= ($i === $currentPage) ? 'bg-danger border-danger text-white' : '' ?>" href="?<?= http_build_query($queryParams) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <?php $queryParams['page'] = $currentPage + 1; ?>
                        <li class="page-item"><a class="page-link" href="?<?= http_build_query($queryParams) ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    function updateBulkButton() {
        const checkedCount = $('.check-news-item:checked').length;
        $('#selectedCount').text(checkedCount);
        if (checkedCount > 0) {
            $('#btnBulkDelete').removeClass('d-none');
        } else {
            $('#btnBulkDelete').addClass('d-none');
        }
    }

    $('#selectAllNews').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.check-news-item').prop('checked', isChecked);
        updateBulkButton();
    });

    $(document).on('change', '.check-news-item', function() {
        const total = $('.check-news-item').length;
        const checked = $('.check-news-item:checked').length;
        $('#selectAllNews').prop('checked', total > 0 && total === checked);
        updateBulkButton();
    });
});

function submitBulkDelete() {
    const count = $('.check-news-item:checked').length;
    if (count === 0) return;

    Swal.fire({
        title: 'Hapus Massal ' + count + ' Berita?',
        text: 'Apakah Anda yakin ingin menghapus ' + count + ' berita yang dipilih? Tindakan ini akan menghapus data berita secara permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, Hapus Semua!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $('#bulkDeleteForm').submit();
        }
    });
}
</script>
<?= $this->endSection() ?>

