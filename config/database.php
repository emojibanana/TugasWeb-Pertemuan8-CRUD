<?php
class Database {
    private static $instance = null;
    private $conn;

    //Private itu gk bisa 'new' dari luar
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=localhost;dbname=inventaris_db;charset=utf8mb4","root","",
                [
                    // 1. Mode error — lempar exception saat error
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // 2. Fetch mode — kembalikan associative array
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // 3. Nonaktifkan emulasi — pakai real prepared statement
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            die ("Koneksi gagal: ". $e->getMessage());
        }
    }

    // Cara ambil koneksi
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>