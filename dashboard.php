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
    <style>
        /* ===== INFO SECTION ===== */
.info-section {
    margin-top: 60px;
    padding: 30px;
}

.info-card {
    display: flex;
    align-items: center;
    gap: 25px;
    background: #ffffff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    max-width: 1000px;
    margin: auto;
}

.info-card img {
    width: 120px;
    height: auto;
}

.info-text h3 {
    margin: 0 0 10px;
    font-size: 20px;
    color: #1f2937;
}

.info-text p {
    margin: 0 0 12px;
    color: #4b5563;
    line-height: 1.6;
}

.badge {
    display: inline-block;
    padding: 6px 12px;
    background: #e0f2fe;
    color: #0369a1;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
}
    </style>
</head>
<body>

<div class="navbar">
    <h1>Data Arsip Inaktif</h1>
    <div>
        <a href="inventaris/tambah.php" class="btn btn-ruang">+ Tambah Data</a>
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

            <input type="text"
                   name="rak"
                   placeholder="Rak"
                   style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;width:80px;">

            <input type="text"
                   name="box"
                   placeholder="Box"
                   style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;width:80px;">
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

            <button type="submit" class="btn">Cari</button>
        </form>
    </div>
    <div class="info-section">
    <div class="info-card">
        <img src="assets/img/arsip nasional.png" alt="Arsip Nasional RI">
        <div class="info-text">
            <h3>Arsip Nasional Republik Indonesia (ANRI)</h3>
            <p>
                Arsip Inaktif merupakan arsip yang frekuensi penggunaannya telah menurun,
                namun masih memiliki nilai guna administrasi, hukum, dan historis
                sesuai ketentuan kearsipan nasional.
            </p>
            <span class="badge">Sesuai UU No. 43 Tahun 2009</span>
        </div>
    </div>
</div>

</div>

</body>
</html>
