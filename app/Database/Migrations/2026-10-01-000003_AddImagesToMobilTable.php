<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImagesToMobilTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mobil', [
            'images' => ['type' => 'TEXT', 'null' => true, 'after' => 'image'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mobil', 'images');
    }
}