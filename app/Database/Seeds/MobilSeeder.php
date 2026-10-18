<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Config\CatalogData;

class MobilSeeder extends Seeder
{
    public function run()
    {
        $rows = array_map(static function (array $car): array {
            unset($car['id']);
            $car['created_at'] = date('Y-m-d H:i:s');
            $car['updated_at'] = date('Y-m-d H:i:s');

            return $car;
        }, CatalogData::cars());

        $this->db->table('mobil')->insertBatch($rows);
    }
}
