<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: login.php'); exit; }
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
require __DIR__ . '/../includes/koneksi.php';
$stmt = $pdo->prepare('SELECT id, nama, username, password, role FROM users WHERE username = :username');
$stmt->execute(['username'=>$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['flash'] = ['type'=>'error','pesan'=>'Username atau password salah.'];
    header('Location: login.php'); exit;
}
session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];
header('Location: ../index.php'); exit;
