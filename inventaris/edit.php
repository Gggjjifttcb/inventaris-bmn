<?php

include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil data inventaris
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventaris WHERE id=$id"));
$ruang_id = $data['ruang_id'];

// Ambil nama ruang
$ruangData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ruang WHERE id=$ruang_id"));

// Update data
if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE inventaris SET
        kode  = '$_POST[kode]',
        nama  = '$_POST[nama]',
        rak   = '$_POST[rak]',
        baris = '$_POST[baris]',
        box   = '$_POST[box]'
        WHERE id=$id
    ");
    header("Location: index.php?ruang_id=$ruang_id");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Inventaris Ruang <?= $ruangData['nama_ruang'] ?? '' ?></title>
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>
<div class="form-container">
    <div class="form-header">
        <a href="index.php?ruang_id=<?= $ruang_id ?>" class="btn-back">← Kembali</a>
        <h2>Edit Inventaris Ruang <?= $ruangData['nama_ruang'] ?? '' ?></h2>
    </div>

    <form method="post">
        <label>Kode Barang</label>
        <input type="text" name="kode" value="<?= $data['kode'] ?>" required>

        <label>Nama Barang</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required>

        <label>Rak</label>
        <input type="text" name="rak" value="<?= $data['rak'] ?>" required>

        <label>Baris</label>
        <input type="text" name="baris" value="<?= $data['baris'] ?>" required>

        <label>Box</label>
        <input type="text" name="box" value="<?= $data['box'] ?>" required>

        <button type="submit" name="update">Update Data</button>
    </form>
</div>
</body>
</html>
