<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table = 'mobil';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'slug', 'name', 'brand', 'variant', 'year', 'price', 'transmission',
        'mileage', 'fuel', 'color', 'image', 'images', 'description', 'featured', 'status',
    ];
    protected $useTimestamps = true;
}
