<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Kategori Kendaraan | Mugi Berkah Mobilindo</title>
    <link rel="stylesheet" href="<?= app_path('assets/css/admin.css') ?>">
</head>
<body class="dashboard-page">
    <main class="action-page">
        <header class="action-header"><a class="admin-brand" href="<?= app_path('admin/dashboard') ?>"><span class="admin-brand-mark">MB</span><span>MUGI BERKAH<small>MOBILINDO</small></span></a><a class="back-link" href="<?= app_path('admin/dashboard') ?>">← Kembali ke dashboard</a></header>
        <div class="action-content">
            <div class="action-heading"><div><span class="admin-eyebrow">PENGELOMPOKAN INVENTARIS</span><h1>Kategori kendaraan</h1><p>Kategori katalog saat ini mengikuti merek kendaraan yang digunakan pada setiap unit.</p></div><a class="dashboard-cta" href="<?= app_path('admin/mobil/tambah') ?>">Tambah kategori / unit <span>+</span></a></div>
            <?php if (session()->getFlashdata('dashboard_error')): ?><div class="notice notice-error" role="alert"><?= esc(session()->getFlashdata('dashboard_error')) ?></div><?php endif; ?>
            <section class="action-card"><div class="category-list">
                <?php foreach ($categories as $category): ?><article class="category-item"><span class="category-mark"><?= esc(strtoupper(substr((string) $category['brand'], 0, 1))) ?></span><span class="category-name"><strong><?= esc($category['brand']) ?></strong><small>Kategori berdasarkan merek</small></span><span class="category-count"><?= number_format((int) $category['total'], 0, ',', '.') ?> unit</span><a class="row-action" href="<?= app_path('admin/mobil/tambah?brand=' . rawurlencode((string) $category['brand'])) ?>" title="Tambah unit kategori <?= esc($category['brand'], 'attr') ?>" aria-label="Tambah unit kategori <?= esc($category['brand'], 'attr') ?>">+</a></article><?php endforeach; ?>
                <?php if ($categories === []): ?><div class="table-empty"><strong>Belum ada kategori</strong><span>Tambahkan kendaraan untuk membuat kategori merek pertama.</span></div><?php endif; ?>
            </div><div class="category-note">Kategori baru terbentuk otomatis dari kolom “Kategori / merek” saat kendaraan ditambahkan.</div></section>
            <footer class="dashboard-footer"><span>© <?= date('Y') ?> Mugi Berkah Mobilindo</span><span><?= count($categories) ?> kategori terdaftar</span></footer>
        </div>
    </main>
</body>
</html>
