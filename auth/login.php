<?php
include "../config/koneksi.php";

// Jika sudah login
if (isset($_SESSION['login'])) {
    header("Location: ../dashboard.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Inventaris BMN</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="login-card">
    <div class="login-title">Data Arsi</div>

    <?php if (isset($error)) { ?>
        <div class="alert"><?= $error ?></div>
    <?php } ?>

    <form method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button name="login" class="btn-login">Login</button>
    </form>

    <div class="footer-text">
        © <?= date('Y') ?> Inventaris BMN
    </div>
</div>

</body>
</html>
