<?php

namespace App\Controllers;

use App\Models\AdminModel;
use Throwable;

class AdminAuthController extends BaseController
{
    public function login()
    {
        helper('url');
        helper('form');
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');

        if (session()->get('admin_id')) {
            return redirect()->to(app_path('admin/dashboard'));
        }

        return view('admin/login');
    }

    public function attempt()
    {
        helper('url');
        $session = session();
        $now = time();
        $blockedUntil = (int) ($session->get('admin_login_blocked_until') ?? 0);

        if ($blockedUntil > $now) {
            $session->setFlashdata('login_error', 'Terlalu banyak percobaan. Coba lagi dalam ' . ($blockedUntil - $now) . ' detik.');
            return redirect()->to(app_path('admin/login'))->withInput();
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $session->setFlashdata('login_error', 'Email atau kata sandi tidak cocok.');
            return redirect()->to(app_path('admin/login'))->withInput();
        }

        try {
            $admin = (new AdminModel())->where('email', $email)->first();
        } catch (Throwable $exception) {
            log_message('error', 'Admin login database error: {message}', ['message' => $exception->getMessage()]);
            $session->setFlashdata('login_error', 'Layanan login belum siap. Pastikan database sudah dikonfigurasi dan migration sudah dijalankan.');
            return redirect()->to(app_path('admin/login'))->withInput();
        }

        if (! $admin || ! password_verify($password, $admin['password_hash'])) {
            $attempts = (int) ($session->get('admin_login_attempts') ?? 0) + 1;
            $session->set('admin_login_attempts', $attempts);

            if ($attempts >= 5) {
                $session->set('admin_login_blocked_until', $now + 60);
                $session->remove('admin_login_attempts');
                $session->setFlashdata('login_error', 'Terlalu banyak percobaan. Coba lagi dalam 60 detik.');
            } else {
                $session->setFlashdata('login_error', 'Email atau kata sandi tidak cocok.');
            }

            return redirect()->to(app_path('admin/login'))->withInput();
        }

        $session->regenerate(true);
        $session->remove(['admin_login_attempts', 'admin_login_blocked_until']);
        $session->set([
            'admin_id' => (int) $admin['id'],
            'admin_name' => $admin['name'],
            'admin_email' => $admin['email'],
        ]);

        return redirect()->to(app_path('admin/dashboard'));
    }

    public function logout()
    {
        helper('url');
        session()->remove(['admin_id', 'admin_name', 'admin_email']);
        session()->regenerate(true);
        session()->setFlashdata('login_success', 'Anda berhasil keluar dari dashboard.');

        return redirect()->to(app_path('admin/login'));
    }
}
