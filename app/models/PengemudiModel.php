<?php
require_once __DIR__ . '/../../core/Model.php';

class PengemudiModel extends Model
{
    protected string $tabel = 'driver';

    public function cariByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT d.* FROM {$this->tabel} d
               JOIN user u ON u.user_id = d.user_id
              WHERE u.email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }
    public function cari(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT d.*, u.nama AS nama
               FROM {$this->tabel} d
               JOIN user u ON u.user_id = d.user_id
              WHERE d.driver_id = ?"
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