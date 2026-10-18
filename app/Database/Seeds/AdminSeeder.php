<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $email = 'admin@mugiberkah.com';
        $admins = $this->db->table('admins');

        if ($admins->where('email', $email)->countAllResults() > 0) {
            return;
        }

        $admins->insert([
            'name' => 'Administrator Mugi Berkah',
            'email' => $email,
            'password_hash' => password_hash('MugiBerkah#2026', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
