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
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>

<div class="form-wrapper">
    <div class="header">
        <a href="index.php" class="btn-back">← Data Tahun</a>
        <h2>Tambah Tahun</h2>
    </div>

    <form method="post" class="form-box">
        <div>
            <label>Tahun</label>
            <input type="text" name="nama_ruang" required>
        </div>

        <div>
            <label>Keterangan</label>
            <input type="text" name="keterangan">
        </div>

        <button name="simpan" class="btn">Simpan</button>
    </form>
</div>

</body>

</html>
