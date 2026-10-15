<?php
if(session_status()!==PHP_SESSION_ACTIVE){session_start();} require_once __DIR__.'/../includes/helpers.php'; require_once __DIR__.'/../includes/auth.php'; require_once __DIR__.'/../includes/csrf.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Method tidak diizinkan.');} csrf_verify();
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT); if(!$id){$_SESSION['flash']=['type'=>'error','pesan'=>'ID peminjaman tidak valid.'];header('Location: kembali.php');exit;} require __DIR__.'/../includes/koneksi.php';
try{$pdo->beginTransaction();$stmt=$pdo->prepare("SELECT buku_id FROM peminjaman WHERE id=:id AND status='dipinjam' FOR UPDATE");$stmt->execute(['id'=>$id]);$p=$stmt->fetch(PDO::FETCH_ASSOC);
if(!$p)throw new RuntimeException('Transaksi tidak ditemukan atau sudah dikembalikan.');
$lock=$pdo->prepare('SELECT id FROM buku WHERE id=:id FOR UPDATE');$lock->execute(['id'=>$p['buku_id']]);if(!$lock->fetch())throw new RuntimeException('Data buku tidak ditemukan.');
$upd=$pdo->prepare("UPDATE peminjaman SET status='selesai',tanggal_kembali=CURRENT_DATE WHERE id=:id AND status='dipinjam'");$upd->execute(['id'=>$id]);if($upd->rowCount()!==1)throw new RuntimeException('Status peminjaman berubah. Coba lagi.');
$stok=$pdo->prepare('UPDATE buku SET stok=stok+1 WHERE id=:id');$stok->execute(['id'=>$p['buku_id']]);$pdo->commit();$_SESSION['flash']=['type'=>'success','pesan'=>'Buku berhasil dikembalikan.'];
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();$_SESSION['flash']=['type'=>'error','pesan'=>$e instanceof RuntimeException?$e->getMessage():'Pengembalian gagal diproses.'];} header('Location: kembali.php');exit;
