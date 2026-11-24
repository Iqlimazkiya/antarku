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

    public function dasbor(): void
    {
        $data = $this->model->cari($this->idPengemudi);
        if (!$data) {
            http_response_code(404);
            exit('Pengemudi tidak ditemukan.');
        }

        $online = ($data['status_ketersediaan'] !== 'offline');

        $pengemudi = [
            'nama'      => $data['nama'],
            'kendaraan' => trim($data['merk_kendaraan'] . ' ' . $data['jenis_kendaraan']) . ' · ' . $data['plat_nomor'],
            'rating'    => number_format((float) $data['rating'], 1, ',', '.'),
        ];

        $pesanan = [];
        if ($online) {
            foreach ($this->model->pesananSekitar() as $p) {
                $pesanan[] = [
                    'jarak'       => number_format((float) $p['jarak'], 1, ',', '.'),
                    'penumpang'   => $p['penumpang'],
                    'tarif'       => (int) $p['tarif'],
                    'asal'        => $p['asal'],
                    'tujuan'      => $p['tujuan'],
                    'jarak_total' => number_format((float) $p['jarak_total'], 1, ',', '.'),
                    'durasi'      => (int) $p['durasi'],
                    'pembayaran'  => $p['pembayaran'],

                    'asal_lat'    => isset($p['asal_lat'])   ? (float) $p['asal_lat']   : null,
                    'asal_lng'    => isset($p['asal_lng'])   ? (float) $p['asal_lng']   : null,
                    'tujuan_lat'  => isset($p['tujuan_lat']) ? (float) $p['tujuan_lat'] : null,
                    'tujuan_lng'  => isset($p['tujuan_lng']) ? (float) $p['tujuan_lng'] : null,
                ];
            }

            // dummy
            if (empty($pesanan)) {
                $pesanan[] = [
                    'jarak'       => '1,2',
                    'penumpang'   => 'Nadia Putri',
                    'tarif'       => 32000,
                    'asal'        => 'Alun-alun Sidoarjo',
                    'tujuan'      => 'Bandara Juanda',
                    'jarak_total' => '12,5',
                    'durasi'      => 25,
                    'pembayaran'  => 'Tunai',
                    'asal_lat'    => -7.4478,
                    'asal_lng'    => 112.7183,
                    'tujuan_lat'  => -7.3798,
                    'tujuan_lng'  => 112.7868,
                ];
            }
        }

        $ringkasan  = $this->model->ringkasanHariIni($this->idPengemudi);
        $pendapatan = (int) $ringkasan['total'];
        $perjalanan = (int) $ringkasan['perjalanan'];

        require __DIR__ . '/../views/pengemudi/dasbor.php';
    }

    public function ubahStatus(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['ok' => false, 'pesan' => 'Metode tidak diizinkan']);
            return;
        }

        $input  = json_decode(file_get_contents('php://input'), true);
        $online = !empty($input['online']);

        $this->model->setOnline($this->idPengemudi, $online);

        echo json_encode(['ok' => true, 'online' => $online]);
    }
}