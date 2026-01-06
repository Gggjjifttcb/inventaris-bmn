<?php

include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil ruang_id dari URL
$ruang_id = isset($_GET['ruang_id']) ? intval($_GET['ruang_id']) : 0;

// Ambil nama ruang (untuk judul)
$ruangData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ruang WHERE id=$ruang_id"));

// Simpan data
if (isset($_POST['submit'])) {
    $kode  = $_POST['kode'];
    $nama  = $_POST['nama'];
    $rak   = $_POST['rak'];
    $baris = $_POST['baris'];
    $box   = $_POST['box'];

    mysqli_query($conn, "INSERT INTO inventaris (kode,nama,rak,baris,box,ruang_id) 
                         VALUES ('$kode','$nama','$rak','$baris','$box','$ruang_id')");
    header("Location: index.php?ruang_id=$ruang_id");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Inventaris Ruang <?= $ruangData['nama_ruang'] ?? '' ?></title>
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>
<div class="form-container">
    <div class="form-header">
        <a href="index.php?ruang_id=<?= $ruang_id ?>" class="btn-back">← Kembali</a>
        <h2>Tambah Inventaris Ruang <?= $ruangData['nama_ruang'] ?? '' ?></h2>
    </div>

    <form method="post">
        <label>Kode Barang</label>
        <input type="text" name="kode" required>

        <label>Nama Barang</label>
        <input type="text" name="nama" required>

        <label>Rak</label>
        <input type="text" name="rak" required>

        <label>Baris</label>
        <input type="text" name="baris" required>

        <label>Box</label>
        <input type="text" name="box" required>

        <button type="submit" name="submit">Tambah Data</button>
    </form>
</div>
</body>
</html>
