<?php
include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventaris WHERE id=$id"));

// Hapus gambar
if(!empty($data['image']) && file_exists('../uploads/'.$data['image'])){
    unlink('../uploads/'.$data['image']);
}

mysqli_query($conn, "DELETE FROM inventaris WHERE id=$id");
header("Location: index.php?ruang_id=".$data['ruang_id']);
