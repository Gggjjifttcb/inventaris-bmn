<?php

include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Data Arsip Inaktif</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="navbar">
    <h1>Data Arsip Inaktif</h1>
    <div>
        <a href="inventaris/tambah-ruang-10.php" class="btn btn-ruang">+ Tambah Data</a>
        <a href="inventaris/index.php?ruang_id=10" class="btn btn-ruang">Data Arsip</a>
        <a href="auth/logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>

<div class="container">
    <h2 style="margin-top:40px;">Pencarian Arsip Inaktif</h2>

    <div class="form-box">
        <form method="get" action="inventaris/index.php"
              style="display:flex; gap:10px; flex-wrap: wrap;">

            <!-- PENTING: kunci ke ruang_id = 10 -->
            <input type="hidden" name="ruang_id" value="10">

            <input type="text"
                   name="nama"
                   placeholder="Nama Arsip"
                   style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;flex:1;">

            <select name="tahun"
                    style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;">
                <option value="">-- Pilih Tahun --</option>
                <?php
                $qTahun = mysqli_query($conn, "SELECT DISTINCT tahun FROM inventaris WHERE ruang_id=10 ORDER BY tahun ASC");
                while ($t = mysqli_fetch_assoc($qTahun)) {
                    echo '<option value="'.$t['tahun'].'">'.$t['tahun'].'</option>';
                }
                ?>
            </select>

            <input type="text"
                   name="rak"
                   placeholder="Rak"
                   style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;width:80px;">

            <input type="text"
                   name="box"
                   placeholder="Box"
                   style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;width:80px;">

            <button type="submit" class="btn">Cari</button>
        </form>
    </div>
</div>

</body>
</html>
