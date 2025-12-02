<?php
// Logika Login Sederhana
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Contoh validasi: email 'admin@mail.com' dan password '12345'
    if ($email === 'admin@mail.com' && $password === '12345') {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_email'] = $email;

        // Redirect dilakukan oleh index.php (Router) setelah berhasil login
    } else {
        $error = "Email atau password salah.";
    }
}
?>

<h2>Halaman Login</h2>
<p>Masukkan email dan password.</p>

<?php if (isset($error)): ?>
    <div style="color: red; margin-bottom: 10px;"><?= $error ?></div>
<?php endif; ?>

<form method="POST" action="index.php?page=auth/login">
    <div class="input">
        <label>Email</label>
        <input type="email" name="email" required value="admin@mail.com" />
    </div>
    <div class="input">
        <label>Password</label>
        <input type="password" name="password" required value="12345" />
    </div>
    <div class="submit" style="margin-top: 20px;">
        <input type="submit" name="submit" value="Login" />
    </div>
</form>