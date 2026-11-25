<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../app/controllers/PengemudiController.php';

$base = rtrim(
    str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])),
    '/'
);

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$path = '/' . trim(substr($urlPath, strlen($base)), '/');
$method = $_SERVER['REQUEST_METHOD'];

$pengemudi = new PengemudiController();

if ($path === '/pengemudi/status') {
    $pengemudi->ubahStatus();
    exit;
}

if ($method !== 'GET') {
    http_response_code(405);
    header('Allow: GET');
    exit('Metode tidak diizinkan.');
}

$halaman = [
    '/' => 'dasbor',
    '/index.php' => 'dasbor',
    '/pengemudi' => 'dasbor',
    '/pengemudi/dasbor' => 'dasbor',
    '/pengemudi/pesanan' => 'pesananMasuk',
    '/pengemudi/detail-pesanan' => 'detailPesanan',
    '/pengemudi/riwayat' => 'riwayat',
    '/pengemudi/pendapatan' => 'pendapatan',
];

if (!isset($halaman[$path])) {
    http_response_code(404);
    exit('404 — Halaman tidak ditemukan.');
}

$aksi = $halaman[$path];
$pengemudi->$aksi();
