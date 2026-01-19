<?php

include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* ===============================
   KUNCI RUANG ID (WAJIB 10)
================================ */
$ruang_id = 10;

/* ambil info ruang (opsional, buat judul) */
$ruangData = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM ruang WHERE id = $ruang_id")
);

if (isset($_POST['submit'])) {

    $kode  = mysqli_real_escape_string($conn, $_POST['kode']);
    $tahun = (int) $_POST['tahun'];
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $rak   = mysqli_real_escape_string($conn, $_POST['rak']);
    $box   = mysqli_real_escape_string($conn, $_POST['box']);
    $baris = mysqli_real_escape_string($conn, $_POST['baris']);

    /* upload gambar */
    $image = NULL;
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array($ext, $allowed)) {
            $image = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image");
        }
    }

    /* INSERT — RUANG ID DIKUNCI KE 10 */
    $sql = "INSERT INTO inventaris
            (kode, tahun, nama, rak, box, baris, ruang_id, image)
            VALUES
            ('$kode', '$tahun', '$nama', '$rak', '$box', '$baris', '$ruang_id',
             ".($image ? "'$image'" : "NULL").")";

    mysqli_query($conn, $sql);

    /* kembali ke ruang 10 */
    header("Location: index.php?ruang_id=10");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Inventaris Ruang <?= $ruangData['nama_ruang'] ?? '10' ?></title>
    <link rel="stylesheet" href="../assets/css/inventaris.css">
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <a href="index.php?ruang_id=10" class="btn-back">← Kembali</a>
        <h2>Tambah <?= $ruangData['nama_ruang'] ?? '10' ?></h2>
    </div>

    <form method="post" enctype="multipart/form-data">

        <label>Kode Klasifikasi</label>
        <input type="text" name="kode" required>

        <label>Tahun</label>
        <input type="number" name="tahun" min="1900" max="2100" required>

        <label>Nama Arsip</label>
        <input type="text" name="nama" required>

        <label>Rak</label>
        <input type="text" name="rak" required>

        <label>Box</label>
        <input type="text" name="box" required>

        <label>No. Berkas</label>
        <input type="text" name="baris" required>

        <label>Gambar (jpg/png/gif)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="submit">Simpan Data</button>

    </form>
</div>

</body>
</html>
