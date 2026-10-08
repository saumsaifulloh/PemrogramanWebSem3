<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
require __DIR__ . '/../includes/koneksi.php';
$daftarBuku = $pdo->query("SELECT * FROM buku ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Daftar Buku</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Pemrograman Web</td>
                    <td>Andi</td>
                    <td>2024</td>
                    <td>Teknologi</td>
                    <td>
                        <button type="button" class="btn-hapus">
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Belajar PHP</td>
                    <td>Budi</td>
                    <td>2023</td>
                    <td>Teknologi</td>
                    <td>
                        <button type="button" class="btn-hapus">
                            Hapus
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>