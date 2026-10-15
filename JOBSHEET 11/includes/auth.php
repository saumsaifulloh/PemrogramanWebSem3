<?php
// Guard autentikasi untuk halaman pemrosesan yang hanya boleh diakses petugas.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (empty($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
