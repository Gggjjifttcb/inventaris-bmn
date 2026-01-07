<?php
include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_ruang'];
    $ket  = $_POST['keterangan'];

    mysqli_query($conn, "INSERT INTO ruang VALUES (NULL,'$nama','$ket')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah</title>
    <link rel="stylesheet" href="../assets/css/ruang.css">
</head>
<body>

<div class="header">
    <a href="index.php" class="btn-back">← Data Tahun</a>
    <h2>Tambah </h2>
</div>

<form method="post" class="form-box">
    <label>Tahun</label>
    <input type="text" name="nama_ruang" required>

    <label>Keterangan</label>
    <textarea name="keterangan"></textarea>

    <button name="simpan" class="btn">Simpan</button>
</form>

</body>
</html>
