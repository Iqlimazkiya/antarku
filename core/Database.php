<?php
class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $c = require __DIR__ . '/../config/database.php';
            $host    = $c['host'] ?? 'localhost';
            $port    = $c['port'] ?? 3306;
            $dbname  = $c['dbname'] ?? $c['database'] ?? 'antarku';
            $user    = $c['user'] ?? $c['username'] ?? 'root';
            $pass    = $c['pass'] ?? $c['password'] ?? '';
            $charset = $c['charset'] ?? 'utf8mb4';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die('Koneksi gagal: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
