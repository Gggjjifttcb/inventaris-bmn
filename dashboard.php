<?php
include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

// Data ruang
$qRuang = mysqli_query($conn, "SELECT * FROM ruang ORDER BY nama_ruang ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Data Arsip Inactive</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="navbar">
    <h1>Data Arsip Inactive</h1>
    <div>
        <a href="auth/logout.php" class="btn btn-logout">Logout</a>
        <a href="ruang/index.php" class="btn btn-ruang">Tahun</a>
    </div>
</div>

<div class="container">
<h2 style="margin-top:40px;">Pencarian Arsip Inactive</h2>
    <div class="form-box">
        <form method="get" action="inventaris/index.php" style="display:flex; gap:10px; flex-wrap: wrap;">
            <input type="text" name="nama" placeholder="Nama Arsip" style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;flex:1;">
            
            <select name="tahun" style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;">
                <option value="">-- Pilih Tahun --</option>
                <?php
                $qTahun = mysqli_query($conn, "SELECT DISTINCT tahun FROM inventaris ORDER BY tahun ASC");
                while($t = mysqli_fetch_assoc($qTahun)){
                    echo '<option value="'.$t['tahun'].'">'.$t['tahun'].'</option>';
                }
                ?>
            </select>
            
            <input type="text" name="rak" placeholder="Rak" style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;width:80px;">
            <input type="text" name="box" placeholder="Box" style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;width:80px;">
            
            <button type="submit" class="btn">Cari</button>
            
        </form>
    </div>
    <br>
    <h2>Data Tahun</h2>
    <div class="cards">
        <?php if (mysqli_num_rows($qRuang) > 0): ?>
            <?php while($r = mysqli_fetch_assoc($qRuang)): ?>
                <div class="card ruang-card">
                    <h3><?= $r['nama_ruang'] ?></h3>
                    <p><?= $r['keterangan'] ?></p>
                    <a href="inventaris/index.php?ruang_id=<?= $r['id'] ?>" class="btn">Lihat </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada data.</p>
        <?php endif; ?>
    </div>


</div>

<div class="footer">
    © <?= date('Y') ?> Sistem Inventaris Arsip Inactive
</div>

</body>
</html>
