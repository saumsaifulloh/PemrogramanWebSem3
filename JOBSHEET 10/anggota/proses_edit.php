<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method tidak diizinkan.');
}

$id        = (int) ($_POST['id'] ?? 0);
$nama      = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat    = trim($_POST['alamat'] ?? '');
$noHp      = trim($_POST['no_hp'] ?? '');

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID anggota tidak valid.'];
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nama === '')      $errors[] = "Nama wajib diisi.";
if ($noAnggota === '') $errors[] = "No. Anggota wajib diisi.";

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . $id);
    exit;
}

require __DIR__ . '/../includes/koneksi.php';

try {
    $stmt = $pdo->prepare(
        "UPDATE anggota
            SET nama = :nama, no_anggota = :no_anggota, alamat = :alamat, no_hp = :no_hp
          WHERE id = :id"
    );
    $stmt->execute([
        'nama'       => $nama,
        'no_anggota' => $noAnggota,
        'alamat'     => $alamat,
        'no_hp'      => $noHp,
        'id'         => $id,
    ]);
} catch (PDOException $e) {
    // 23505 = unique_violation (no_anggota dipakai anggota lain)
    $pesan = $e->getCode() === '23505'
        ? 'No. Anggota sudah dipakai anggota lain.'
        : 'Gagal menyimpan perubahan.';
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => $pesan];
    header('Location: edit.php?id=' . $id);
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diperbarui.'];
header('Location: list.php');
exit;
