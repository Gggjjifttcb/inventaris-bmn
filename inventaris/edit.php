<?php
include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventaris WHERE id=$id"));
$ruang_id = $data['ruang_id'];
$ruangData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ruang WHERE id=$ruang_id"));

if(isset($_POST['update'])){
    $kode  = $_POST['kode'];
    $nama  = $_POST['nama'];
    $rak   = $_POST['rak'];
    $baris = $_POST['baris'];
    $box   = $_POST['box'];

    $image = $data['image']; // default tetap gambar lama
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];
        if(in_array(strtolower($ext), $allowed)){
            $image = time().'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$image);
            // hapus gambar lama
            if(file_exists('../uploads/'.$data['image'])){
                unlink('../uploads/'.$data['image']);
            }
        }
    }

    mysqli_query($conn, "UPDATE inventaris SET
        kode='$kode',
        tahun='$_POST[tahun]',
        nama='$nama',
        rak='$rak',
        box='$box',
        baris='$baris',
        image='$image'
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

    <form method="post" enctype="multipart/form-data">
        <label>Kode Klasifikasi</label>
        <input type="text" name="kode" value="<?= $data['kode'] ?>" required>

        <label>Tahun</label>
        <input type="text" name="tahun" value="<?= $data['tahun'] ?>" required>

        <label>Nama Arsip</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
    
        <label>Rak</label>
        <input type="text" name="rak" value="<?= $data['rak'] ?>" required>

        <label>Box</label>
        <input type="text" name="box" value="<?= $data['box'] ?>" required>

        <label>No. Berkas</label>
        <input type="text" name="baris" value="<?= $data['baris'] ?>" required>

        <label>Gambar (jpg/png/gif)</label>
        <?php if(!empty($data['image']) && file_exists('../uploads/'.$data['image'])): ?>
            <img src="../uploads/<?= $data['image'] ?>" width="50"><br>
        <?php endif; ?>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="update">Update Data</button>
    </form>
</div>
</body>
</html>
