<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// --- Pencarian server-side + pagination ---
$perPage = 5;
$q       = trim($_GET['q'] ?? '');
$page    = max(1, (int) ($_GET['page'] ?? 1));
$kw      = '%' . addcslashes($q, '%_\\') . '%';

$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
$stmtCount->execute(['kw' => $kw]);
$totalData  = (int) $stmtCount->fetchColumn();
$totalPages = max(1, (int) ceil($totalData / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;

$stmt = $pdo->prepare(
    "SELECT * FROM buku WHERE judul ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset"
);
$stmt->bindValue(':kw', $kw);
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Daftar Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form class="search-box" method="get" action="list.php">
        <label for="search-input">Cari Judul Buku</label>
        <div class="search-row">
            <!-- value belum di-escape: sengaja, diperbaiki (XSS) di Jobsheet 11 -->
            <input type="text" id="search-input" name="q" placeholder="Ketik judul buku..." value="<?php echo $q; ?>">
            <button type="submit">Cari</button>
            <?php if ($q !== ''): ?>
                <a class="reset" href="list.php">Reset</a>
            <?php endif; ?>
        </div>
    </form>

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
                    <tr><td colspan="8"><?php echo $q !== '' ? 'Data tidak ditemukan.' : 'Belum ada data buku.'; ?></td></tr>
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
                        <td>
                            <div class="aksi">
                                <a class="btn-edit" href="edit.php?id=<?php echo $b['id']; ?>">Edit</a>
                                <form class="form-hapus" method="post" action="hapus.php"
                                      data-nama="<?php echo htmlspecialchars($b['judul']); ?>">
                                    <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                                    <input type="hidden" name="q" value="<?php echo htmlspecialchars($q); ?>">
                                    <input type="hidden" name="page" value="<?php echo $page; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <p class="info-hasil">
        Total <?php echo $totalData; ?> data &mdash; halaman <?php echo $page; ?> dari <?php echo $totalPages; ?>
    </p>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?<?php echo http_build_query(['q' => $q, 'page' => $page - 1]); ?>">&laquo;</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i === $page): ?>
                    <span class="current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?<?php echo http_build_query(['q' => $q, 'page' => $i]); ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?<?php echo http_build_query(['q' => $q, 'page' => $page + 1]); ?>">&raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
