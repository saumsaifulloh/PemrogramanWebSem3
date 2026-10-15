<?php
$config = require __DIR__ . '/config.php';
$dsn = sprintf(
    'pgsql:host=%s;port=%s;dbname=%s',
    $config['host'],
    $config['port'],
    $config['name']
);

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    error_log('Koneksi database SIMPUS-Mini gagal: ' . $e->getMessage());
    http_response_code(500);
    exit('Koneksi database gagal. Periksa konfigurasi PostgreSQL.');
}
