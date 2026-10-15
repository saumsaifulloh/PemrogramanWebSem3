<?php
if(session_status()!==PHP_SESSION_ACTIVE){session_start();}
require_once __DIR__.'/../includes/helpers.php'; require_once __DIR__.'/../includes/auth.php'; require_once __DIR__.'/../includes/csrf.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Method tidak diizinkan.');} csrf_verify();
$anggotaId=filter_input(INPUT_POST,'anggota_id',FILTER_VALIDATE_INT); $bukuId=filter_input(INPUT_POST,'buku_id',FILTER_VALIDATE_INT);
if(!$anggotaId||!$bukuId){$_SESSION['flash']=['type'=>'error','pesan'=>'Pilih anggota dan buku yang valid.'];header('Location: tambah.php');exit;}
require __DIR__.'/../includes/koneksi.php';
try{
 $pdo->beginTransaction();
 $stmt=$pdo->prepare('SELECT stok FROM buku WHERE id=:id FOR UPDATE');$stmt->execute(['id'=>$bukuId]);$buku=$stmt->fetch(PDO::FETCH_ASSOC);
 if(!$buku||(int)$buku['stok']<1)throw new RuntimeException('Buku tidak tersedia atau stok habis.');
 $cek=$pdo->prepare('SELECT id FROM anggota WHERE id=:id');$cek->execute(['id'=>$anggotaId]);if(!$cek->fetch())throw new RuntimeException('Anggota tidak ditemukan.');
 $ins=$pdo->prepare("INSERT INTO peminjaman(anggota_id,buku_id,tanggal_pinjam,status) VALUES(:anggota,:buku,CURRENT_DATE,'dipinjam')");$ins->execute(['anggota'=>$anggotaId,'buku'=>$bukuId]);
 $upd=$pdo->prepare('UPDATE buku SET stok=stok-1 WHERE id=:id AND stok>0');$upd->execute(['id'=>$bukuId]);if($upd->rowCount()!==1)throw new RuntimeException('Stok buku berubah. Silakan coba lagi.');
 $pdo->commit();$_SESSION['flash']=['type'=>'success','pesan'=>'Peminjaman berhasil disimpan.'];
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();$_SESSION['flash']=['type'=>'error','pesan'=>$e instanceof RuntimeException?$e->getMessage():'Peminjaman gagal diproses.'];}
header('Location: tambah.php');exit;
