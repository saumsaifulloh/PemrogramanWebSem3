# Jobsheet 13 — Deployment & Dokumentasi SIMPUS-Mini

SIMPUS-Mini adalah aplikasi perpustakaan sederhana dengan PHP native, PostgreSQL, PDO_PGSQL, HTML, CSS, dan JavaScript.

## Fitur
- Tamu: melihat beranda/statistik dan daftar buku.
- Petugas: CRUD buku dan anggota, transaksi peminjaman, pengembalian, serta riwayat.
- Keamanan dasar: password hash, prepared statements, CSRF token, helper escaping HTML, dan pengecekan sesi.

## Persiapan
Pastikan PHP CLI, ekstensi `pdo_pgsql`, PostgreSQL, dan `psql` tersedia.

## Membuat database
Jalankan dari direktori `JOBSHEET 13`:

```bash
createdb simpus_mini
psql -d simpus_mini -f sql/01_buku_anggota.sql
psql -d simpus_mini -f sql/02_users.sql
psql -d simpus_mini -f sql/03_peminjaman.sql
```

Urutan SQL penting karena tabel `peminjaman` memiliki foreign key ke `buku` dan `anggota`.

## Konfigurasi database
Aplikasi membaca environment variable `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, dan `DB_PASS`. Jika tidak diatur, aplikasi memakai fallback lokal di `includes/config.php`.

Contoh Linux/macOS:

```bash
DB_HOST=127.0.0.1 DB_PORT=5432 DB_NAME=simpus_mini DB_USER=postgres DB_PASS=postgres php -S localhost:8000
```

Contoh Windows PowerShell:

```powershell
$env:DB_HOST="127.0.0.1"
$env:DB_PORT="5432"
$env:DB_NAME="simpus_mini"
$env:DB_USER="postgres"
$env:DB_PASS="postgres"
php -S localhost:8000
```

Kemudian buka `http://localhost:8000/index.php`. Buat akun petugas melalui `http://localhost:8000/auth/register.php`.

## Laragon
Salin folder ini ke direktori web Laragon, siapkan PostgreSQL dan database seperti langkah di atas, lalu arahkan virtual host ke folder proyek. Contoh URL lokal dapat berupa `http://jobsheet13.test/`.

## Deployment publik
- Gunakan HTTPS dan user database khusus dengan hak akses minimum.
- Atur environment variable melalui konfigurasi hosting, bukan dengan menyimpan password produksi di repository.
- Nonaktifkan atau batasi halaman registrasi setelah akun petugas pertama dibuat.
- Pastikan direktori proyek tidak dapat menampilkan daftar file dan file konfigurasi/backup tidak bisa diunduh publik.
- Backup database secara berkala.

## Dokumentasi
- `docs/wireframe.md`: rancangan halaman.
- `docs/security-checklist.md`: daftar pemeriksaan keamanan.
- `docs/manual-pengguna.md`: panduan pengguna.
