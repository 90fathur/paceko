<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login Redaksi - PACEKO.com') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --paceko-red: #E50914;
            --paceko-dark: #0f172a;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0b1120 0%, #1e293b 60%, #3f1214 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .login-header {
            padding: 30px 24px 20px;
            text-align: center;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }
        .login-body {
            padding: 28px 24px;
        }
        .form-control-compact {
            font-size: 0.8125rem;
            padding: 9px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
        }
        .form-control-compact:focus {
            border-color: var(--paceko-red);
            box-shadow: 0 0 0 3px rgba(229, 9, 20, 0.15);
        }
        .btn-paceko {
            background-color: var(--paceko-red);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 10px;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-paceko:hover {
            background-color: #b80710;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(229, 9, 20, 0.35);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <a href="<?= base_url() ?>">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="PACEKO.com" style="max-height: 48px;" class="mb-2">
        </a>
        <h5 class="fw-bold mb-1 text-dark" style="font-family: 'Outfit', sans-serif;">PORTAL REDAKSI</h5>
        <span class="text-muted small" style="font-size: 0.75rem;">Sistem Manajemen Konten Berita PACEKO.com</span>
    </div>

    <div class="login-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2 px-3 small border-0 mb-3" style="font-size: 0.78rem;">
                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2 px-3 small border-0 mb-3" style="font-size: 0.78rem;">
                <i class="fa-solid fa-circle-check me-1"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="usernameInput" class="form-label small fw-semibold text-secondary">Username atau Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-regular fa-user"></i></span>
                    <input type="text" name="username" id="usernameInput" value="<?= old('username') ?>" class="form-control form-control-compact border-start-0" placeholder="admin / email redaksi" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="passwordInput" class="form-label small fw-semibold text-secondary mb-0">Kata Sandi</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="passwordInput" class="form-control form-control-compact border-start-0" placeholder="••••••••" required>
                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                        <i class="fa-regular fa-eye text-muted" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-paceko">
                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Masuk ke Dashboard
                </button>
            </div>
        </form>

        <div class="mt-4 pt-3 border-top text-center">
            <a href="<?= base_url() ?>" class="text-secondary small text-decoration-none" style="font-size: 0.75rem;">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Website PACEKO.com
            </a>
        </div>
    </div>
</div>

<script>
    const toggleBtn = document.getElementById('togglePassword');
    const pwdInput = document.getElementById('passwordInput');
    const eyeIcon = document.getElementById('eyeIcon');

    toggleBtn.addEventListener('click', function () {
        const type = pwdInput.getAttribute('type') === 'password' ? 'text' : 'password';
        pwdInput.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>

