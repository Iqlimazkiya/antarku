<?php

require_once __DIR__ . '/../models/PengemudiModel.php';

class PengemudiController
{
    private PengemudiModel $model;
    private int $idPengemudi;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new PengemudiModel();
        $this->idPengemudi = (int) ($_SESSION['id_pengemudi'] ?? 1);
    }

    private function dataPengemudi(): array
    {
        $data = $this->model->cari($this->idPengemudi);

        if (!$data) {
            http_response_code(404);
            exit('Pengemudi tidak ditemukan.');
        }

        return [
            'nama' => $data['nama'],
            'kendaraan' => trim(
                $data['merk_kendaraan'] . ' ' . $data['jenis_kendaraan']
            ) . ' · ' . $data['plat_nomor'],
            'rating' => number_format((float) $data['rating'], 1, ',', '.'),
            'online' => $data['status_ketersediaan'] !== 'offline',
        ];
    }

    public function dasbor(): void
    {
        $pengemudi = $this->dataPengemudi();
        $online = $pengemudi['online'];
        $pesanan = [];

        if ($online) {
            foreach ($this->model->pesananSekitar() as $p) {
                $pesanan[] = [
                    'pesanan_id' => (int) $p['pesanan_id'],
                    'jarak' => null,
                    'penumpang' => $p['penumpang'],
                    'tarif' => (float) $p['tarif'],
                    'asal' => $p['asal'] ?? 'Belum diisi',
                    'tujuan' => $p['tujuan'] ?? 'Belum diisi',
                    'jarak_total' => $p['jarak_total'] === null
                        ? '—'
                        : number_format((float) $p['jarak_total'], 1, ',', '.'),
                    'durasi' => (int) ($p['durasi'] ?? 0),
                    'pembayaran' => 'Belum dicatat',
                    'asal_lat' => $p['asal_lat'] === null
                        ? null : (float) $p['asal_lat'],
                    'asal_lng' => $p['asal_lng'] === null
                        ? null : (float) $p['asal_lng'],
                    'tujuan_lat' => $p['tujuan_lat'] === null
                        ? null : (float) $p['tujuan_lat'],
                    'tujuan_lng' => $p['tujuan_lng'] === null
                        ? null : (float) $p['tujuan_lng'],
                ];
            }
        }

        $ringkasan = $this->model->ringkasanHariIni($this->idPengemudi);
        $pendapatan = (float) $ringkasan['total'];
        $perjalanan = (int) $ringkasan['perjalanan'];

        require __DIR__ . '/../views/pengemudi/dasbor.php';
    }

    public function pesananMasuk(): void
    {
        $this->tampilkanHalaman(
            'pesanan',
            'Pesanan masuk',
            $this->model->pesananMasuk($this->idPengemudi)
        );
    }

    public function detailPesanan(): void
    {
        $id = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        if (!$id) {
            http_response_code(400);
            exit('ID pesanan tidak valid.');
        }

        $pesanan = $this->model->detailPesanan($id, $this->idPengemudi);

        if (!$pesanan) {
            http_response_code(404);
            exit('Pesanan tidak ditemukan atau bukan milik driver ini.');
        }

        $this->tampilkanHalaman(
            'detail',
            'Detail pesanan #' . $id,
            [$pesanan]
        );
    }

    public function riwayat(): void
    {
        $this->tampilkanHalaman(
            'riwayat',
            'Riwayat perjalanan',
            $this->model->riwayat($this->idPengemudi)
        );
    }

    public function pendapatan(): void
    {
        $this->tampilkanHalaman(
            'pendapatan',
            'Pendapatan',
            $this->model->transaksiPendapatan($this->idPengemudi)
        );
    }

    private function tampilkanHalaman(
        string $halaman,
        string $judul,
        array $daftar
    ): void {
        $pengemudi = $this->dataPengemudi();
        $hariIni = [];
        $seluruhnya = [];

        if ($halaman === 'pendapatan') {
            $hariIni = $this->model->ringkasanHariIni($this->idPengemudi);
            $seluruhnya = $this->model->ringkasanPendapatan($this->idPengemudi);
        }

        require __DIR__ . '/../views/pengemudi/halaman_driver.php';
    }

    public function ubahStatus(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['ok' => false, 'pesan' => 'Metode tidak diizinkan']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input) || !is_bool($input['online'] ?? null)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'pesan' => 'Status tidak valid']);
            return;
        }

        $this->model->setOnline($this->idPengemudi, $input['online']);

        echo json_encode([
            'ok' => true,
            'online' => $input['online'],
        ]);
    }
}
