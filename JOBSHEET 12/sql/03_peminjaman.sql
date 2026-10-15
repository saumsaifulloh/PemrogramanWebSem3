-- Jobsheet 12: transaksi peminjaman buku (PostgreSQL)
CREATE TABLE IF NOT EXISTS peminjaman (
 id SERIAL PRIMARY KEY,
 anggota_id INTEGER NOT NULL REFERENCES anggota(id) ON UPDATE CASCADE ON DELETE RESTRICT,
 buku_id INTEGER NOT NULL REFERENCES buku(id) ON UPDATE CASCADE ON DELETE RESTRICT,
 tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
 tanggal_kembali DATE,
 status VARCHAR(20) NOT NULL DEFAULT 'dipinjam' CHECK (status IN ('dipinjam','selesai')),
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT chk_tanggal_kembali CHECK (tanggal_kembali IS NULL OR tanggal_kembali >= tanggal_pinjam)
);
CREATE INDEX IF NOT EXISTS idx_peminjaman_status ON peminjaman(status);
CREATE INDEX IF NOT EXISTS idx_peminjaman_anggota ON peminjaman(anggota_id);
