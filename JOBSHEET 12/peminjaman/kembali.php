<?php
require __DIR__.'/../includes/auth.php'; $page_title="Pengembalian"; include __DIR__.'/../includes/header.php'; require __DIR__.'/../includes/koneksi.php';
$flash=$_SESSION['flash']??null; unset($_SESSION['flash']);
$stmt=$pdo->query("SELECT p.id,p.tanggal_pinjam,a.nama AS nama_anggota,a.no_anggota,b.judul FROM peminjaman p JOIN anggota a ON a.id=p.anggota_id JOIN buku b ON b.id=p.buku_id WHERE p.status='dipinjam' ORDER BY p.tanggal_pinjam,p.id"); $aktif=$stmt->fetchAll(PDO::FETCH_ASSOC);
?><section><h2>Pengembalian Buku</h2><?php if($flash): ?><p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p><?php endif; ?>
<div class="table-responsive"><table><thead><tr><th>ID</th><th>Anggota</th><th>Buku</th><th>Tanggal Pinjam</th><th>Aksi</th></tr></thead><tbody>
<?php if(!$aktif): ?><tr><td colspan="5">Tidak ada peminjaman aktif.</td></tr><?php else: foreach($aktif as $p): ?><tr><td><?php echo (int)$p['id']; ?></td><td><?php echo e($p['nama_anggota']); ?> (<?php echo e($p['no_anggota']); ?>)</td><td><?php echo e($p['judul']); ?></td><td><?php echo e($p['tanggal_pinjam']); ?></td><td><form method="post" action="proses_kembali.php" onsubmit="return confirm('Proses pengembalian buku ini?');"><?php echo csrf_field(); ?><input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>"><button type="submit">Kembalikan</button></form></td></tr><?php endforeach; endif; ?>
</tbody></table></div></section><?php include __DIR__.'/../includes/footer.php'; ?>
