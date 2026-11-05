<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('berita/(:segment)', 'Home::detail/$1');
$routes->get('kategori/(:segment)', 'Home::category/$1');
$routes->get('cari', 'Home::search');
$routes->get('placeholder', 'Home::placeholder');
$routes->get('halaman/(:segment)', 'Home::page/$1');

// Static Pages & Contact Form
$routes->get('tentang-kami', 'Home::about');
$routes->get('redaksi', 'Home::redaksi');
$routes->get('pedoman-media-siber', 'Home::pedoman');
$routes->get('kontak', 'Home::kontak');
$routes->post('kontak/kirim', 'Home::sendMessage');

// Admin Auth (Public)
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/login', 'Admin\Auth::attemptLogin');
$routes->get('admin/logout', 'Admin\Auth::logout');

// Admin Protected Routes
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // News Management
    $routes->get('news', 'Admin\News::index');
    $routes->get('news/create', 'Admin\News::create');
    $routes->post('news/store', 'Admin\News::store');
    $routes->get('news/edit/(:num)', 'Admin\News::edit/$1');
    $routes->post('news/update/(:num)', 'Admin\News::update/$1');
    $routes->get('news/delete/(:num)', 'Admin\News::delete/$1');
    $routes->post('news/upload-image', 'Admin\News::uploadImage');

    // Categories Management
    $routes->get('categories', 'Admin\Categories::index');
    $routes->post('categories/store', 'Admin\Categories::store');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete/$1');

    // Menus & Dropdown Management (Kelola Menu Navigasi & Dropdown)
    $routes->get('menus', 'Admin\Menus::index');
    $routes->post('menus/store', 'Admin\Menus::store');
    $routes->post('menus/update/(:num)', 'Admin\Menus::update/$1');
    $routes->get('menus/delete/(:num)', 'Admin\Menus::delete/$1');

    // Pages Management (Kelola Halaman Statis)
    $routes->get('pages', 'Admin\Pages::index');
    $routes->get('pages/create', 'Admin\Pages::create');
    $routes->post('pages/store', 'Admin\Pages::store');
    $routes->get('pages/edit/(:num)', 'Admin\Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\Pages::update/$1');
    $routes->get('pages/delete/(:num)', 'Admin\Pages::delete/$1');

    // Banner Ads Management (Kelola Iklan & Sponsor)
    $routes->get('banners', 'Admin\Banners::index');
    $routes->post('banners/store', 'Admin\Banners::store');
    $routes->post('banners/update/(:num)', 'Admin\Banners::update/$1');
    $routes->get('banners/delete/(:num)', 'Admin\Banners::delete/$1');

    // Users / Journalists Management (Kelola Wartawan & Pengguna)
    $routes->get('users', 'Admin\Users::index');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->post('users/reset-password/(:num)', 'Admin\Users::resetPassword/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    // Messages / Inbox (Pesan Masuk Pembaca & Pengaduan)
    $routes->get('messages', 'Admin\Messages::index');
    $routes->get('messages/view/(:num)', 'Admin\Messages::view/$1');
    $routes->get('messages/delete/(:num)', 'Admin\Messages::delete/$1');

    // Settings (Pengaturan Website & Ganti Logo/Favicon)
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/update', 'Admin\Settings::update');

    // Profile & Password
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');
    $routes->post('profile/update-password', 'Admin\Profile::updatePassword');
});
