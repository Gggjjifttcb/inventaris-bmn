<?php
include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    mysqli_query($conn, "INSERT INTO inventaris VALUES (
        NULL,
        '$_POST[kode]',
        '$_POST[nama]',
        '$_POST[rak]',
        '$_POST[baris]',
        '$_POST[box]'
    )");
    header("Location: index.php");
}
?>

<form method="post">
    <input name="kode" placeholder="Kode BMN">
    <input name="nama" placeholder="Nama Barang">
    <input name="rak" placeholder="Rak">
    <input name="baris" placeholder="Baris/Deret">
    <input name="box" placeholder="Box">
    <button name="simpan">Simpan</button>
</form>
