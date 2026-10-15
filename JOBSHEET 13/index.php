<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalBuku    = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
$sedangDipinjam = $pdo->query("SELECT COUNT(*) FROM peminjaman WHERE status = 'dipinjam'")->fetchColumn();
?>
<section>
    <h2>Selamat Datang di SIMPUS-Mini</h2>
    <p>Sistem informasi perpustakaan mini untuk mengelola data buku dan anggota.</p>
</section>

<section>
    <article><h3>Total Buku</h3><p><?php echo $totalBuku; ?></p></article>
    <article><h3>Total Anggota</h3><p><?php echo $totalAnggota; ?></p></article>
    <article><h3>Sedang Dipinjam</h3><p><?php echo (int) $sedangDipinjam; ?></p></article>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
