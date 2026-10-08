<?php
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';
?>
<section>
    <h2>Tambah Buku</h2>
    <form>
        <p>
            <label for="judul">Judul Buku</label><br>
            <input type="text" id="judul" name="judul" required>
        </p>
        <p>
            <label for="penulis">Penulis</label><br>
            <input type="text" id="penulis" name="penulis" required>
        </p>
        <p>
            <label for="tahun_terbit">Tahun Terbit</label><br>
            <input type="number" id="tahun_terbit" name="tahun_terbit" required>
        </p>
        <p>
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <option value="Teknologi">Teknologi</option>
                <option value="Fiksi">Fiksi</option>
                <option value="Manajemen">Manajemen</option>
            </select>
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
