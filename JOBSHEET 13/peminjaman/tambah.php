<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Peminjaman Baru";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';
$anggota=$pdo->query("SELECT id,nama,no_anggota FROM anggota ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);
$buku=$pdo->query("SELECT id,judul,pengarang,stok FROM buku WHERE stok > 0 ORDER BY judul")->fetchAll(PDO::FETCH_ASSOC);
$flash=$_SESSION['flash']??null; unset($_SESSION['flash']);
?>
<section><h2>Peminjaman Baru</h2>
<?php if($flash): ?><p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p><?php endif; ?>
<?php if(!$anggota): ?><p>Belum ada anggota. Tambahkan anggota terlebih dahulu.</p>
<?php elseif(!$buku): ?><p>Tidak ada buku dengan stok tersedia.</p>
<?php else: ?><form method="post" action="proses_tambah.php"><?php echo csrf_field(); ?>
<p><label for="anggota_id">Anggota</label><select id="anggota_id" name="anggota_id" required><option value="">-- Pilih anggota --</option>
<?php foreach($anggota as $a): ?><option value="<?php echo (int)$a['id']; ?>"><?php echo e($a['nama']); ?> (<?php echo e($a['no_anggota']); ?>)</option><?php endforeach; ?></select></p>
<p><label for="buku_id">Buku</label><select id="buku_id" name="buku_id" required><option value="">-- Pilih buku --</option>
<?php foreach($buku as $b): ?><option value="<?php echo (int)$b['id']; ?>"><?php echo e($b['judul']); ?> — <?php echo e($b['pengarang']); ?> (stok: <?php echo (int)$b['stok']; ?>)</option><?php endforeach; ?></select></p>
<p><button type="submit">Simpan Peminjaman</button></p></form><?php endif; ?></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
