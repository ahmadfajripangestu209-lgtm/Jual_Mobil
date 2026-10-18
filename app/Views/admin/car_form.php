<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= ! empty($isEdit) ? 'Edit Kendaraan' : 'Tambah Kendaraan' ?> | Mugi Berkah Mobilindo</title>
    <link rel="stylesheet" href="<?= app_path('assets/css/admin.css') ?>">
</head>
<body class="dashboard-page">
    <main class="action-page">
        <header class="action-header"><a class="admin-brand" href="<?= app_path('admin/dashboard') ?>"><span class="admin-brand-mark">MB</span><span>MUGI BERKAH<small>MOBILINDO</small></span></a><a class="back-link" href="<?= app_path('admin/dashboard') ?>">← Kembali ke dashboard</a></header>
        <div class="action-content">
            <div class="action-heading"><div><span class="admin-eyebrow">INVENTARIS SHOWROOM</span><h1><?= ! empty($isEdit) ? 'Edit kendaraan' : 'Tambah kendaraan' ?></h1><p><?= ! empty($isEdit) ? 'Perbarui detail unit kendaraan di katalog.' : 'Masukkan detail unit agar langsung tampil di katalog kendaraan.' ?></p></div></div>
            <?php
                $formErrors = session()->getFlashdata('form_errors') ?? [];
                $currentImages = json_decode((string) ($car['images'] ?? ''), true);
                if (! is_array($currentImages) || $currentImages === []) {
                    $currentImages = ! empty($car['image']) ? [$car['image']] : [];
                }
            ?>
            <?php if ($formErrors !== []): ?><div class="notice notice-error" role="alert"><?php foreach ($formErrors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?></div><?php endif; ?>
            <form action="<?= ! empty($isEdit) ? app_path('admin/mobil/' . (int) $car['id'] . '/update') : app_path('admin/mobil/simpan') ?>" method="post" enctype="multipart/form-data" class="action-card">
                <?= csrf_field() ?>
                <div class="form-section"><h2>Foto kendaraan</h2><p>Unggah hingga 10 gambar JPG/JPEG, maksimal 5 MB per gambar. Foto pertama menjadi foto utama katalog.</p>
                    <label class="upload-field">Tambah foto JPG/JPEG<input id="car-images-input" name="images[]" type="file" accept=".jpg,.jpeg,image/jpeg" multiple <?= empty($isEdit) ? 'required' : '' ?>><small>Pilih beberapa foto sekaligus. Jika ingin menambah batch lain, pilih lagi—foto yang sudah dipilih akan tetap tersimpan di form sampai tombol Simpan ditekan.</small></label>
                    <p class="upload-selection-status" id="upload-selection-status" aria-live="polite">Belum ada foto baru dipilih.</p>
                    <?php if ($currentImages !== []): ?><div class="image-preview-grid" aria-label="Foto kendaraan tersimpan"><?php foreach ($currentImages as $image): ?><?php $imageUrl = preg_match('#^https?://#i', (string) $image) ? $image : app_path((string) $image); ?><label class="saved-image"><img src="<?= esc($imageUrl, 'attr') ?>" alt="Foto kendaraan"><span><input type="checkbox" name="remove_images[]" value="<?= esc((string) $image, 'attr') ?>"> Hapus foto</span></label><?php endforeach; ?></div><?php endif; ?>
                    <div class="image-preview-grid" id="selected-image-preview" aria-live="polite"></div>
                </div>
                <div class="form-section"><h2>Informasi kendaraan</h2><p>Nama, kategori, tahun, dan detail utama kendaraan.</p><div class="admin-form-grid">
                    <label>Nama kendaraan<input name="name" value="<?= esc((string) old('name', $car['name'] ?? ''), 'attr') ?>" placeholder="Contoh: Toyota Avanza Veloz" maxlength="150" required></label>
                    <label>Kategori / merek<input name="brand" value="<?= esc((string) old('brand', $car['brand'] ?? $defaultBrand ?? ''), 'attr') ?>" placeholder="Contoh: Toyota" maxlength="80" required></label>
                    <label>Varian<input name="variant" value="<?= esc((string) old('variant', $car['variant'] ?? ''), 'attr') ?>" placeholder="Contoh: 1.5 AT Veloz" maxlength="120" required></label>
                    <label>Tahun<input name="year" type="number" min="1900" max="<?= date('Y') + 1 ?>" value="<?= esc((string) old('year', $car['year'] ?? date('Y')), 'attr') ?>" required></label>
                    <label>Harga (Rp)<input name="price" type="number" min="1" step="1000" value="<?= esc((string) old('price', $car['price'] ?? ''), 'attr') ?>" placeholder="268000000" required></label>
                    <label>Kilometer<input name="mileage" type="number" min="0" value="<?= esc((string) old('mileage', $car['mileage'] ?? '0'), 'attr') ?>" required></label>
                    <label>Transmisi<input name="transmission" value="<?= esc((string) old('transmission', $car['transmission'] ?? ''), 'attr') ?>" placeholder="Automatic / Manual" maxlength="30" required></label>
                    <label>Bahan bakar<input name="fuel" value="<?= esc((string) old('fuel', $car['fuel'] ?? ''), 'attr') ?>" placeholder="Bensin / Diesel" maxlength="30" required></label>
                    <label>Warna<input name="color" value="<?= esc((string) old('color', $car['color'] ?? ''), 'attr') ?>" placeholder="Putih" maxlength="40" required></label>
                    <label>Status<select name="status" required><option value="tersedia" <?= old('status', $car['status'] ?? 'tersedia') === 'tersedia' ? 'selected' : '' ?>>Tersedia</option><option value="terjual" <?= old('status', $car['status'] ?? '') === 'terjual' ? 'selected' : '' ?>>Terjual</option></select></label>
                    <label class="checkbox-label"><input type="checkbox" name="featured" value="1" <?= old('featured', $car['featured'] ?? 0) ? 'checked' : '' ?>> Tandai sebagai unit unggulan</label>
                    <label class="full-width">Deskripsi<textarea name="description" rows="4" maxlength="5000" placeholder="Ceritakan kondisi dan keunggulan kendaraan."><?= esc((string) old('description', $car['description'] ?? '')) ?></textarea></label>
                </div></div>
                <div class="form-actions"><a class="secondary-action" href="<?= app_path('admin/dashboard') ?>">Batal</a><button class="dashboard-cta" type="submit"><?= ! empty($isEdit) ? 'Simpan perubahan' : 'Simpan kendaraan' ?> <span>→</span></button></div>
            </form>
            <footer class="dashboard-footer"><span>© <?= date('Y') ?> Mugi Berkah Mobilindo</span><span>Dashboard pengelola showroom</span></footer>
        </div>
    </main>
        <script>
            const imageInput = document.querySelector('#car-images-input');
            const preview = document.querySelector('#selected-image-preview');
            const selectionStatus = document.querySelector('#upload-selection-status');
            const maxImages = 10;
            const savedImagesCount = <?= count($currentImages) ?>;
            let selectedImages = [];

            const remainingSavedImages = () => document.querySelectorAll('input[name="remove_images[]"]:not(:checked)').length;

            const syncFilesAndPreview = () => {
                const transfer = new DataTransfer();
                selectedImages.forEach((file) => transfer.items.add(file));
                imageInput.files = transfer.files;
                preview.replaceChildren();

                selectedImages.forEach((file, index) => {
                    const item = document.createElement('div');
                    item.className = 'saved-image selected-image';
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file);
                    image.alt = file.name;
                    const meta = document.createElement('span');
                    meta.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(1)} MB)`;
                    const remove = document.createElement('button');
                    remove.type = 'button';
                    remove.className = 'remove-selected-image';
                    remove.textContent = 'Hapus pilihan';
                    remove.setAttribute('aria-label', `Hapus ${file.name} dari pilihan unggah`);
                    remove.addEventListener('click', () => {
                        selectedImages.splice(index, 1);
                        syncFilesAndPreview();
                    });
                    item.append(image, meta, remove);
                    preview.append(item);
                });

                const total = remainingSavedImages() + selectedImages.length;
                selectionStatus.textContent = selectedImages.length
                    ? `${selectedImages.length} foto baru dipilih; total foto setelah disimpan ${total} dari ${maxImages}.`
                    : `Belum ada foto baru dipilih. Total foto yang dipertahankan ${total} dari ${maxImages}.`;
            };

            imageInput?.addEventListener('change', () => {
                const incoming = [...imageInput.files];
                imageInput.value = '';
                const existingKeys = new Set(selectedImages.map((file) => `${file.name}:${file.size}:${file.lastModified}`));
                const uniqueIncoming = incoming.filter((file) => {
                    const key = `${file.name}:${file.size}:${file.lastModified}`;
                    if (existingKeys.has(key)) return false;
                    existingKeys.add(key);
                    return true;
                });
                const availableSlots = Math.max(0, maxImages - remainingSavedImages() - selectedImages.length);
                const accepted = uniqueIncoming.slice(0, availableSlots);
                selectedImages.push(...accepted);

                syncFilesAndPreview();
                if (accepted.length < uniqueIncoming.length) {
                    selectionStatus.textContent = `Hanya ${accepted.length} dari ${uniqueIncoming.length} foto tambahan dimasukkan. Maksimal ${maxImages} foto per kendaraan.`;
                }
            });

            document.querySelectorAll('input[name="remove_images[]"]').forEach((checkbox) => {
                checkbox.addEventListener('change', syncFilesAndPreview);
            });

            if (savedImagesCount > 0) syncFilesAndPreview();
        </script>
</body>
</html>
