function muatDaftarBuku() {

    return muatDataTabel(
        "../data/buku.json",

        function (buku) {

            return (

                "<td>" +
                buku.judul +
                "</td>" +

                "<td>" +
                buku.pengarang +
                "</td>" +

                "<td>" +
                buku.tahun +
                "</td>" +

                "<td>" +
                buku.stok +
                "</td>" +

                "<td>" +

                "<button type='button'>" +
                "Edit" +
                "</button> " +

                "<button type='button' class='btn-hapus'>" +
                "Hapus" +
                "</button>" +

                "</td>"

            );

        }

    );

}


// ========================================
// TOMBOL MUAT ULANG
// ========================================

function initTombolMuatUlang() {

    const tombol =
        document.getElementById("btn-muat-ulang");

    if (!tombol) return;

    tombol.addEventListener(
        "click",
        function () {

            muatDaftarBuku();

        }
    );

}


// ========================================
// JALANKAN
// ========================================

document.addEventListener(
    "DOMContentLoaded",
    function () {

        muatDaftarBuku();

        initTombolMuatUlang();

    }
);