# Wireframe & User Flow — SIMPUS-Mini

Sub-CPMK: Merancang UI/UX aplikasi (proyek).

Halaman yang sudah ada (Beranda, Daftar/Tambah Buku, Daftar/Tambah Anggota — Jobsheet 1-3) belum mencakup fitur Login, Dashboard Petugas, dan Peminjaman/Pengembalian. Dokumen ini merancang wireframe untuk halaman-halaman tersebut sebelum diimplementasikan mulai Jobsheet 5 dan seterusnya.

## Aktor
- **Tamu**: hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login. Tamu juga bisa mendaftar menjadi Anggota lewat halaman Registrasi.
- **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.

## User Flow — Peminjaman Buku

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
        -> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
        -> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Buku

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1]
        -> [Kembali ke Dashboard]
```

## User Flow — Cari Anggota dengan Tunggakan Lewat Jatuh Tempo (Latihan)

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Daftar Anggota"]
        -> [Filter "Tunggakan lewat jatuh tempo"]
        -> [Sistem cek semua transaksi aktif per anggota]
        -> [Tampilkan daftar anggota + jumlah hari terlambat]
        -> [Pilih anggota] -> [Lihat Riwayat Peminjaman anggota tsb.]
```

Catatan alur:
- Langkah "Sistem cek semua transaksi aktif per anggota" bukan halaman,
  melainkan logika di balik layar (mirip "Stok buku berkurang 1" di
  alur Peminjaman) — nantinya dibangun dengan query database.
- Alur ini melengkapi wireframe "Riwayat Peminjaman per Anggota" yang
  sudah ada di bawah, hanya saja dimulai dari pencarian/filter, bukan
  dari memilih satu anggota secara langsung.

## Wireframe: Halaman Login

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|        [ Login Petugas ]            |
|                                      |
|   Username : [______________]       |
|   Password : [______________]       |
|                                      |
|          [   Masuk   ]              |
|                                      |
|   Belum punya akun? Daftar di sini  |
+--------------------------------------+
```

> **Status:** sudah diimplementasikan sebagai HTML statis (belum ada
> logika login sungguhan) di `login.html` — lihat latihan #4.

## Wireframe: Halaman Registrasi Anggota Baru (Latihan)

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|      [ Registrasi Anggota Baru ]    |
|                                      |
|   Nama Lengkap : [______________]   |
|   Email        : [______________]   |
|   Password     : [______________]   |
|   Alamat       : [______________]   |
|   No. HP       : [______________]   |
|                                      |
|          [   Daftar   ]             |
|                                      |
|   Sudah punya akun? Login di sini   |
+--------------------------------------+
```

Ditujukan untuk aktor **Tamu** yang ingin menjadi Anggota perpustakaan
tanpa perlu diinput manual oleh Petugas. Pola form mengikuti field yang
sama seperti form Tambah Anggota (`anggota/tambah.html`), ditambah
`Email` dan `Password` untuk kebutuhan akun. Sudah diimplementasikan
sebagai HTML statis di `registrasi.html`.

## Wireframe: Dashboard Petugas

```
+-----------------------------------------------------+
| SIMPUS-Mini      Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
|-------------------------------------------------------|
|  [Total Buku]   [Total Anggota]   [Sedang Dipinjam]    |
|                                                         |
|  Aksi Cepat:                                           |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]            |
|                                                         |
|  Transaksi Terbaru                                     |
|  --------------------------------------------------    |
|  Anggota | Buku | Tgl Pinjam | Status                  |
+-----------------------------------------------------+
```

## Wireframe: Form Peminjaman

```
+--------------------------------------+
|  Form Peminjaman Buku                |
|--------------------------------------|
|  Anggota : [ dropdown pilih anggota ]|
|  Buku    : [ dropdown, hanya stok>0 ]|
|  Tanggal Pinjam : [ auto: hari ini ] |
|                                      |
|          [  Simpan Peminjaman  ]    |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```
+--------------------------------------+
|  Pengembalian Buku                   |
|--------------------------------------|
|  Cari transaksi aktif:               |
|  [ nama anggota / judul buku ______ ]|
|                                      |
|  Anggota | Buku | Tgl Pinjam | [Kembalikan] |
+--------------------------------------+
```

## Wireframe: Riwayat Peminjaman per Anggota

```
+--------------------------------------+
|  Riwayat Peminjaman — Siti Aminah    |
|--------------------------------------|
|  Buku            | Pinjam   | Kembali | Status      |
|  Laskar Pelangi   | 01/07    | 10/07   | Selesai     |
|  Bumi Manusia      | 15/07    | -       | Dipinjam    |
+--------------------------------------+
```

## Konsistensi dengan Desain yang Sudah Berjalan
- Warna aksen, tipografi navbar, dan gaya tabel/kartu mengikuti `assets/css/style.css` yang sudah dibangun sejak Jobsheet 2-3.
- Navbar akan ditambah menu **Peminjaman** dan indikator status login (nama petugas / tombol Logout) mulai implementasi di Jobsheet 10.
- Edge case yang perlu ditangani saat implementasi: buku stok habis tidak boleh dipilih di form peminjaman; anggota dengan tunggakan terlambat divalidasi di Jobsheet 12 (tugas mandiri).

## Edge Case Tambahan (Latihan)

- **Peminjaman ganda buku yang sama ke anggota yang sama**: sistem harus
  menolak (atau menampilkan konfirmasi) kalau Petugas mencoba
  meminjamkan buku yang sama ke anggota yang sama dua kali berturut-turut
  selagi transaksi pertama masih berstatus "Dipinjam" — mencegah data
  transaksi ganda untuk pasangan anggota+buku yang sama.
- **Email registrasi sudah terdaftar**: form Registrasi Anggota Baru
  perlu validasi email unik; kalau sudah dipakai anggota lain,
  tampilkan pesan error dan arahkan ke halaman Login.
- **Tamu mencoba mengakses langsung URL Dashboard/Peminjaman tanpa
  login**: harus di-redirect ke halaman Login (bagian dari otorisasi,
  lihat catatan aktor di atas).
- **Buku dihapus padahal masih ada transaksi aktif**: perlu dicegah agar
  data riwayat peminjaman tidak kehilangan referensi ke buku yang
  sudah tidak ada.