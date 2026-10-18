<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\AdminModel;
use App\Libraries\SiteSettings;
use Throwable;

class AdminDashboard extends BaseController
{
    private const MAX_CAR_IMAGES = 10;
    private const MAX_IMAGE_SIZE = 5242880;

    private function setAdminHeaders(): void
    {
        helper('url');
        helper('form');
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    private function saveUploadedJpgs(): array|false
    {
        $files = $this->request->getFileMultiple('images') ?? [];
        $files = array_values(array_filter($files, static fn ($file) => $file && $file->getError() !== UPLOAD_ERR_NO_FILE));

        if (count($files) > self::MAX_CAR_IMAGES) {
            session()->setFlashdata('form_errors', ['Maksimal unggah ' . self::MAX_CAR_IMAGES . ' gambar untuk setiap kendaraan.']);
            return false;
        }

        foreach ($files as $file) {
            $extension = strtolower($file->getClientExtension());
            if (! $file->isValid() || $file->getError() !== UPLOAD_ERR_OK || $file->getSize() > self::MAX_IMAGE_SIZE
                || $file->getMimeType() !== 'image/jpeg' || ! in_array($extension, ['jpg', 'jpeg'], true)) {
                session()->setFlashdata('form_errors', ['Gunakan file JPG/JPEG yang valid dengan ukuran maksimal 5 MB per gambar.']);
                return false;
            }
        }

        if ($files === []) {
            return [];
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'cars';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            session()->setFlashdata('form_errors', ['Folder penyimpanan gambar tidak dapat dibuat.']);
            return false;
        }

        $paths = [];
        foreach ($files as $file) {
            $filename = bin2hex(random_bytes(16)) . '.jpg';
            if (! $file->move($directory, $filename)) {
                $this->deleteCarImages($paths);
                session()->setFlashdata('form_errors', ['Gambar gagal disimpan. Periksa izin folder public/uploads.']);
                return false;
            }
            $paths[] = 'uploads/cars/' . $filename;
        }

        return $paths;
    }

    private function deleteCarImages(array $paths): void
    {
        foreach ($paths as $path) {
            if (! is_string($path) || ! preg_match('#^uploads/cars/[a-f0-9]{32}\.jpg$#', $path)) {
                continue;
            }
            $file = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $path);
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }

    private function saveSitePhotos(): array|false
    {
        $files = [];
        foreach (['hero_image' => 'hero', 'about_image' => 'about'] as $field => $key) {
            $file = $this->request->getFile($field);
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                $files[$key] = $file;
            }
        }

        foreach ($files as $file) {
            $extension = strtolower($file->getClientExtension());
            $mime = $file->getMimeType();
            $validImage = ($mime === 'image/jpeg' && in_array($extension, ['jpg', 'jpeg'], true))
                || ($mime === 'image/png' && $extension === 'png')
                || ($mime === 'image/webp' && $extension === 'webp');
            if (! $file->isValid() || $file->getError() !== UPLOAD_ERR_OK
                || $file->getSize() > self::MAX_IMAGE_SIZE || ! $validImage) {
                session()->setFlashdata('settings_error', 'Gunakan foto JPG, PNG, atau WEBP yang valid dengan ukuran maksimal 5 MB.');
                return false;
            }
        }

        if ($files === []) {
            return [];
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'site-photos';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            session()->setFlashdata('settings_error', 'Folder penyimpanan foto website tidak dapat dibuat.');
            return false;
        }

        $paths = [];
        foreach ($files as $key => $file) {
            $extension = strtolower($file->getClientExtension());
            $extension = $extension === 'jpeg' ? 'jpg' : $extension;
            $filename = bin2hex(random_bytes(16)) . '.' . $extension;
            if (! $file->move($directory, $filename)) {
                $this->deleteSitePhotos(array_values($paths));
                session()->setFlashdata('settings_error', 'Foto website gagal disimpan. Periksa izin folder public/uploads.');
                return false;
            }
            $paths[$key] = 'uploads/site-photos/' . $filename;
        }

        return $paths;
    }

    private function deleteSitePhotos(array $paths): void
    {
        foreach ($paths as $path) {
            if (! is_string($path) || ! preg_match('#^uploads/site-photos/[a-f0-9]{32}\.(jpg|png|webp)$#', $path)) {
                continue;
            }
            $file = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $path);
            if (is_file($file) && ! unlink($file)) {
                log_message('error', 'Unable to remove replaced site photo: {path}', ['path' => $path]);
            }
        }
    }

    public function index()
    {
        $this->setAdminHeaders();
        $cars = [];
        $stats = ['total' => 0, 'available' => 0, 'featured' => 0, 'value' => 0];

        try {
            $model = new CarModel();
            $cars = $model->orderBy('created_at', 'DESC')->findAll(8);
            $stats['total'] = $model->countAllResults(false);
            $stats['available'] = $model->where('status', 'tersedia')->countAllResults();
            $stats['featured'] = $model->where('featured', 1)->where('status', 'tersedia')->countAllResults();
            $stats['value'] = (int) ($model->selectSum('price')->where('status', 'tersedia')->first()['price'] ?? 0);
        } catch (Throwable $exception) {
            log_message('error', 'Admin dashboard catalog query failed: {message}', ['message' => $exception->getMessage()]);
            session()->setFlashdata('dashboard_error', 'Data stok belum tersedia. Jalankan migration dan seeder katalog terlebih dahulu.');
        }

        return view('admin/dashboard', [
            'cars' => $cars,
            'stats' => $stats,
        ]);
    }

    public function create()
    {
        $this->setAdminHeaders();

        return view('admin/car_form', [
            'defaultBrand' => (string) $this->request->getGet('brand'),
            'car' => [],
            'isEdit' => false,
        ]);
    }

    public function edit(int $id)
    {
        $this->setAdminHeaders();
        $car = (new CarModel())->find($id);

        if (! $car) {
            return redirect()->to(app_path('admin/dashboard'))->with('dashboard_error', 'Kendaraan tidak ditemukan.');
        }

        return view('admin/car_form', [
            'defaultBrand' => '',
            'car' => $car,
            'isEdit' => true,
        ]);
    }

    public function store()
    {
        helper('url');
        $rules = [
            'name' => 'required|max_length[150]',
            'brand' => 'required|max_length[80]',
            'variant' => 'required|max_length[120]',
            'year' => 'required|integer',
            'price' => 'required|integer|greater_than[0]',
            'transmission' => 'required|max_length[30]',
            'mileage' => 'required|integer|greater_than_equal_to[0]',
            'fuel' => 'required|max_length[30]',
            'color' => 'required|max_length[40]',
            'description' => 'permit_empty|max_length[5000]',
            'status' => 'required|in_list[tersedia,terjual]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('form_errors', $this->validator->getErrors());
        }

        $year = (int) $this->request->getPost('year');
        if ($year < 1900 || $year > ((int) date('Y') + 1)) {
            return redirect()->back()->withInput()->with('form_errors', ['year' => 'Tahun kendaraan tidak valid.']);
        }

        $images = $this->saveUploadedJpgs();
        if ($images === false) {
            return redirect()->back()->withInput();
        }
        if ($images === []) {
            return redirect()->back()->withInput()->with('form_errors', ['Unggah minimal satu gambar JPG/JPEG kendaraan.']);
        }

        $name = trim((string) $this->request->getPost('name'));
        $slugBase = url_title($name, '-', true) ?: 'mobil';
        $slug = $slugBase;
        $suffix = 2;
        $model = new CarModel();
        while ($model->where('slug', $slug)->first() !== null) {
            $slug = $slugBase . '-' . $suffix++;
        }

        $saved = $model->insert([
            'slug' => $slug,
            'name' => $name,
            'brand' => trim((string) $this->request->getPost('brand')),
            'variant' => trim((string) $this->request->getPost('variant')),
            'year' => $year,
            'price' => (int) $this->request->getPost('price'),
            'transmission' => trim((string) $this->request->getPost('transmission')),
            'mileage' => (int) $this->request->getPost('mileage'),
            'fuel' => trim((string) $this->request->getPost('fuel')),
            'color' => trim((string) $this->request->getPost('color')),
            'image' => $images[0],
            'images' => json_encode($images, JSON_UNESCAPED_SLASHES),
            'description' => trim((string) $this->request->getPost('description')),
            'featured' => $this->request->getPost('featured') ? 1 : 0,
            'status' => $this->request->getPost('status'),
        ]);

        if (! $saved) {
            $this->deleteCarImages($images);
            return redirect()->back()->withInput()->with('form_errors', ['general' => 'Kendaraan gagal disimpan. Periksa koneksi database.']);
        }

        return redirect()->to(app_path('admin/dashboard'))->with('action_success', 'Kendaraan berhasil ditambahkan ke inventaris.');
    }

    public function update(int $id)
    {
        helper('url');
        $model = new CarModel();
        $car = $model->find($id);

        if (! $car) {
            return redirect()->to(app_path('admin/dashboard'))->with('dashboard_error', 'Kendaraan tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|max_length[150]',
            'brand' => 'required|max_length[80]',
            'variant' => 'required|max_length[120]',
            'year' => 'required|integer',
            'price' => 'required|integer|greater_than[0]',
            'transmission' => 'required|max_length[30]',
            'mileage' => 'required|integer|greater_than_equal_to[0]',
            'fuel' => 'required|max_length[30]',
            'color' => 'required|max_length[40]',
            'description' => 'permit_empty|max_length[5000]',
            'status' => 'required|in_list[tersedia,terjual]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('form_errors', $this->validator->getErrors());
        }

        $year = (int) $this->request->getPost('year');
        if ($year < 1900 || $year > ((int) date('Y') + 1)) {
            return redirect()->back()->withInput()->with('form_errors', ['year' => 'Tahun kendaraan tidak valid.']);
        }

        $oldImages = json_decode((string) ($car['images'] ?? ''), true);
        if (! is_array($oldImages) || $oldImages === []) {
            $oldImages = ! empty($car['image']) ? [$car['image']] : [];
        }
        $removeImages = (array) $this->request->getPost('remove_images');
        $remainingImages = array_values(array_filter($oldImages, static fn ($image) => ! in_array($image, $removeImages, true)));
        $newImages = $this->saveUploadedJpgs();
        if ($newImages === false) {
            return redirect()->back()->withInput();
        }
        $images = array_merge($remainingImages, $newImages);
        if (count($images) > self::MAX_CAR_IMAGES) {
            $this->deleteCarImages($newImages);
            return redirect()->back()->withInput()->with('form_errors', ['Maksimal ' . self::MAX_CAR_IMAGES . ' gambar untuk setiap kendaraan. Hapus foto lama atau kurangi foto baru.']);
        }
        if ($images === []) {
            return redirect()->back()->withInput()->with('form_errors', ['Kendaraan harus memiliki minimal satu gambar JPG/JPEG.']);
        }

        $name = trim((string) $this->request->getPost('name'));
        $slugBase = url_title($name, '-', true) ?: 'mobil';
        $slug = $slugBase;
        $suffix = 2;
        while ($slug !== $car['slug'] && $model->where('slug', $slug)->first() !== null) {
            $slug = $slugBase . '-' . $suffix++;
        }

        $saved = $model->update($id, [
            'slug' => $slug,
            'name' => $name,
            'brand' => trim((string) $this->request->getPost('brand')),
            'variant' => trim((string) $this->request->getPost('variant')),
            'year' => $year,
            'price' => (int) $this->request->getPost('price'),
            'transmission' => trim((string) $this->request->getPost('transmission')),
            'mileage' => (int) $this->request->getPost('mileage'),
            'fuel' => trim((string) $this->request->getPost('fuel')),
            'color' => trim((string) $this->request->getPost('color')),
            'image' => $images[0],
            'images' => json_encode($images, JSON_UNESCAPED_SLASHES),
            'description' => trim((string) $this->request->getPost('description')),
            'featured' => $this->request->getPost('featured') ? 1 : 0,
            'status' => $this->request->getPost('status'),
        ]);

        if (! $saved) {
            $this->deleteCarImages($newImages);
            return redirect()->back()->withInput()->with('form_errors', ['general' => 'Kendaraan gagal diperbarui. Periksa koneksi database.']);
        }

        $this->deleteCarImages(array_diff($oldImages, $remainingImages));

        return redirect()->to(app_path('admin/dashboard'))->with('action_success', 'Data kendaraan berhasil diperbarui.');
    }

    public function categories()
    {
        $this->setAdminHeaders();
        $categories = [];

        try {
            $categories = db_connect()->table('mobil')
                ->select('brand, COUNT(*) AS total')
                ->groupBy('brand')
                ->orderBy('brand', 'ASC')
                ->get()->getResultArray();
        } catch (Throwable $exception) {
            log_message('error', 'Admin category query failed: {message}', ['message' => $exception->getMessage()]);
            session()->setFlashdata('dashboard_error', 'Kategori belum tersedia. Pastikan tabel inventaris sudah dibuat.');
        }

        return view('admin/categories', ['categories' => $categories]);
    }

    public function settings()
    {
        $this->setAdminHeaders();
        $admin = (new AdminModel())->find((int) session()->get('admin_id'));

        return view('admin/settings', [
            'admin' => $admin ?? [],
            'siteImages' => SiteSettings::images(),
        ]);
    }

    public function updateSettings()
    {
        $this->setAdminHeaders();
        $adminId = (int) session()->get('admin_id');
        $adminModel = new AdminModel();
        $admin = $adminModel->find($adminId);

        if (! $admin || ! password_verify((string) $this->request->getPost('current_password'), $admin['password_hash'])) {
            return redirect()->back()->withInput()->with('settings_error', 'Kata sandi saat ini tidak cocok.');
        }

        $name = trim((string) $this->request->getPost('name'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $newPassword = (string) $this->request->getPost('new_password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if ($name === '' || mb_strlen($name) > 100 || ! filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) {
            return redirect()->back()->withInput()->with('settings_error', 'Nama atau alamat email tidak valid.');
        }

        $existing = $adminModel->where('email', $email)->where('id !=', $adminId)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('settings_error', 'Email tersebut sudah digunakan akun admin lain.');
        }

        $changes = ['name' => $name, 'email' => $email];
        if ($newPassword !== '') {
            if (strlen($newPassword) < 10 || $newPassword !== $confirmPassword) {
                return redirect()->back()->withInput()->with('settings_error', 'Kata sandi baru minimal 10 karakter dan harus sama dengan konfirmasi.');
            }
            $changes['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $uploadedPhotos = $this->saveSitePhotos();
        if ($uploadedPhotos === false) {
            return redirect()->back()->withInput();
        }

        $previousImages = SiteSettings::images();
        $updatedImages = array_merge($previousImages, $uploadedPhotos);
        if ($uploadedPhotos !== []) {
            try {
                SiteSettings::saveImages($updatedImages);
            } catch (Throwable $exception) {
                $this->deleteSitePhotos(array_values($uploadedPhotos));
                log_message('error', 'Unable to update site images: {message}', ['message' => $exception->getMessage()]);
                return redirect()->back()->withInput()->with('settings_error', 'Foto website gagal disimpan. Periksa izin folder writable.');
            }
        }

        if (! $adminModel->update($adminId, $changes)) {
            if ($uploadedPhotos !== []) {
                try {
                    SiteSettings::saveImages($previousImages);
                } catch (Throwable $exception) {
                    log_message('error', 'Unable to restore site image settings: {message}', ['message' => $exception->getMessage()]);
                }
                $this->deleteSitePhotos(array_values($uploadedPhotos));
            }
            return redirect()->back()->withInput()->with('settings_error', 'Pengaturan gagal disimpan.');
        }

        if ($uploadedPhotos !== []) {
            $replacedPhotos = [];
            foreach ($uploadedPhotos as $key => $path) {
                if (isset($previousImages[$key]) && $previousImages[$key] !== $path) {
                    $replacedPhotos[] = $previousImages[$key];
                }
            }
            $this->deleteSitePhotos($replacedPhotos);
        }

        session()->set(['admin_name' => $name, 'admin_email' => $email]);

        return redirect()->to(app_path('admin/pengaturan'))->with('settings_success', 'Pengaturan berhasil diperbarui.');
    }

    public function exportCsv()
    {
        $this->setAdminHeaders();
        $cars = (new CarModel())->orderBy('id', 'ASC')->findAll();
        $stream = fopen('php://temp', 'r+');
        fputcsv($stream, ['ID', 'Nama', 'Merek / Kategori', 'Varian', 'Tahun', 'Harga', 'Transmisi', 'Kilometer', 'Bahan bakar', 'Warna', 'Gambar', 'Deskripsi', 'Unggulan', 'Status']);

        foreach ($cars as $car) {
            $values = [
                $car['id'], $car['name'], $car['brand'], $car['variant'], $car['year'], $car['price'],
                $car['transmission'], $car['mileage'], $car['fuel'], $car['color'], $car['image'],
                $car['description'], $car['featured'] ? 'Ya' : 'Tidak', $car['status'],
            ];
            $values = array_map(static function ($value) {
                $value = (string) ($value ?? '');
                return preg_match('/^[=+@\-\t\r]/', $value) ? "\t" . $value : $value;
            }, $values);
            fputcsv($stream, $values);
        }

        rewind($stream);
        $csv = "\xEF\xBB\xBF" . stream_get_contents($stream);
        fclose($stream);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="inventaris-mobil-' . date('Y-m-d') . '.csv"')
            ->setBody($csv);
    }
}
