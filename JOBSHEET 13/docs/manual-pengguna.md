# Manual Pengguna SIMPUS-Mini

## 1. Membuka aplikasi
Buka URL aplikasi pada browser. Beranda menampilkan statistik jumlah buku, anggota, dan peminjaman aktif. Tamu dapat melihat beranda dan daftar buku.

## 2. Membuat akun petugas
1. Buka menu **Register** atau akses `auth/register.php`.
2. Isi nama, username, dan password.
3. Setelah akun dibuat, buka halaman Login dan masuk menggunakan akun tersebut.

> Untuk deployment publik, batasi pendaftaran akun setelah akun petugas pertama dibuat. Jangan biarkan registrasi terbuka tanpa pengawasan.

## 3. Mengelola buku
Setelah login, buka **Daftar Buku** untuk mencari data. Gunakan **Tambah Buku** untuk memasukkan judul, pengarang, tahun, ISBN, stok, dan kategori. Petugas dapat mengedit atau menghapus data buku.

## 4. Mengelola anggota
Petugas membuka **Daftar Anggota** untuk mencari, menambah, mengubah, atau menghapus data anggota. Nomor anggota harus unik.

## 5. Peminjaman
1. Buka **Peminjaman Baru**.
2. Pilih anggota dan buku yang tersedia.
3. Simpan transaksi. Sistem memeriksa stok dan mengurangi stok dalam transaksi database.
4. Jika stok habis atau data tidak valid, aplikasi menolak transaksi.

## 6. Pengembalian dan riwayat
Buka **Pengembalian** lalu pilih transaksi yang masih berstatus dipinjam. Setelah dikonfirmasi, status menjadi selesai, tanggal kembali diisi, dan stok buku bertambah satu. **Riwayat** menampilkan transaksi peminjaman sebelumnya.

## 7. Logout
Pilih **Logout** setelah selesai menggunakan aplikasi.
