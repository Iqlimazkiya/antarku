<?php
require_once __DIR__ . '/../../core/Model.php';

class PengemudiModel extends Model
{
    protected string $tabel = 'driver';
    protected string $kunciUtama = 'driver_id';

    public function cariByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT d.*, u.nama, u.email, u.no_hp, u.password, u.role
               FROM {$this->tabel} d
               JOIN user u ON u.user_id = d.user_id
              WHERE u.email = ?
              LIMIT 1"
        );
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function cariUntukLogin(string $identifier): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT d.*, u.user_id, u.nama, u.email, u.no_hp, u.password, u.role
               FROM {$this->tabel} d
               JOIN user u ON u.user_id = d.user_id
              WHERE d.kode_driver = ?
                 OR u.email = ?
                 OR u.no_hp = ?
                 OR d.plat_nomor = ?
                 OR CAST(d.driver_id AS CHAR) = ?
              LIMIT 1"
        );
        $stmt->execute([$identifier, $identifier, $identifier, $identifier, $identifier]);
        return $stmt->fetch() ?: null;
    }

    public function cari(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT d.*, u.nama AS nama
               FROM {$this->tabel} d
               JOIN user u ON u.user_id = d.user_id
              WHERE d.driver_id = ?
              LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function setOnline(int $id, bool $online): void
    {
        $status = $online ? 'tersedia' : 'offline';
        $stmt = $this->db->prepare(
            "UPDATE {$this->tabel} SET status_ketersediaan = ? WHERE driver_id = ?"
        );
        $stmt->execute([$status, $id]);
    }

    public function pesananSekitar(int $limit = 10): array
    {
        return [];
    }

    public function ringkasanHariIni(int $id): array
    {
        return ['total' => 0, 'perjalanan' => 0];
    }
}
