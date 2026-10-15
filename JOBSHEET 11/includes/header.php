<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini | <?php echo e($page_title ?? 'Beranda'); ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
<header>
    <h1>
        <a href="<?php echo $base; ?>index.php">
            SIMPUS-Mini
        </a>
    </h1>
    <button
        type="button"
        id="nav-toggle-btn"
        class="nav-toggle-label"
        aria-label="Menu"
    >
        &#9776;
    </button>
    <nav>
        <ul>
            <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
            <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
            <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
            <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
            <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <li>Petugas: <?php echo e($_SESSION['nama'] ?? $_SESSION['username'] ?? ''); ?></li>
                <li><a href="<?php echo $base; ?>auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="<?php echo $base; ?>auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
