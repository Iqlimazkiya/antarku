<?php
require_once __DIR__ . '/../../core/Model.php';

class PenggunaModel extends Model
{
    protected string $tabel = 'user';
    protected string $kunciUtama = 'user_id';

    /**
     * Cari pengguna penumpang berdasarkan email atau nomor telepon
     */
    public function cariPenumpang(string $identifier): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->tabel} 
             WHERE (email = ? OR no_hp = ?) AND role = 'penumpang'
             LIMIT 1"
        );
        $stmt->execute([$identifier, $identifier]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Cari pengguna umum berdasarkan email atau no_hp
     */
    public function cariByEmailAtauHp(string $identifier): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->tabel} 
             WHERE email = ? OR no_hp = ? 
             LIMIT 1"
        );
        $stmt->execute([$identifier, $identifier]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Cari pengguna berdasarkan email
     */
    public function cariByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->tabel} WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }
}
