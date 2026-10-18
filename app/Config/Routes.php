<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('katalog', 'Home::index');
$routes->get('mobil/(:segment)', 'Home::detail/$1');
$routes->get('admin/login', 'AdminAuthController::login');
$routes->post('admin/login', 'AdminAuthController::attempt', ['filter' => 'csrf']);
$basePath = trim((string) parse_url(config('App')->baseURL, PHP_URL_PATH), '/');
if ($basePath !== '') {
	$routes->get($basePath . '/admin/(:any)', static function (string $adminPath) {
		return redirect()->to(rtrim(config('App')->baseURL, '/') . '/admin/' . ltrim($adminPath, '/'));
	});
}
$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
	$routes->get('dashboard', 'AdminDashboard::index');
	$routes->get('mobil/tambah', 'AdminDashboard::create');
	$routes->post('mobil/simpan', 'AdminDashboard::store', ['filter' => 'csrf']);
	$routes->get('mobil/(:num)/edit', 'AdminDashboard::edit/$1');
	$routes->post('mobil/(:num)/update', 'AdminDashboard::update/$1', ['filter' => 'csrf']);
	$routes->get('kategori', 'AdminDashboard::categories');
	$routes->get('pengaturan', 'AdminDashboard::settings');
	$routes->post('pengaturan', 'AdminDashboard::updateSettings', ['filter' => 'csrf']);
	$routes->get('export/csv', 'AdminDashboard::exportCsv');
	$routes->post('logout', 'AdminAuthController::logout', ['filter' => 'csrf']);
});
