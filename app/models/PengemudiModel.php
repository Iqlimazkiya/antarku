<?php

require_once __DIR__ . '/../../core/Model.php';

class PengemudiModel extends Model
{
    protected string $tabel = 'driver';

    public function cari(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT d.*, u.nama, u.email
             FROM driver d
             JOIN user u ON u.user_id = d.user_id
             WHERE d.driver_id = ?"
        );
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function cariByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT d.*, u.nama, u.email
             FROM driver d
             JOIN user u ON u.user_id = d.user_id
             WHERE u.email = ?"
        );
        $stmt->execute([$email]);

        return $stmt->fetch() ?: null;
    }

    public function setOnline(int $id, bool $online): void
    {
        $stmt = $this->db->prepare(
            "UPDATE driver
             SET status_ketersediaan = ?
             WHERE driver_id = ?"
        );
        $stmt->execute([$online ? 'tersedia' : 'offline', $id]);
    }

    private function selectPesanan(): string
    {
        return "
            SELECT
                p.pesanan_id,
                p.driver_id,
                p.status_pesanan,
                p.harga_tawaran,
                p.harga_deal,
                p.created_at,
                p.updated_at,
                u.nama AS penumpang,
                COALESCE(p.harga_deal, p.harga_tawaran) AS tarif,
                dp.alamat_jemput AS asal,
                dp.alamat_tujuan AS tujuan,
                dp.lat_jemput AS asal_lat,
                dp.lng_jemput AS asal_lng,
                dp.lat_tujuan AS tujuan_lat,
                dp.lng_tujuan AS tujuan_lng,
                dp.jarak_km AS jarak_total,
                dp.estimasi_menit AS durasi,
                dp.catatan
            FROM pesanan p
            JOIN user u ON u.user_id = p.user_id
            LEFT JOIN detail_pesanan dp
                ON dp.pesanan_id = p.pesanan_id
        ";
    }

    public function pesananSekitar(int $limit = 10): array
    {
        $limit = max(1, min($limit, 100));

        // Lokasi driver belum disimpan di database.
        // Daftar ini menampilkan pesanan menunggu, tanpa filter jarak.
        $sql = $this->selectPesanan() . "
            WHERE p.status_pesanan = 'menunggu'
              AND p.driver_id IS NULL
            ORDER BY p.created_at DESC, p.pesanan_id DESC
            LIMIT $limit
        ";

        return $this->db->query($sql)->fetchAll();
    }

    public function pesananMasuk(int $idDriver): array
    {
        $sql = $this->selectPesanan() . "
            WHERE (
                p.status_pesanan = 'menunggu'
                AND p.driver_id IS NULL
            ) OR (
                p.driver_id = ?
                AND p.status_pesanan IN (
                    'diterima', 'dijemput', 'dalam perjalanan'
                )
            )
            ORDER BY p.created_at DESC, p.pesanan_id DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idDriver]);

        return $stmt->fetchAll();
    }

    public function detailPesanan(int $idPesanan, int $idDriver): ?array
    {
        $sql = $this->selectPesanan() . "
            WHERE p.pesanan_id = ?
              AND (
                  p.driver_id = ?
                  OR (
                      p.driver_id IS NULL
                      AND p.status_pesanan = 'menunggu'
                  )
              )
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPesanan, $idDriver]);

        return $stmt->fetch() ?: null;
    }

    public function riwayat(int $idDriver): array
    {
        $sql = $this->selectPesanan() . "
            WHERE p.driver_id = ?
              AND p.status_pesanan IN ('selesai', 'dibatalkan')
            ORDER BY p.updated_at DESC, p.pesanan_id DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idDriver]);

        return $stmt->fetchAll();
    }

    public function transaksiPendapatan(int $idDriver): array
    {
        $sql = $this->selectPesanan() . "
            WHERE p.driver_id = ?
              AND p.status_pesanan = 'selesai'
            ORDER BY p.updated_at DESC, p.pesanan_id DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idDriver]);

        return $stmt->fetchAll();
    }

    public function ringkasanHariIni(int $id): array
    {
        $stmt = $this->db->prepare(
            "SELECT
                COALESCE(SUM(harga_deal), 0) AS total,
                COUNT(*) AS perjalanan
             FROM pesanan
             WHERE driver_id = ?
               AND status_pesanan = 'selesai'
               AND updated_at >= CURRENT_DATE()
               AND updated_at < CURRENT_DATE() + INTERVAL 1 DAY"
        );
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function ringkasanPendapatan(int $id): array
    {
        $stmt = $this->db->prepare(
            "SELECT
                COALESCE(SUM(harga_deal), 0) AS total,
                COUNT(*) AS perjalanan
             FROM pesanan
             WHERE driver_id = ?
               AND status_pesanan = 'selesai'"
        );
        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}
