<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php'; // Auth guard harus berjalan sebelum CSRF.
require_once __DIR__ . '/../includes/csrf.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
}

// Hanya menerima POST (bukan GET) agar tidak terpicu lewat link/crawler.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method tidak diizinkan. Gunakan tombol Hapus pada halaman daftar.');
}

$id = (int) ($_POST['id'] ?? 0);

$kembali = 'list.php?' . http_build_query([
    'q'    => trim($_POST['q'] ?? ''),
    'page' => max(1, (int) ($_POST['page'] ?? 1)),
]);

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID anggota tidak valid.'];
    header('Location: ' . $kembali);
    exit;
}

require __DIR__ . '/../includes/koneksi.php';

try {
    $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data anggota tidak ditemukan.'];
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data.'];
}

header('Location: ' . $kembali);
exit;
