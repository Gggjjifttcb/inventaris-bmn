<?php
include "../config/koneksi.php";
$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM ruang WHERE id='$id'")
);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_ruang'];
    $ket  = $_POST['keterangan'];

    mysqli_query($conn, "UPDATE ruang SET 
        nama_ruang='$nama',
        keterangan='$ket'
        WHERE id='$id'
    ");

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Ruang</title>
    <link rel="stylesheet" href="../assets/css/ruang.css">
</head>
<body>

<div class="header">
    <a href="index.php" class="btn-back">← Data Ruang</a>
    <h2>Edit Ruang</h2>
</div>

<form method="post" class="form-box">
    <label>Nama Ruang</label>
    <input type="text" name="nama_ruang" value="<?= $data['nama_ruang'] ?>" required>

    <label>Keterangan</label>
    <textarea name="keterangan"><?= $data['keterangan'] ?></textarea>

    <button name="update" class="btn">Update</button>
</form>

</body>
</html>
