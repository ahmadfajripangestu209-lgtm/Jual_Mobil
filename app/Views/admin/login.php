<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0b192c">
    <title>Login Admin | Mugi Berkah Mobilindo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?= app_path('assets/css/admin.css') ?>">
</head>
<body class="admin-login-page">
    <main class="login-layout">
        <section class="login-showcase">
            <a class="admin-brand" href="<?= app_path('/') ?>"><span class="admin-brand-mark">MB</span><span>MUGI BERKAH<small>MOBILINDO</small></span></a>
            <div class="showcase-copy"><span class="admin-eyebrow">Portal pengelola showroom</span><h1>Kelola stok.<br><em>Layani lebih baik.</em></h1><p>Dashboard internal Mugi Berkah Mobilindo untuk memantau stok dan aktivitas katalog showroom.</p></div>
            <div class="showcase-footer"><span>Ruang kerja administrator</span><span>01 — MUGI BERKAH</span></div>
        </section>
        <section class="login-panel">
            <div class="login-card">
                <a class="back-link" href="<?= app_path('/') ?>">← &nbsp; Kembali ke katalog</a>
                <div class="login-heading"><span class="login-icon">↗</span><span class="admin-eyebrow">Selamat datang kembali</span><h2>Masuk ke dashboard</h2><p>Gunakan akun admin showroom untuk melanjutkan.</p></div>
                <?php if (session()->getFlashdata('login_success')): ?><div class="notice notice-success" role="status"><?= esc(session()->getFlashdata('login_success')) ?></div><?php endif; ?>
                <?php if (session()->getFlashdata('login_error')): ?><div class="notice notice-error" role="alert"><?= esc(session()->getFlashdata('login_error')) ?></div><?php endif; ?>
                <form action="<?= app_path('admin/login') ?>" method="post" class="login-form">
                    <?= csrf_field() ?>
                    <label for="email">Alamat email</label>
                    <input id="email" name="email" type="email" autocomplete="username" placeholder="admin@showroom.com" value="<?= esc((string) old('email', ''), 'attr') ?>" required autofocus>
                    <div class="password-label"><label for="password">Kata sandi</label><span>Rahasia akun Anda</span></div>
                    <div class="password-input"><input id="password" name="password" type="password" autocomplete="current-password" placeholder="Masukkan kata sandi" required><button type="button" class="password-toggle" aria-label="Tampilkan kata sandi" aria-pressed="false">Lihat</button></div>
                    <button type="submit" class="login-submit">Masuk ke Dashboard <span>→</span></button>
                </form>
                <div class="login-security"><span aria-hidden="true">▣</span> Halaman ini khusus untuk administrator Mugi Berkah.</div>
                <p class="login-contact">Butuh bantuan akses? <a href="https://wa.me/6288707077027?text=Halo%20Mugi%20Berkah%2C%20saya%20membutuhkan%20bantuan%20akses%20admin." target="_blank" rel="noopener">Hubungi pemilik showroom</a></p>
            </div>
        </section>
    </main>
    <script>
      document.querySelector('.password-toggle').addEventListener('click', (event) => {
        const input = document.querySelector('#password');
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        event.currentTarget.textContent = visible ? 'Sembunyikan' : 'Lihat';
        event.currentTarget.setAttribute('aria-pressed', visible ? 'true' : 'false');
        event.currentTarget.setAttribute('aria-label', visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
      });
    </script>
</body>
</html>
