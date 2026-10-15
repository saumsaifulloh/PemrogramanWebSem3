<?php
$page_title = "Register";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
<h2>Register Petugas</h2>
<?php if ($flash): ?><p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p><?php endif; ?>
<form action="proses_register.php" method="post">
        <?php echo csrf_field(); ?>
<p><label for="nama">Nama</label><input type="text" id="nama" name="nama" required></p>
<p><label for="username">Username</label><input type="text" id="username" name="username" required></p>
<p><label for="password">Password</label><input type="password" id="password" name="password" required minlength="6"></p>
<p><button type="submit">Daftar</button></p>
</form><p>Sudah punya akun? <a href="login.php">Login</a></p>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
