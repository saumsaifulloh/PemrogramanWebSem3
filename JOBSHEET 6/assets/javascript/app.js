// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (yakin && row) {
            row.remove();
            const table = document.querySelector(".table-responsive table");
            const counter = document.getElementById("counter-info");
            if (table && counter) {
                const semuaBaris = table.querySelectorAll("tbody tr");
                counter.textContent = "Menampilkan " + semuaBaris.length + " dari " + semuaBaris.length + " data";
            }
        }
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    function perbaruiCounter() {
        const counter = document.getElementById("counter-info");
        if (!counter) return;
        const semuaBaris = table.querySelectorAll("tbody tr");
        const barisTampil = table.querySelectorAll("tbody tr:not([style*='display: none'])");
        counter.textContent = "Menampilkan " + barisTampil.length + " dari " + semuaBaris.length + " data";
    }

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.querySelector("td")?.textContent.toLowerCase() ?? "";
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
        perbaruiCounter();
    });
    perbaruiCounter();
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

     const aturanValidasi = [
        {
            selector: "[name='judul'], [name='nama']",
            cek: function (nilai) { return nilai.trim() !== ""; },
            pesan: "Field ini wajib diisi."
        },
        {
            selector: "[name='pengarang']",
            cek: function (nilai) { return nilai.trim() !== ""; },
            pesan: "Pengarang wajib diisi."
        },
        {
            selector: "[name='tahun']",
            cek: function (nilai) {
                const n = parseInt(nilai, 10);
                return !isNaN(n) && n >= 1900 && n <= 2026;
            },
            pesan: "Tahun harus di antara 1900-2026."
        },
        {
            selector: "[name='stok']",
            cek: function (nilai) {
                const n = parseInt(nilai, 10);
                return !isNaN(n) && n >= 0;
            },
            pesan: "Stok tidak boleh negatif."
        },
        {
            selector: "[name='isbn']",
            cek: function (nilai) {
                if (nilai.trim() === "") return true;
                return /^[0-9-]+$/.test(nilai.trim());
            },
            pesan: "ISBN hanya boleh berisi angka dan tanda hubung."
        }
    ];

    form.addEventListener("submit", function (e) {
        let valid = true;

        aturanValidasi.forEach(function (aturan) {
            const field = form.querySelector(aturan.selector);
            if (!field) return;

            if (aturan.cek(field.value)) {
                hapusError(field);
            } else {
                tampilkanError(field, aturan.pesan);
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
}
// ===== Fungsi generik: fetch + render tabel dari JSON =====
async function muatDataTabel(url, buatBarisHTML) {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch(url);
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarData = await res.json();

        daftarData.forEach(function (item) {
            const tr = document.createElement("tr");
            tr.innerHTML = buatBarisHTML(item);
            tbody.appendChild(tr);
        });

        const counter = document.getElementById("counter-info");
        if (counter) {
            counter.textContent = "Menampilkan " + daftarData.length + " dari " + daftarData.length + " data";
        }
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});