<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarBuku = $pdo->query("SELECT * FROM buku ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Daftar Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Judul Buku</label>
        <input type="text" id="search-input" placeholder="Ketik judul buku...">
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Judul</th><th>Pengarang</th>
                    <th>Tahun</th><th>ISBN</th><th>Stok</th><th>Kategori</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarBuku)): ?>
                    <tr><td colspan="8">Belum ada data buku.</td></tr>
                <?php else: ?>
                    <?php foreach ($daftarBuku as $b): ?>
                    <tr>
                        <td><?php echo $b['id']; ?></td>
                        <td><?php echo htmlspecialchars($b['judul']); ?></td>
                        <td><?php echo htmlspecialchars($b['pengarang']); ?></td>
                        <td><?php echo $b['tahun']; ?></td>
                        <td><?php echo htmlspecialchars($b['isbn'] ?? ''); ?></td>
                        <td><?php echo $b['stok']; ?></td>
                        <td><?php echo htmlspecialchars($b['kategori'] ?? ''); ?></td>
                        <td><button type="button" class="btn-hapus">Hapus</button></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>