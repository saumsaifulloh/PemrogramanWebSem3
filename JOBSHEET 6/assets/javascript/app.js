// ========================================
// HAMBURGER MENU
// ========================================

function initNavToggle() {

    const toggleBtn =
        document.getElementById("nav-toggle-btn");

    const nav =
        document.querySelector("header nav");

    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {

        nav.classList.toggle("nav-open");

    });

}


// ========================================
// KONFIRMASI HAPUS + EVENT DELEGATION
// ========================================

function initHapusConfirm() {

    document.addEventListener("click", function (e) {

        // Untuk pengujian Event Delegation
        console.log(e.target);


        const btn =
            e.target.closest(".btn-hapus");

        if (!btn) return;


        const row =
            btn.closest("tr");


        const nama =
            row?.querySelectorAll("td")[1]?.textContent ||
            "data ini";


        const yakin =
            confirm(
                'Yakin ingin menghapus "' +
                nama +
                '"?'
            );


        if (yakin && row) {

            row.remove();

            perbaruiCounter();

        }

    });

}


// ========================================
// COUNTER DATA
// ========================================

function perbaruiCounter() {

    const counterInfo =
        document.getElementById("counter-info");

    const table =
        document.querySelector(
            ".table-responsive table"
        );

    if (!counterInfo || !table) return;


    const rows =
        table.querySelectorAll("tbody tr");


    let jumlahTampil = 0;

    const jumlahTotal =
        rows.length;


    rows.forEach(function (row) {

        if (row.style.display !== "none") {

            jumlahTampil++;

        }

    });


    counterInfo.textContent =
        "Menampilkan " +
        jumlahTampil +
        " dari " +
        jumlahTotal +
        " data";

}


// ========================================
// PENCARIAN REAL-TIME
// ========================================

function initTableFilter() {

    const input =
        document.getElementById("search-input");

    const table =
        document.querySelector(
            ".table-responsive table"
        );

    if (!input || !table) return;


    input.addEventListener(
        "input",
        function () {

            const keyword =
                input.value
                    .toLowerCase()
                    .trim();


            const rows =
                table.querySelectorAll(
                    "tbody tr"
                );


            rows.forEach(function (row) {

                const teks =
                    row.textContent
                        .toLowerCase();


                if (teks.includes(keyword)) {

                    row.style.display = "";

                } else {

                    row.style.display = "none";

                }

            });


            perbaruiCounter();

        }
    );

}


// ========================================
// TAMPILKAN ERROR
// ========================================

function tampilkanError(
    input,
    pesan
) {

    hapusError(input);


    const span =
        document.createElement("span");


    span.className =
        "error";


    span.textContent =
        pesan;


    input.insertAdjacentElement(
        "afterend",
        span
    );

}


// ========================================
// HAPUS ERROR
// ========================================

function hapusError(input) {

    const next =
        input.nextElementSibling;


    if (
        next &&
        next.classList.contains("error")
    ) {

        next.remove();

    }

}


// ========================================
// VALIDASI FORM
// ========================================

function initValidasiForm() {

    const form =
        document.getElementById(
            "form-tambah"
        );


    if (!form) return;


    form.addEventListener(
        "submit",
        function (e) {

            let valid = true;


            // ========================================
            // VALIDASI NAMA
            // ========================================

            const nama =
                form.querySelector(
                    "[name='nama']"
                );


            if (
                nama &&
                nama.value.trim() === ""
            ) {

                tampilkanError(
                    nama,
                    "Nama wajib diisi."
                );

                valid = false;

            } else if (nama) {

                hapusError(nama);

            }


            // ========================================
            // VALIDASI JUDUL
            // ========================================

            const judul =
                form.querySelector(
                    "[name='judul']"
                );


            if (
                judul &&
                judul.value.trim() === ""
            ) {

                tampilkanError(
                    judul,
                    "Judul wajib diisi."
                );

                valid = false;

            } else if (judul) {

                hapusError(judul);

            }


            // ========================================
            // VALIDASI ISBN
            // ========================================

            const isbn =
                form.querySelector(
                    "[name='isbn']"
                );


            if (
                isbn &&
                isbn.value.trim() !== ""
            ) {

                const polaISBN =
                    /^[0-9-]+$/;


                if (
                    !polaISBN.test(
                        isbn.value.trim()
                    )
                ) {

                    tampilkanError(
                        isbn,
                        "ISBN hanya boleh berisi angka dan tanda hubung."
                    );

                    valid = false;

                } else {

                    hapusError(isbn);

                }

            }


            // ========================================
            // CEGAH SUBMIT
            // ========================================

            if (!valid) {

                e.preventDefault();

            }

        }
    );

}


// ========================================
// LOAD DATA TABEL
// ========================================

async function muatDataTabel(
    url,
    buatBarisHTML
) {

    const tbody =
        document.querySelector(
            ".table-responsive table tbody"
        );


    const loading =
        document.getElementById(
            "loading-indicator"
        );


    if (!tbody) return;


    // TAMPILKAN LOADING

    if (loading) {

        loading.style.display =
            "block";

    }


    // KOSONGKAN TABEL

    tbody.innerHTML = "";


    try {

        // ========================================
        // DELAY 3 DETIK
        // ========================================

        await new Promise(function (resolve) {

            setTimeout(
                resolve,
                3000
            );

        });


        // ========================================
        // AMBIL DATA JSON
        // ========================================

        const res =
            await fetch(url);


        // ========================================
        // CEK RESPONSE
        // ========================================

        if (!res.ok) {

            throw new Error(
                "Gagal mengambil data. Status: " +
                res.status
            );

        }


        // ========================================
        // PARSING JSON
        // ========================================

        const daftarData =
            await res.json();


        // ========================================
        // MASUKKAN DATA KE TABEL
        // ========================================

        daftarData.forEach(
            function (item) {

                const tr =
                    document.createElement(
                        "tr"
                    );


                tr.innerHTML =
                    buatBarisHTML(item);


                tbody.appendChild(tr);

            }
        );


        // ========================================
        // UPDATE COUNTER
        // ========================================

        perbaruiCounter();


    } catch (err) {

        // ========================================
        // TAMPILKAN ERROR
        // ========================================

        tbody.innerHTML =
            "<tr>" +
            "<td colspan='5'>" +
            "Gagal memuat data: " +
            err.message +
            "</td>" +
            "</tr>";


        perbaruiCounter();


    } finally {

        // ========================================
        // SEMBUNYIKAN LOADING
        // ========================================

        if (loading) {

            loading.style.display =
                "none";

        }

    }

}


// ========================================
// JALANKAN SEMUA
// ========================================

document.addEventListener(
    "DOMContentLoaded",
    function () {

        initNavToggle();

        initHapusConfirm();

        initTableFilter();

        initValidasiForm();

    }
);