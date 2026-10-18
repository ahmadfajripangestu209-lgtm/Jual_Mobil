<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail <?= esc($car['name']) ?> di Mugi Berkah Mobilindo. Lihat foto, spesifikasi, dan harga kendaraan.">
    <meta name="theme-color" content="#0b192c">
    <title><?= esc($car['name']) ?> | Mugi Berkah Mobilindo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?= app_path('assets/css/catalog.css') ?>">
    <link rel="stylesheet" href="<?= app_path('assets/css/vehicle-detail.css') ?>">
</head>
<body>
    <div class="topline"><div class="container topline-inner"><span><strong>Showroom mobil pilihan</strong> &nbsp;•&nbsp; Temukan teman perjalanan berikutnya</span><div class="topline-meta"><span>Mugi Berkah Mobilindo</span><span>Konsultasi via WhatsApp</span></div></div></div>
    <header class="site-header"><div class="container nav-inner">
        <a class="brand" href="<?= app_path('/') ?>" aria-label="Mugi Berkah Mobilindo - Beranda"><span class="brand-mark">MB</span><span class="brand-name">MUGI BERKAH<small>MOBILINDO</small></span></a>
        <nav class="nav-links" id="nav-links" aria-label="Navigasi utama"><a href="<?= app_path('/') ?>#beranda">Beranda</a><a href="<?= app_path('/') ?>#katalog" class="active">Katalog Mobil</a><a href="<?= app_path('/') ?>#tentang">Tentang Kami</a><a href="<?= app_path('/') ?>#kontak">Kontak</a></nav>
        <div class="nav-actions"><a class="nav-phone" href="tel:088707077027">0887-0707-7027</a><a class="btn btn-gold btn-small" href="https://wa.me/6288707077027?text=Halo%20Mugi%20Berkah%2C%20saya%20ingin%20bertanya%20tentang%20mobil." target="_blank" rel="noopener">Hubungi Kami <span aria-hidden="true">↗</span></a><button class="menu-toggle" id="menu-toggle" type="button" aria-label="Buka menu" aria-expanded="false">☰</button></div>
    </div></header>
    <main class="vehicle-detail-page">
        <div class="container">
            <nav class="detail-breadcrumb" aria-label="Breadcrumb"><a href="<?= app_path('/') ?>">Beranda</a><span>›</span><a href="<?= app_path('/') ?>#katalog">Katalog mobil</a><span>›</span><strong><?= esc($car['name']) ?></strong></nav>
            <section class="vehicle-detail-layout">
                <div class="vehicle-gallery" aria-label="Galeri foto kendaraan">
                    <div class="vehicle-main-photo"><img id="vehicle-main-photo" src="<?= esc($car['gallery'][0] ?? '', 'attr') ?>" alt="<?= esc($car['name'], 'attr') ?>"></div>
                    <?php if (count($car['gallery']) > 1): ?><div class="vehicle-thumbnails" role="group" aria-label="Pilih foto kendaraan"><?php foreach ($car['gallery'] as $index => $image): ?><button class="vehicle-thumbnail <?= $index === 0 ? 'selected' : '' ?>" type="button" data-image="<?= esc($image, 'attr') ?>" data-alt="<?= esc($car['name'] . ', foto ' . ($index + 1), 'attr') ?>" aria-label="Tampilkan foto <?= $index + 1 ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>"><img src="<?= esc($image, 'attr') ?>" alt="" loading="lazy"></button><?php endforeach; ?></div><?php endif; ?>
                    <span class="gallery-counter"><?= number_format(count($car['gallery']), 0, ',', '.') ?> foto kendaraan</span>
                </div>
                <article class="vehicle-detail-info">
                    <span class="section-kicker"><?= esc($car['brand']) ?> · <?= esc((string) $car['year']) ?></span>
                    <h1><?= esc($car['name']) ?></h1>
                    <div class="vehicle-detail-price">Rp <?= number_format((float) $car['price'], 0, ',', '.') ?></div>
                    <div class="vehicle-detail-specs">
                        <div><small>Kilometer</small><strong><?= number_format((int) $car['mileage'], 0, ',', '.') ?> km</strong></div>
                        <div><small>Transmisi</small><strong><?= esc($car['transmission']) ?></strong></div>
                        <div><small>Bahan bakar</small><strong><?= esc($car['fuel']) ?></strong></div>
                        <div><small>Warna</small><strong><?= esc($car['color'] ?? '—') ?></strong></div>
                        <div><small>Varian</small><strong><?= esc($car['variant'] ?? '—') ?></strong></div>
                        <div><small>Status</small><strong><?= esc(ucfirst((string) ($car['status'] ?? 'tersedia'))) ?></strong></div>
                    </div>
                    <div class="vehicle-description"><h2>Deskripsi kendaraan</h2><p><?= esc($car['description'] ?: 'Hubungi showroom untuk informasi lebih lanjut mengenai kendaraan ini.') ?></p></div>
                    <a class="btn btn-gold vehicle-contact" href="https://wa.me/6288707077027?text=<?= rawurlencode('Halo Mugi Berkah, saya tertarik dengan ' . $car['name'] . ' (' . $car['year'] . '). Apakah unit masih tersedia?') ?>" target="_blank" rel="noopener"><svg class="whatsapp-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.52 3.48A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.33.16 11.89c0 2.1.55 4.14 1.59 5.95L.05 24l6.32-1.66a11.9 11.9 0 0 0 5.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 0 0-3.43-8.42ZM12.06 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.89 9.89-9.89 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.89-9.88 9.89Zm5.42-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.18.2-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51l-.57-.01c-.2 0-.52.07-.79.37-.28.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.63.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z"/></svg>Tanya unit via WhatsApp</a>
                    <a class="detail-back-link" href="<?= app_path('/') ?>#katalog">← Kembali ke katalog</a>
                </article>
            </section>
        </div>
    </main>
    <footer class="site-footer"><div class="container"><div class="footer-bottom"><span>© <?= date('Y') ?> Mugi Berkah Mobilindo. Hak cipta dilindungi.</span><a href="<?= app_path('/') ?>#katalog">Kembali ke katalog</a></div></div></footer>
    <script>
      document.querySelectorAll('.vehicle-thumbnail').forEach((button) => {
        button.addEventListener('click', () => {
          const mainPhoto = document.querySelector('#vehicle-main-photo');
          mainPhoto.src = button.dataset.image;
          mainPhoto.alt = button.dataset.alt;
          document.querySelectorAll('.vehicle-thumbnail').forEach((item) => {
            item.classList.toggle('selected', item === button);
            item.setAttribute('aria-pressed', item === button ? 'true' : 'false');
          });
        });
      });
      document.querySelector('#menu-toggle')?.addEventListener('click', () => {
        const menu = document.querySelector('#nav-links');
        const open = menu.classList.toggle('open');
        document.querySelector('#menu-toggle').setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    </script>
</body>
</html>
