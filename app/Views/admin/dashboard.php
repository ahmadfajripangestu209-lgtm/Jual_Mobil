<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0b192c">
    <title>Dashboard Admin | Mugi Berkah Mobilindo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?= app_path('assets/css/admin.css') ?>">
</head>
<body class="dashboard-page">
    <div class="dashboard-shell">
        <aside class="dashboard-sidebar" id="dashboard-sidebar">
            <a class="admin-brand" href="<?= app_path('admin/dashboard') ?>"><span class="admin-brand-mark">MB</span><span>MUGI BERKAH<small>MOBILINDO</small></span></a>
            <div class="sidebar-label">MENU UTAMA</div>
            <nav class="sidebar-nav" aria-label="Navigasi admin">
                <a class="sidebar-link current" href="<?= app_path('admin/dashboard') ?>"><span>▦</span>Ringkasan</a>
                <a class="sidebar-link" href="<?= app_path('/#katalog') ?>"><span>▤</span>Katalog mobil</a>
                <a class="sidebar-link" href="<?= app_path('admin/mobil/tambah') ?>"><span>＋</span>Tambah kendaraan</a>
                <a class="sidebar-link" href="<?= app_path('admin/kategori') ?>"><span>◇</span>Kategori</a>
                <a class="sidebar-link" href="<?= app_path('admin/pengaturan') ?>"><span>⚙</span>Pengaturan</a>
                <a class="sidebar-link" href="<?= app_path('admin/export/csv') ?>"><span>⇩</span>Export CSV</a>
            </nav>
            <div class="sidebar-spacer"></div>
            <div class="sidebar-help"><span class="help-dot"></span><strong>Showroom terhubung</strong><small>WhatsApp 0887-0707-7027</small><a href="https://wa.me/6288707077027" target="_blank" rel="noopener">Buka WhatsApp ↗</a></div>
            <a class="sidebar-link public-link" href="<?= app_path('/') ?>" target="_blank" rel="noopener"><span>↗</span>Lihat website</a>
            <div class="sidebar-profile"><span class="profile-avatar"><?= esc(strtoupper(substr((string) session()->get('admin_name'), 0, 1))) ?></span><span class="profile-text"><strong><?= esc((string) session()->get('admin_name')) ?></strong><small>Administrator</small></span><form action="<?= app_path('admin/logout') ?>" method="post"><?= csrf_field() ?><button class="logout-button" type="submit" aria-label="Keluar dari dashboard" title="Keluar">⇥</button></form></div>
        </aside>
        <main class="dashboard-main">
            <header class="dashboard-topbar"><button class="sidebar-toggle" id="sidebar-toggle" type="button" aria-label="Buka navigasi">☰</button><div class="breadcrumb">Mugi Berkah <span>/</span> <strong>Ringkasan</strong></div><a class="topbar-site" href="<?= app_path('/') ?>" target="_blank" rel="noopener">Lihat website ↗</a></header>
            <div class="dashboard-content">
                <div class="dashboard-welcome"><div><span class="admin-eyebrow">RINGKASAN SHOWROOM</span><h1>Selamat datang, <?= esc((string) session()->get('admin_name')) ?>.</h1><p>Pantau ringkasan stok kendaraan Mugi Berkah hari ini.</p></div><a class="dashboard-cta" href="<?= app_path('admin/mobil/tambah') ?>">Tambah kendaraan <span>＋</span></a></div>
                <?php if (session()->getFlashdata('action_success')): ?><div class="notice notice-success" role="status"><?= esc(session()->getFlashdata('action_success')) ?></div><?php endif; ?>
                <?php if (session()->getFlashdata('dashboard_error')): ?><div class="notice notice-error" role="alert"><?= esc(session()->getFlashdata('dashboard_error')) ?></div><?php endif; ?>
                <section class="quick-actions" aria-label="Aksi admin"><a class="quick-action" href="<?= app_path('admin/mobil/tambah') ?>"><span class="quick-action-icon gold-icon">＋</span><span><strong>Tambah kendaraan</strong><small>Catat unit baru</small></span><b>→</b></a><a class="quick-action" href="<?= app_path('admin/kategori') ?>"><span class="quick-action-icon blue-icon">◇</span><span><strong>Kategori</strong><small>Kelola kelompok merek</small></span><b>→</b></a><a class="quick-action" href="<?= app_path('admin/pengaturan') ?>"><span class="quick-action-icon purple-icon">⚙</span><span><strong>Pengaturan</strong><small>Atur akun admin</small></span><b>→</b></a><a class="quick-action" href="<?= app_path('admin/export/csv') ?>"><span class="quick-action-icon green-icon">⇩</span><span><strong>Export CSV</strong><small>Unduh seluruh inventaris</small></span><b>↓</b></a></section>
                <section class="metric-grid" aria-label="Statistik inventaris">
                    <article class="metric-card"><div class="metric-top"><span>Total stok mobil</span><span class="metric-icon gold-icon">▤</span></div><strong><?= number_format((int) $stats['total'], 0, ',', '.') ?></strong><small>Semua unit di inventaris</small></article>
                    <article class="metric-card"><div class="metric-top"><span>Unit tersedia</span><span class="metric-icon green-icon">✓</span></div><strong><?= number_format((int) $stats['available'], 0, ',', '.') ?></strong><small>Siap ditanyakan pelanggan</small></article>
                    <article class="metric-card"><div class="metric-top"><span>Unit pilihan</span><span class="metric-icon blue-icon">☆</span></div><strong><?= number_format((int) $stats['featured'], 0, ',', '.') ?></strong><small>Ditandai sebagai unggulan</small></article>
                    <article class="metric-card"><div class="metric-top"><span>Nilai harga stok</span><span class="metric-icon purple-icon">Rp</span></div><strong class="metric-value">Rp <?= number_format((int) $stats['value'], 0, ',', '.') ?></strong><small>Total harga unit tersedia</small></article>
                </section>
                <section class="inventory-panel">
                    <div class="panel-heading"><div><span class="admin-eyebrow">INVENTARIS</span><h2>Mobil terbaru</h2><p>Unit yang terakhir ditambahkan ke katalog.</p></div><a class="panel-link" href="<?= app_path('/#katalog') ?>">Lihat katalog <span>→</span></a></div>
                    <div class="inventory-table-wrap"><table class="inventory-table"><thead><tr><th>UNIT MOBIL</th><th>TAHUN</th><th>HARGA</th><th>STATUS</th><th></th></tr></thead><tbody>
                        <?php foreach ($cars as $car): ?>
                            <?php $dashboardImage = (string) ($car['image'] ?? $car['image_url'] ?? ''); if ($dashboardImage !== '' && ! preg_match('#^https?://#i', $dashboardImage)) $dashboardImage = app_path($dashboardImage); ?>
                            <tr><td><div class="unit-cell"><img src="<?= esc($dashboardImage, 'attr') ?>" alt="" loading="lazy"><span><strong><?= esc($car['name']) ?></strong><small><?= esc($car['brand']) ?> · <?= esc($car['transmission']) ?></small></span></div></td><td><?= esc((string) $car['year']) ?></td><td class="unit-price">Rp <?= number_format((float) $car['price'], 0, ',', '.') ?></td><td><span class="status-pill <?= ($car['status'] ?? 'tersedia') === 'tersedia' ? 'status-available' : 'status-muted' ?>"><i></i><?= esc(ucfirst((string) ($car['status'] ?? 'tersedia'))) ?></span></td><td><a class="row-action edit-action" href="<?= app_path('admin/mobil/' . (int) $car['id'] . '/edit') ?>">Edit</a></td></tr>
                        <?php endforeach; ?>
                        <?php if ($cars === []): ?><tr><td colspan="5"><div class="table-empty"><strong>Belum ada unit di inventaris</strong><span>Jalankan seeder mobil untuk mengisi data contoh, atau tambahkan mobil ke database.</span></div></td></tr><?php endif; ?>
                    </tbody></table></div>
                    <div class="panel-foot"><span>Menampilkan <?= count($cars) ?> unit terbaru</span><span>Data inventaris showroom</span></div>
                </section>
                <footer class="dashboard-footer"><span>© <?= date('Y') ?> Mugi Berkah Mobilindo</span><span>Dashboard pengelola showroom</span></footer>
            </div>
        </main>
    </div>
    <script>
      document.querySelector('#sidebar-toggle').addEventListener('click', () => document.querySelector('#dashboard-sidebar').classList.toggle('sidebar-open'));
    </script>
</body>
</html>
