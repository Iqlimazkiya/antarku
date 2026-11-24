<?php
require_once __DIR__ . '/Database.php';

abstract class Model
{
    protected PDO $db;
    protected string $tabel;          
    protected string $kunciUtama = 'id';

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function semua(): array
    {
        return $this->db->query("SELECT * FROM {$this->tabel}")->fetchAll();
    }

    public function cariById($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->tabel} WHERE {$this->kunciUtama} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function tambah(array $data): int
    {
        $kolom  = implode(', ', array_keys($data));
        $tanda  = implode(', ', array_fill(0, count($data), '?'));
        $stmt   = $this->db->prepare("INSERT INTO {$this->tabel} ($kolom) VALUES ($tanda)");
        $stmt->execute(array_values($data));
        return (int) $this->db->lastInsertId();
    }

    public function ubah($id, array $data): bool
    {
        $set  = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE {$this->tabel} SET $set WHERE {$this->kunciUtama} = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function hapus($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->tabel} WHERE {$this->kunciUtama} = ?");
        return $stmt->execute([$id]);
    }
}