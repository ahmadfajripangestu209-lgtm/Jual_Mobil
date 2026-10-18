<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Forge;

class CreateMobilTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 180],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'brand' => ['type' => 'VARCHAR', 'constraint' => 80],
            'variant' => ['type' => 'VARCHAR', 'constraint' => 120],
            'year' => ['type' => 'SMALLINT', 'constraint' => 4],
            'price' => ['type' => 'BIGINT', 'unsigned' => true],
            'transmission' => ['type' => 'VARCHAR', 'constraint' => 30],
            'mileage' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'fuel' => ['type' => 'VARCHAR', 'constraint' => 30],
            'color' => ['type' => 'VARCHAR', 'constraint' => 40],
            'image' => ['type' => 'VARCHAR', 'constraint' => 500],
            'description' => ['type' => 'TEXT', 'null' => true],
            'featured' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'tersedia'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'brand']);
        $this->forge->createTable('mobil', true);
    }

    public function down()
    {
        $this->forge->dropTable('mobil', true);
    }
}
