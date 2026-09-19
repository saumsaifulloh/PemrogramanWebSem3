// Mengambil & menampilkan Daftar Buku secara asinkron dari data/buku.json
function muatDaftarBuku() {
    return muatDataTabel("../data/buku.json", function (buku) {
        return "<td>" + buku.judul + "</td>" +
            "<td>" + buku.pengarang + "</td>" +
            "<td>" + buku.tahun + "</td>" +
            "<td>" + buku.stok + "</td>" +
            "<td>" + buku.kategori + "</td>" +
            "<td>" +
            "<button type=\"button\">Edit</button> " +
            "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
            "</td>";
    });
}

document.addEventListener("DOMContentLoaded", muatDaftarBuku);

document.addEventListener("DOMContentLoaded", function () {
    const btnMuatUlang = document.getElementById("btn-muat-ulang");
    if (btnMuatUlang) {
        btnMuatUlang.addEventListener("click", muatDaftarBuku);
    }
});