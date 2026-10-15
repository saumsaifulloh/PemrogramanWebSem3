<?php
$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Edit Anggota</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    \1
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
        <p>
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?php echo e($anggota['nama']); ?>">
        </p>
        <p>
            <label for="no_anggota">No. Anggota</label>
            <input type="text" id="no_anggota" name="no_anggota" value="<?php echo e($anggota['no_anggota']); ?>">
        </p>
        <p>
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo e($anggota['alamat'] ?? ''); ?>">
        </p>
        <p>
            <label for="no_hp">No. HP</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo e($anggota['no_hp'] ?? ''); ?>">
        </p>
        <p>
            <button type="submit">Simpan Perubahan</button>
            <a class="btn-batal" href="list.php">Batal</a>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
