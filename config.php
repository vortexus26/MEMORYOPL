<?php
$host = 'localhost';
$db   = 'vortexus26';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Pastikan kolom jurusan tersedia untuk fitur filter jurusan.
try {
    $column = $pdo->query("SHOW COLUMNS FROM media LIKE 'jurusan'")->fetch();
    if (!$column) {
        $pdo->exec("ALTER TABLE media ADD jurusan VARCHAR(20) NOT NULL DEFAULT 'LAINNYA' AFTER type");
    }
} catch (Throwable $e) {
    // Jika hosting membatasi ALTER TABLE, import database/vortexus26.sql versi terbaru.
}
?>
