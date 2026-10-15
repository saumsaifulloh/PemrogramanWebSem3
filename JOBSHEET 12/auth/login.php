<?php
$page_title = "Login";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
<h2>Login Petugas</h2>
<?php if ($flash): ?><p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p><?php endif; ?>
\1
        <?php echo csrf_field(); ?>
<p><label for="username">Username</label><input type="text" id="username" name="username" required></p>
<p><label for="password">Password</label><input type="password" id="password" name="password" required></p>
<p><button type="submit">Login</button></p>
</form><p>Belum punya akun? <a href="register.php">Register</a></p>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
