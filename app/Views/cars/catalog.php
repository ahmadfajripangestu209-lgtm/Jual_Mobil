<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Temukan mobil bekas berkualitas di Sorum Mugi Berkah. Pilihan mobil terawat, harga transparan, dan konsultasi mudah melalui WhatsApp.">
    <meta name="keywords" content="jual mobil, mobil bekas berkualitas, showroom mobil, Sorum Mugi Berkah, mobil bekas Jakarta, CodeIgniter 4">
    <meta name="theme-color" content="#0b192c">
    <title>Jual Mobil Berkualitas | Sorum Mugi Berkah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">
    <link rel="stylesheet" href="<?= app_path('assets/css/catalog.css') ?>">
    <link rel="stylesheet" href="<?= app_path('assets/css/site-images.css') ?>">
    <link rel="stylesheet" href="<?= app_path('assets/css/location.css') ?>">
    <link rel="stylesheet" href="<?= app_path('assets/css/vehicle-detail.css') ?>">
</head>
<body>
    <div class="topline">
        <div class="container topline-inner">
            <span><strong>Showroom mobil pilihan</strong> &nbsp;•&nbsp; Temukan teman perjalanan berikutnya</span>
            <div class="topline-meta"><span>Mugi Berkah Mobilindo</span><span>Konsultasi via WhatsApp</span></div>
        </div>
    </div>
    <header class="site-header">
        <div class="container nav-inner">
            <a class="brand" href="<?= app_path('/') ?>" aria-label="Sorum Mugi Berkah - Beranda">
                <span class="brand-mark">MB</span>
                <span class="brand-name">MUGI BERKAH<small>MOBILINDO</small></span>
            </a>
            <nav class="nav-links" id="nav-links" aria-label="Navigasi utama">
                <a href="#beranda" class="active">Beranda</a>
                <a href="#katalog">Katalog Mobil</a>
                <a href="#tentang">Tentang Kami</a>
                <a href="#lokasi">Lokasi</a>
                <a href="#kontak">Kontak</a>
            </nav>
            <div class="nav-actions">
                <a class="nav-phone" href="tel:088707077027">0887-0707-7027</a>
                <a class="btn btn-gold btn-small" href="https://wa.me/6288707077027?text=Halo%20Mugi%20Berkah%2C%20saya%20ingin%20bertanya%20tentang%20mobil." target="_blank" rel="noopener">Hubungi Kami <span aria-hidden="true">↗</span></a>
                <button class="menu-toggle" id="menu-toggle" aria-label="Buka menu" aria-expanded="false">☰</button>
            </div>
        </div>
    </header>

    <main>
        <section class="hero <?= ! empty($siteImages['hero']) ? 'has-custom-image' : '' ?>" id="beranda"<?= ! empty($siteImages['hero']) ? ' style="--hero-image: url(\'' . esc(app_path($siteImages['hero']), 'attr') . '\')"' : '' ?>>
            <div class="container hero-inner">
                <div class="hero-copy">
                    <div class="eyebrow">Temukan mobil impian Anda</div>
                    <h1>Perjalanan baru,<br><span>dimulai di sini.</span></h1>
                    <p>Pilihan mobil berkualitas dengan kondisi terpilih, harga transparan, dan proses yang nyaman. Kami siap menemani setiap perjalanan Anda.</p>
                    <div class="hero-actions">
                        <a class="btn btn-gold" href="#katalog">Jelajahi Katalog <span aria-hidden="true">→</span></a>
                        <a class="btn btn-outline" href="https://wa.me/6288707077027?text=Halo%20Mugi%20Berkah%2C%20saya%20ingin%20konsultasi%20mobil." target="_blank" rel="noopener"><span aria-hidden="true">☏</span> Konsultasi Gratis</a>
                    </div>
                    <div class="hero-note"><span><b>✓</b> Unit terinspeksi</span><span><b>✓</b> Harga transparan</span><span><b>✓</b> Siap test drive</span></div>
                </div>
                <div class="hero-side">Mugi Berkah Mobilindo</div>
            </div>
        </section>

        <section class="benefit-row" aria-label="Keunggulan showroom">
            <div class="container benefit-inner">
                <div class="benefit"><span class="benefit-icon">◇</span><span><strong>Unit Terpilih</strong><small>Inspeksi sebelum dijual</small></span></div>
                <div class="benefit"><span class="benefit-icon">⌂</span><span><strong>Harga Transparan</strong><small>Tanpa biaya tersembunyi</small></span></div>
                <div class="benefit"><span class="benefit-icon">♧</span><span><strong>Proses Mudah</strong><small>Dibantu sampai selesai</small></span></div>
                <div class="benefit"><span class="benefit-icon">♡</span><span><strong>Layanan Terpercaya</strong><small>Ramah dan profesional</small></span></div>
            </div>
        </section>

        <section class="catalog-section" id="katalog">
            <div class="container">
                <div class="section-head">
                    <div><span class="section-kicker">Koleksi pilihan</span><h2>Temukan mobil Anda</h2><p>Pilihan unit terbaik yang siap menemani perjalanan Anda.</p></div>
                    <a class="view-all" href="#mobil-grid">Lihat semua mobil &nbsp;→</a>
                </div>
                <div class="filter-panel" role="search">
                    <label class="filter-field"><span aria-hidden="true">⌕</span><input id="car-search" type="search" placeholder="Cari merek atau model mobil..." aria-label="Cari merek atau model"></label>
                    <label class="filter-field"><select id="brand-filter" aria-label="Pilih merek"><option value="">Semua merek</option><?php foreach ($brands as $brand): ?><option value="<?= esc($brand) ?>"><?= esc($brand) ?></option><?php endforeach; ?></select><span aria-hidden="true">⌄</span></label>
                    <label class="filter-field"><select id="price-filter" aria-label="Pilih rentang harga"><option value="">Semua harga</option><option value="200000000">Di bawah Rp 200 juta</option><option value="300000000">Di bawah Rp 300 juta</option><option value="400000000">Di bawah Rp 400 juta</option><option value="500000000">Di bawah Rp 500 juta</option></select><span aria-hidden="true">⌄</span></label>
                    <label class="filter-field"><select id="sort-filter" aria-label="Urutkan mobil"><option value="">Urutkan: Pilihan kami</option><option value="price-asc">Harga terendah</option><option value="price-desc">Harga tertinggi</option></select><span aria-hidden="true">⌄</span></label>
                    <button class="filter-search" id="filter-submit" type="button">Cari Mobil</button>
                </div>
                <div class="quick-tags"><span>Merek populer:</span><button type="button" class="tag" data-brand="Toyota"><img src="https://cdn.simpleicons.org/toyota/EB0A1E" alt="" aria-hidden="true" width="15" height="15" loading="lazy">Toyota</button><button type="button" class="tag" data-brand="Isuzu"><img src="<?= app_path('assets/images/isuzu-logo.svg') ?>" alt="" aria-hidden="true" width="40" height="14">Isuzu</button><button type="button" class="tag" data-brand="Mitsubishi"><img src="https://cdn.simpleicons.org/mitsubishi/E60012" alt="" aria-hidden="true" width="15" height="15" loading="lazy">Mitsubishi</button><button type="button" class="tag" data-brand="Suzuki"><img src="https://cdn.simpleicons.org/suzuki/E30613" alt="" aria-hidden="true" width="15" height="15" loading="lazy">Suzuki</button><span id="result-count"><?= count($cars) ?> mobil tersedia</span></div>
                <p class="inventory-note">Daftar kendaraan dan harga saat ini merupakan data contoh. Silakan sesuaikan dengan unit tersedia di showroom.</p>
                <div class="car-grid" id="car-grid">
                    <?php foreach ($cars as $car): ?>
                        <?php $searchText = strtolower($car['brand'] . ' ' . ($car['variant'] ?? '') . ' ' . $car['name']); ?>
                        <?php $gallery = $car['gallery'] ?? [$car['image'] ?? $car['image_url'] ?? '']; ?>
                        <article class="car-card" data-search="<?= esc($searchText, 'attr') ?>" data-brand="<?= esc($car['brand'], 'attr') ?>" data-price="<?= (int) $car['price'] ?>">
                            <div class="car-image">
                                <img src="<?= esc(($gallery[0] ?? $car['image'] ?? $car['image_url'] ?? ''), 'attr') ?>" alt="<?= esc($car['name'], 'attr') ?> bekas berkualitas" loading="lazy">
                                <?php if (! empty($car['badge'])): ?><span class="car-badge"><?= esc($car['badge']) ?></span><?php endif; ?>
                                <button class="heart-btn" type="button" aria-label="Simpan <?= esc($car['name'], 'attr') ?> ke favorit" aria-pressed="false">♡</button>
                            </div>
                            <div class="car-content">
                                <div class="car-title-row"><h3 class="car-title"><?= esc($car['name']) ?></h3><span class="car-year"><?= esc((string) $car['year']) ?></span></div>
                                <div class="car-price">Rp <?= number_format((float) $car['price'], 0, ',', '.') ?></div>
                                <div class="car-specs"><span>◷ &nbsp;<?= number_format((int) $car['mileage'], 0, ',', '.') ?> km</span><span>⚙ &nbsp;<?= esc($car['transmission']) ?></span><span>⛽ &nbsp;<?= esc($car['fuel']) ?></span><span>◈ &nbsp;<?= esc($car['color'] ?? '—') ?></span></div>
                                <div class="car-footer"><a class="details-cta" href="<?= app_path('mobil/' . rawurlencode((string) ($car['slug'] ?? ''))) ?>">Lihat detail <span aria-hidden="true">→</span></a></div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <div class="empty-state" id="empty-state"><span aria-hidden="true">⌕</span><strong>Mobil tidak ditemukan</strong><span>Coba ubah kata kunci atau filter pencarian Anda.</span></div>
                </div>
            </div>
        </section>

        <section class="about-section" id="tentang">
            <div class="container about-grid">
                <div class="about-art <?= ! empty($siteImages['about']) ? 'has-custom-image' : '' ?>"<?= ! empty($siteImages['about']) ? ' style="--about-image: url(\'' . esc(app_path($siteImages['about']), 'attr') . '\')"' : '' ?>><div class="about-art-label"><strong>Teman perjalanan Anda</strong><small>Dipilih dengan sepenuh hati</small></div></div>
                <div class="about-copy"><span class="section-kicker">Lebih dari sekadar showroom</span><h2>Kepercayaan Anda,<br>prioritas kami.</h2><p>Di Mugi Berkah Mobilindo, kami percaya setiap perjalanan istimewa dimulai dengan pilihan yang tepat. Karena itu, setiap unit kami pilih dengan teliti dan setiap pelanggan dilayani dengan sepenuh hati.</p>
                    <ul class="check-list"><li><i>✓</i> Pilihan unit untuk beragam kebutuhan</li><li><i>✓</i> Konsultasi kendaraan melalui WhatsApp</li><li><i>✓</i> Tim kami siap membantu proses pembelian Anda</li></ul>
                    <a class="btn btn-navy" href="https://wa.me/6288707077027?text=Halo%20Mugi%20Berkah%2C%20saya%20ingin%20bertanya." target="_blank" rel="noopener">Kenali Mugi Berkah <span aria-hidden="true">→</span></a>
                    <div class="stat-strip"><div><strong>Siap</strong><small>Membantu kebutuhan Anda</small></div><div><strong>Pilihan</strong><small>Unit kendaraan</small></div><div><strong>Mudah</strong><small>Konsultasi langsung</small></div></div>
                </div>
            </div>
        </section>

        <section class="location-section" id="lokasi">
            <div class="container">
                <div class="location-heading">
                    <div>
                        <span class="section-kicker">Kunjungi showroom kami</span>
                        <h2>Temukan kami di Jambi</h2>
                        <p>Datang langsung untuk melihat pilihan mobil dan berkonsultasi dengan tim kami.</p>
                    </div>
                    <a class="btn btn-navy location-directions" href="https://www.google.com/maps/dir/?api=1&amp;destination=Showroom%20Mugiberkah%2C%208HVW%2B3XC%2C%20Jl.%20Marsda%20Surya%20Dharma%2C%20Paal%20Sembilan%2C%20Kenali%20Asam%20Bawah%2C%20Kota%20Jambi%2C%20Jambi" target="_blank" rel="noopener">Petunjuk arah <span aria-hidden="true">↗</span></a>
                </div>
                <div class="location-card">
                    <div class="location-map">
                        <iframe
                            src="https://www.google.com/maps?output=embed&amp;q=Showroom%20Mugiberkah%2C%208HVW%2B3XC%2C%20Jl.%20Marsda%20Surya%20Dharma%2C%20Paal%20Sembilan%2C%20Kenali%20Asam%20Bawah%2C%20Kota%20Jambi%2C%20Jambi"
                            title="Peta lokasi Showroom Mugiberkah di Jambi"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <div class="location-address">
                        <span class="location-pin" aria-hidden="true">⌖</span>
                        <div>
                            <strong>Showroom Mugiberkah</strong>
                            <p>8HVW+3XC, Jl. Marsda Surya Dharma, Paal Sembilan, Kenali Asam Bawah, Kota Jambi, Jambi</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-cta" id="kontak"><div class="container contact-inner"><div><h2>Masih mencari mobil yang tepat?</h2><p>Ceritakan kebutuhan Anda. Tim Mugi Berkah siap membantu menemukan pilihan terbaik.</p></div><div class="contact-actions"><a class="btn btn-gold" href="https://wa.me/6288707077027?text=Halo%20Mugi%20Berkah%2C%20bantu%20saya%20mencari%20mobil%20yang%20tepat." target="_blank" rel="noopener">Chat WhatsApp <svg class="whatsapp-contact-icon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true" focusable="false"><path d="M20.52 3.48A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.33.16 11.89c0 2.1.55 4.14 1.59 5.95L.05 24l6.32-1.66a11.9 11.9 0 0 0 5.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 0 0-3.43-8.42ZM12.06 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.89 9.89-9.89 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.89-9.88 9.89Zm5.42-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.18.2-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51l-.57-.01c-.2 0-.52.07-.79.37-.28.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.63.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z"/></svg></a><a class="btn btn-outline" href="tel:088707077027">Telepon Kami</a></div></div></section>
    </main>

    <footer class="site-footer"><div class="container"><div class="footer-top"><div class="footer-about"><a class="brand" href="<?= app_path('/') ?>"><span class="brand-mark">MB</span><span class="brand-name">MUGI BERKAH<small>MOBILINDO</small></span></a><p>Temukan mobil pilihan untuk perjalanan yang lebih berarti. Layanan ramah, unit terpilih, dan proses yang nyaman untuk Anda.</p></div><div class="footer-links"><div><strong>Jelajahi</strong><a href="#katalog">Katalog Mobil</a><a href="#tentang">Tentang Kami</a><a href="#lokasi">Lokasi showroom</a><a href="#kontak">Hubungi Kami</a></div><div><strong>Hubungi</strong><a href="tel:088707077027">0887-0707-7027</a><a href="https://wa.me/6288707077027" target="_blank" rel="noopener">WhatsApp showroom</a><a href="#lokasi">Mugi Berkah Mobilindo</a><a href="<?= app_path('admin/login') ?>">Login admin</a></div></div></div><div class="footer-bottom"><span>© <?= date('Y') ?> Mugi Berkah Mobilindo. Hak cipta dilindungi.</span><span>Dibuat untuk perjalanan Anda.</span></div></div></footer>
    <a class="whatsapp-float" href="https://wa.me/6288707077027?text=Halo%20Mugi%20Berkah%2C%20saya%20ingin%20bertanya%20tentang%20mobil." target="_blank" rel="noopener" aria-label="Chat WhatsApp dengan Mugi Berkah">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.52 3.48A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.33.16 11.89c0 2.1.55 4.14 1.59 5.95L.05 24l6.32-1.66a11.9 11.9 0 0 0 5.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 0 0-3.43-8.42ZM12.06 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.89 9.89-9.89 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.89-9.88 9.89Zm5.42-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.18.2-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51l-.57-.01c-.2 0-.52.07-.79.37-.28.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.63.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z"/></svg>
    </a>
    <div class="toast" id="toast" role="status" aria-live="polite"></div>
    <script src="<?= app_path('assets/js/catalog.js') ?>" defer></script>
</body>
</html>
