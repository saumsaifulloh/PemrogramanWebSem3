<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: register.php'); exit; }
$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($nama === '' || $username === '' || strlen($password) < 6) {
    $_SESSION['flash'] = ['type'=>'error','pesan'=>'Semua data wajib diisi dan password minimal 6 karakter.'];
    header('Location: register.php'); exit;
}
require __DIR__ . '/../includes/koneksi.php';
try {
    $cek = $pdo->prepare('SELECT id FROM users WHERE username = :username');
    $cek->execute(['username'=>$username]);
    if ($cek->fetch()) {
        $_SESSION['flash'] = ['type'=>'error','pesan'=>'Username sudah digunakan.'];
        header('Location: register.php'); exit;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, 'petugas')");
    $stmt->execute(['nama'=>$nama,'username'=>$username,'password'=>$hash]);
    $_SESSION['flash'] = ['type'=>'success','pesan'=>'Registrasi berhasil. Silakan login.'];
    header('Location: login.php'); exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type'=>'error','pesan'=>'Registrasi gagal. Coba username lain.'];
    header('Location: register.php'); exit;
}
