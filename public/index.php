<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../app/controllers/PengemudiController.php';

$base   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');  
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path   = '/' . trim(substr($path, strlen($base)), '/');
$method = $_SERVER['REQUEST_METHOD'];

$pengemudi = new PengemudiController();

switch (true) {
    case $path === '/' || $path === '/pengemudi' || $path === '/pengemudi/dasbor':
        $pengemudi->dasbor();
        break;

    case $path === '/pengemudi/status' && $method === 'POST':
        $pengemudi->ubahStatus();
        break;

    default:
        http_response_code(404);
        echo '404 - Halaman tidak ditemukan: ' . htmlspecialchars($path);
}