<?php

include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil ruang_id sebelum hapus (untuk redirect)
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventaris WHERE id=$id"));
$ruang_id = $data['ruang_id'];

// Hapus data
mysqli_query($conn, "DELETE FROM inventaris WHERE id=$id");

// Redirect kembali ke inventaris ruang
header("Location: index.php?ruang_id=$ruang_id");
exit;
