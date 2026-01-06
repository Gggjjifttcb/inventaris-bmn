<?php
include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$ruang_id = isset($_GET['ruang_id']) ? intval($_GET['ruang_id']) : 0;
$ruangData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ruang WHERE id=$ruang_id"));

if(isset($_POST['submit'])){
    $kode  = $_POST['kode'];
    $nama  = $_POST['nama'];
    $rak   = $_POST['rak'];
    $baris = $_POST['baris'];
    $box   = $_POST['box'];

    // Upload gambar
    $image = '';
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];
        if(in_array(strtolower($ext), $allowed)){
            $image = time().'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$image);
        }
    }

    mysqli_query($conn, "INSERT INTO inventaris (kode,nama,rak,baris,box,ruang_id,image) 
                         VALUES ('$kode','$nama','$rak','$baris','$box','$ruang_id','$image')");
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
        <h2>Inventaris <?= $ruangData['nama_ruang'] ?? '' ?></h2>
    </div>

    <form method="post" enctype="multipart/form-data">
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

        <label>Gambar (jpg/png/gif)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="submit">Tambah Data</button>
    </form>
</div>
</body>
</html>
