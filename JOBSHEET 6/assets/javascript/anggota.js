// Mengambil & menampilkan Daftar Anggota secara asinkron dari data/anggota.json
function muatDaftarAnggota() {
    return muatDataTabel("../data/anggota.json", function (anggota) {
        return "<td>" + anggota.no_anggota + "</td>" +
            "<td>" + anggota.nama + "</td>" +
            "<td>" + anggota.alamat + "</td>" +
            "<td>" + anggota.no_hp + "</td>" +
            "<td>" +
            "<button type=\"button\">Edit</button> " +
            "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
            "</td>";
    });
}

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);