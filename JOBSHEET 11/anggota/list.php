<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// --- Pencarian server-side + pagination ---
$perPage = 5;
$q       = trim($_GET['q'] ?? '');
$page    = max(1, (int) ($_GET['page'] ?? 1));
$kw      = '%' . addcslashes($q, '%_\\') . '%';

$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama ILIKE :kw");
$stmtCount->execute(['kw' => $kw]);
$totalData  = (int) $stmtCount->fetchColumn();
$totalPages = max(1, (int) ceil($totalData / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;

$stmt = $pdo->prepare(
    "SELECT * FROM anggota WHERE nama ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset"
);
$stmt->bindValue(':kw', $kw);
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarAnggota = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Daftar Anggota</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form class="search-box" method="get" action="list.php">
        <label for="search-input">Cari Anggota</label>
        <div class="search-row">
            
            <input type="text" id="search-input" name="q" placeholder="Ketik nama anggota..." value="<?php echo e($q); ?>">
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
                    <th>ID</th><th>Nama</th><th>No. Anggota</th>
                    <th>Alamat</th><th>No. HP</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarAnggota)): ?>
                    <tr><td colspan="6"><?php echo $q !== '' ? 'Data tidak ditemukan.' : 'Belum ada data anggota.'; ?></td></tr>
                <?php else: ?>
                    <?php foreach ($daftarAnggota as $a): ?>
                    <tr>
                        <td><?php echo $a['id']; ?></td>
                        <td><?php echo e($a['nama']); ?></td>
                        <td><?php echo e($a['no_anggota']); ?></td>
                        <td><?php echo e($a['alamat'] ?? ''); ?></td>
                        <td><?php echo e($a['no_hp'] ?? ''); ?></td>
                        <td>
                            <div class="aksi">
                                <a class="btn-edit" href="edit.php?id=<?php echo $a['id']; ?>">Edit</a>
                                \1
        <?php echo csrf_field(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                                    <input type="hidden" name="q" value="<?php echo e($q); ?>">
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
