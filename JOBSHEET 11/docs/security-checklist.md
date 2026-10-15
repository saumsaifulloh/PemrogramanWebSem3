# Security Checklist — Jobsheet 11

## 1. XSS (Cross-Site Scripting)
- [x] `includes/helpers.php` menyediakan `e()` berbasis `htmlspecialchars` dengan UTF-8 dan `ENT_QUOTES`.
- [x] Output judul/pengarang/ISBN/kategori buku, nama/no anggota/alamat/no HP, nilai pencarian, flash message, judul halaman, dan nama petugas di-navbar di-escape.
- Uji: simpan judul buku `<script>alert(1)</script>`. Pada daftar buku, teks harus tampil literal dan tidak menjalankan JavaScript.

## 2. CSRF (Cross-Site Request Forgery)
- [x] `includes/csrf.php` menyediakan `csrf_token()`, `csrf_field()`, dan `csrf_verify()`.
- [x] Token tersembunyi ada pada form POST tambah/edit/hapus buku dan anggota serta Login/Register.
- [x] Semua endpoint pemrosesan POST memvalidasi token sebelum akses database.
- Uji tanpa token: `curl -i -X POST http://localhost:8000/buku/proses_tambah.php -d "judul=x"`.
  Jika belum login, endpoint dilindungi guard autentikasi dan mengarahkan ke Login. Setelah login, permintaan POST tanpa token menghasilkan HTTP 403.

## 3. Session Fixation
- [x] `auth/proses_login.php` memanggil `session_regenerate_id(true)` setelah kredensial berhasil diverifikasi dan sebelum menyimpan identitas pengguna ke sesi.

## 4. SQL Injection
- [x] Query input pengguna menggunakan PDO prepared statements dan parameter binding.
- Tidak ada perubahan pola query yang diperlukan pada audit ini.

## 5. Urutan guard
- [x] Endpoint proses buku/anggota memuat `includes/auth.php` sebelum memanggil `csrf_verify()`.
- Permintaan tanpa sesi login dialihkan ke halaman login sebelum token CSRF diperiksa.

## Catatan pengujian
Pastikan database PostgreSQL `simpus_mini` aktif, jalankan `sql/01_buku_anggota.sql` dan `sql/02_users.sql`, lalu jalankan aplikasi dari folder proyek dengan `php -S localhost:8000`.
