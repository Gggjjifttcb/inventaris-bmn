<?php
// Mulai session
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['login'])) {
    // Jika sudah login, langsung ke dashboard
    header("Location: dashboard.php");
} else {
    // Jika belum login, arahkan ke login.php
    header("Location: auth/login.php");
}
exit;
?>
