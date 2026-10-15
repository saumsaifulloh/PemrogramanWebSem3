<?php
session_start();

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
