<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Pengaturan Admin | Mugi Berkah Mobilindo</title>
    <link rel="stylesheet" href="<?= app_path('assets/css/admin.css') ?>">
    <link rel="stylesheet" href="<?= app_path('assets/css/settings.css') ?>">
</head>
<body class="dashboard-page">
    <main class="action-page">
        <header class="action-header"><a class="admin-brand" href="<?= app_path('admin/dashboard') ?>"><span class="admin-brand-mark">MB</span><span>MUGI BERKAH<small>MOBILINDO</small></span></a><a class="back-link" href="<?= app_path('admin/dashboard') ?>">← Kembali ke dashboard</a></header>
        <div class="action-content">
            <div class="action-heading"><div><span class="admin-eyebrow">PENGELOLAAN WEBSITE</span><h1>Pengaturan</h1><p>Kelola foto beranda dan tentang kami, serta keamanan akun admin.</p></div></div>
            <?php if (session()->getFlashdata('settings_error')): ?><div class="notice notice-error" role="alert"><?= esc(session()->getFlashdata('settings_error')) ?></div><?php endif; ?>
            <?php if (session()->getFlashdata('settings_success')): ?><div class="notice notice-success" role="status"><?= esc(session()->getFlashdata('settings_success')) ?></div><?php endif; ?>
            <form action="<?= app_path('admin/pengaturan') ?>" method="post" enctype="multipart/form-data" class="action-card settings-card">
                <?= csrf_field() ?>
                <div class="form-section"><h2>Foto website</h2><p>Unggah JPG, PNG, atau WEBP maksimal 5 MB per foto. Pilih file hanya untuk mengganti foto yang sudah ada. Kata sandi saat ini diperlukan untuk menyimpan perubahan.</p><div class="site-photo-grid">
                    <label class="site-photo-field">Foto beranda
                        <?php if (! empty($siteImages['hero'])): ?><img class="site-photo-preview" src="<?= esc(app_path($siteImages['hero']), 'attr') ?>" alt="Foto beranda saat ini"><?php else: ?><span class="site-photo-placeholder">Belum ada foto khusus. Foto bawaan website masih digunakan.</span><?php endif; ?>
                        <input name="hero_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    </label>
                    <label class="site-photo-field">Foto bagian Tentang Kami
                        <?php if (! empty($siteImages['about'])): ?><img class="site-photo-preview" src="<?= esc(app_path($siteImages['about']), 'attr') ?>" alt="Foto Tentang Kami saat ini"><?php else: ?><span class="site-photo-placeholder">Belum ada foto khusus. Foto bawaan website masih digunakan.</span><?php endif; ?>
                        <input name="about_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    </label>
                </div></div>
                <div class="form-section"><h2>Informasi akun</h2><p>Kata sandi saat ini wajib untuk menyimpan perubahan.</p><div class="admin-form-grid">
                    <label>Nama admin<input name="name" value="<?= esc((string) old('name', $admin['name'] ?? ''), 'attr') ?>" maxlength="100" required></label>
                    <label>Email admin<input name="email" type="email" value="<?= esc((string) old('email', $admin['email'] ?? ''), 'attr') ?>" maxlength="190" required></label>
                    <label class="full-width">Kata sandi saat ini<input name="current_password" type="password" autocomplete="current-password" required></label>
                </div></div>
                <div class="form-section password-section"><h2>Ganti kata sandi <span>(opsional)</span></h2><p>Kosongkan jika tidak ingin mengganti kata sandi. Minimal 10 karakter.</p><div class="admin-form-grid">
                    <label>Kata sandi baru<input name="new_password" type="password" autocomplete="new-password" minlength="10"></label>
                    <label>Konfirmasi kata sandi<input name="confirm_password" type="password" autocomplete="new-password" minlength="10"></label>
                </div></div>
                <div class="form-actions"><a class="secondary-action" href="<?= app_path('admin/dashboard') ?>">Batal</a><button class="dashboard-cta" type="submit">Simpan pengaturan <span>→</span></button></div>
            </form>
            <footer class="dashboard-footer"><span>© <?= date('Y') ?> Mugi Berkah Mobilindo</span><span>Pengaturan website dan keamanan akun</span></footer>
        </div>
    </main>
</body>
</html>
