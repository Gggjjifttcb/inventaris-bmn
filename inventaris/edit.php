<?php
include "../config/koneksi.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM inventaris WHERE id=$id"));

if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE inventaris SET
        kode='$_POST[kode]',
        nama='$_POST[nama]',
        rak='$_POST[rak]',
        baris='$_POST[baris]',
        box='$_POST[box]'
        WHERE id=$id
    ");
    header("Location: index.php");
}
?>

<form method="post">
    <input name="kode" value="<?= $data['kode'] ?>">
    <input name="nama" value="<?= $data['nama'] ?>">
    <input name="rak" value="<?= $data['rak'] ?>">
    <input name="baris" value="<?= $data['baris'] ?>">
    <input name="box" value="<?= $data['box'] ?>">
    <button name="update">Update</button>
</form>
