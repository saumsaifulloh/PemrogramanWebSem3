<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAnggota = $pdo->query("SELECT * FROM anggota ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Daftar Anggota</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Anggota</label>
        <input type="text" id="search-input" placeholder="Ketik nama anggota...">
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Nama</th><th>No. Anggota</th>
                    <th>Alamat</th><th>No. HP</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarAnggota)): ?>
                    <tr><td colspan="6">Belum ada data anggota.</td></tr>
                <?php else: ?>
                    <?php foreach ($daftarAnggota as $a): ?>
                    <tr>
                        <td><?php echo $a['id']; ?></td>
                        <td><?php echo htmlspecialchars($a['nama']); ?></td>
                        <td><?php echo htmlspecialchars($a['no_anggota']); ?></td>
                        <td><?php echo htmlspecialchars($a['alamat'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($a['no_hp'] ?? ''); ?></td>
                        <td><button type="button" class="btn-hapus">Hapus</button></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>