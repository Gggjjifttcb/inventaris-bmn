<?php
include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

/* ================= STATISTIK ================= */

// Total barang
$qBarang = mysqli_query($conn, "SELECT COUNT(*) AS total FROM inventaris");
$totalBarang = mysqli_fetch_assoc($qBarang)['total'];

// Total rak
$qRak = mysqli_query($conn, "SELECT COUNT(DISTINCT rak) AS total FROM inventaris");
$totalRak = mysqli_fetch_assoc($qRak)['total'];

// Total baris
$qBaris = mysqli_query($conn, "SELECT COUNT(DISTINCT baris) AS total FROM inventaris");
$totalBaris = mysqli_fetch_assoc($qBaris)['total'];

// Total box
$qBox = mysqli_query($conn, "SELECT COUNT(DISTINCT box) AS total FROM inventaris");
$totalBox = mysqli_fetch_assoc($qBox)['total'];

// Total ruang
$qTotalRuang = mysqli_query($conn, "SELECT COUNT(*) AS total FROM ruang");
$totalRuang = mysqli_fetch_assoc($qTotalRuang)['total'];

// Data ruang
$qRuang = mysqli_query($conn, "SELECT * FROM ruang ORDER BY nama_ruang ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Inventaris Arsip</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<div class="navbar">
    <h1>Inventaris Arsip</h1>
    <div>
       <a href="ruang/index.php" class="btn btn-ruang">Data Tahun</a>
<a href="auth/logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>

<!-- ================= KONTEN ================= -->
<div class="container">

    <!-- ================= PENJELASAN WEB ================= -->
    <div class="info-box">
        <h2>Sistem Inventaris Arsip</h2>
        <p>
            Sistem Inventaris Arsip merupakan aplikasi berbasis web yang digunakan
            untuk mencatat, mengelola, dan memantau Barang Milik Negara (BMN)
            berdasarkan lokasi ruang penyimpanan.
        </p>
        <p>
            Setiap barang dicatat secara detail meliputi kode barang, nama barang,
            posisi rak, baris, dan box sehingga memudahkan pencarian,
            pengawasan, serta pengelolaan inventaris secara tertib dan terstruktur.
        </p>
    </div>

    <!-- ================= CARD STATISTIK ================= -->
  
    <!-- ================= DATA RUANG ================= -->
    <h2 style="margin-top:40px;">Data Tahun</h2>

    <div class="cards">
        <?php if (mysqli_num_rows($qRuang) > 0) { ?>
            <?php while ($r = mysqli_fetch_assoc($qRuang)) { ?>
                <div class="card ruang-card">
                    <h3><?= $r['nama_ruang'] ?></h3>
                    <p><?= $r['keterangan'] ?></p>
                    <br>
                    <a href="inventaris/index.php?ruang_id=<?= $r['id'] ?>" class="btn">
                        Lihat Inventaris
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Belum ada data .</p>
        <?php } ?>
    </div>

</div>

<!-- ================= FOOTER ================= -->
<div class="footer">
    © <?= date('Y') ?> Sistem Inventaris Arsip
</div>

</body>
</html>
