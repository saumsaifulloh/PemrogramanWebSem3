<?php
require_once __DIR__ . '/../includes/auth.php';
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data buku tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$kategoriList = ['Teknologi', 'Fiksi', 'Manajemen'];
?>
<section>
    <h2>Edit Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form action="proses_edit.php" method="post">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
        <p>
            <label for="judul">Judul Buku</label>
            <input type="text" id="judul" name="judul" value="<?php echo e($buku['judul']); ?>">
        </p>
        <p>
            <label for="pengarang">Pengarang</label>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo e($buku['pengarang']); ?>">
        </p>
        <p>
            <label for="tahun">Tahun Terbit</label>
            <input type="number" id="tahun" name="tahun" value="<?php echo (int) $buku['tahun']; ?>">
        </p>
        <p>
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo e($buku['isbn'] ?? ''); ?>">
        </p>
        <p>
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" value="<?php echo (int) $buku['stok']; ?>">
        </p>
        <p>
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori">
                <?php foreach ($kategoriList as $k): ?>
                    <option value="<?php echo $k; ?>" <?php echo ($buku['kategori'] === $k) ? 'selected' : ''; ?>>
                        <?php echo $k; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Simpan Perubahan</button>
            <a class="btn-batal" href="list.php">Batal</a>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
