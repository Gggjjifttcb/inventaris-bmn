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
    <title>Edit Tahun</title>
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>

<div class="form-wrapper">
    <div class="header">
        <a href="index.php" class="btn-back">← Data Tahun</a>
        <h2>Edit Tahun</h2>
    </div>

    <form method="post" class="form-box">
        <div>
            <label>Tahun</label>
            <input type="text" name="nama_ruang" value="<?= $data['nama_ruang'] ?>" required>
        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="keterangan"><?= $data['keterangan'] ?></textarea>
        </div>

        <button name="update" class="btn">Update</button>
    </form>
</div>

</body>
</html>
