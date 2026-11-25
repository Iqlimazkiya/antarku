<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../app/controllers/AutentikasiController.php';
require_once __DIR__ . '/../app/controllers/PengemudiController.php';

Session::start();

$base   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');  
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path   = '/' . trim(substr($uri, strlen($base)), '/');
$method = $_SERVER['REQUEST_METHOD'];

$auth = new AutentikasiController();
$pengemudi = new PengemudiController();

switch (true) {
    // Rute Login Penumpang
    case ($path === '/login' || $path === '/masuk') && ($method === 'GET' || $method === 'HEAD'):
        $auth->masukPenumpang();
        break;

    case ($path === '/login' || $path === '/masuk') && $method === 'POST':
        $auth->prosesMasukPenumpang();
        break;

    // Rute Login Driver
    case ($path === '/login/driver' || $path === '/masuk/driver' || $path === '/pengemudi/login' || $path === '/pengemudi/masuk') && ($method === 'GET' || $method === 'HEAD'):
        $auth->masukDriver();
        break;

    case ($path === '/login/driver' || $path === '/masuk/driver' || $path === '/pengemudi/login' || $path === '/pengemudi/masuk') && $method === 'POST':
        $auth->prosesMasukDriver();
        break;

    // Rute Sign In / Pendaftaran Akun Penumpang (Sesuai Mockup Sign In)
    case ($path === '/daftar' || $path === '/signin' || $path === '/signup' || $path === '/sign-in') && ($method === 'GET' || $method === 'HEAD'):
        $auth->daftar();
        break;

    case ($path === '/daftar' || $path === '/signin' || $path === '/signup' || $path === '/sign-in') && $method === 'POST':
        $auth->prosesDaftar();
        break;

    // Rute Logout
    case $path === '/logout' || $path === '/keluar':
        $auth->keluar();
        break;

    // Beranda / Root
    case $path === '/' || $path === '' || $path === '/pilih-peran' || $path === '/role':
        if (Session::get('role') === 'driver') {
            header('Location: ' . $base . '/pengemudi/dasbor');
            exit;
        } elseif (Session::get('role') === 'penumpang') {
            header('Location: ' . $base . '/penumpang/beranda');
            exit;
        } else {
            // Halaman awal pemilihan peran saat website pertama kali dikunjungi
            $auth->pilihPeran();
        }
        break;

    // Dasbor Penumpang
    case $path === '/penumpang' || $path === '/penumpang/beranda':
        if (Session::get('role') !== 'penumpang') {
            header('Location: ' . $base . '/login');
            exit;
        }
        $nama = Session::get('nama');
        require __DIR__ . '/../app/views/penumpang/beranda.php';
        break;

    // Dasbor Pengemudi
    case $path === '/pengemudi' || $path === '/pengemudi/dasbor':
        if (Session::get('role') !== 'driver') {
            header('Location: ' . $base . '/login/driver');
            exit;
        }
        $pengemudi->dasbor();
        break;

    case $path === '/pengemudi/status' && $method === 'POST':
        $pengemudi->ubahStatus();
        break;

    default:
        http_response_code(404);
        echo '404 - Halaman tidak ditemukan: ' . htmlspecialchars($path);
        break;
}
