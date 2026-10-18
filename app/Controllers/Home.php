<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Config\CatalogData;
use App\Libraries\SiteSettings;
use Throwable;

class Home extends BaseController
{
    private function withGallery(array $car): array
    {
        $images = json_decode((string) ($car['images'] ?? ''), true);
        if (! is_array($images) || $images === []) {
            $images = [$car['image'] ?? $car['image_url'] ?? ''];
        }

        $car['gallery'] = array_values(array_filter(array_map(static function ($image) {
            $image = trim((string) $image);
            if ($image === '') {
                return null;
            }

            return preg_match('#^https?://#i', $image) ? $image : app_path($image);
        }, $images)));

        return $car;
    }

    public function index()
    {
        helper('url');
        $cars = CatalogData::cars();

        try {
            $model = new CarModel();
            if ($model->db->tableExists('mobil')) {
                $availableCars = $model->where('status', 'tersedia')->orderBy('featured', 'DESC')->findAll();
                if ($availableCars !== []) {
                    $cars = $availableCars;
                }
            }
        } catch (Throwable $exception) {
            // Keep the catalog usable before MySQL is configured or seeded.
        }

        $cars = array_map(fn (array $car) => $this->withGallery($car), $cars);

        $brands = array_values(array_unique(array_column($cars, 'brand')));
        sort($brands);

        return view('cars/catalog', [
            'cars'   => $cars,
            'brands' => $brands,
            'siteImages' => SiteSettings::images(),
        ]);
    }

    public function detail(string $slug)
    {
        helper('url');
        $car = null;

        try {
            $model = new CarModel();
            if ($model->db->tableExists('mobil')) {
                $car = $model->where('slug', $slug)->first();
            }
        } catch (Throwable $exception) {
            // Try the bundled sample catalog if database storage is unavailable.
        }

        if ($car === null) {
            foreach (CatalogData::cars() as $sampleCar) {
                if (($sampleCar['slug'] ?? '') === $slug) {
                    $car = $sampleCar;
                    break;
                }
            }
        }

        if ($car === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kendaraan tidak ditemukan.');
        }

        $car = $this->withGallery($car);

        return view('cars/detail', ['car' => $car]);
    }
}
