<?php
include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

/* ================= CARD DINAMIS ================= */

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

/* ================= FITUR SEARCH ================= */

$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ($keyword != '') {
    $data = mysqli_query($conn, "
        SELECT * FROM inventaris 
        WHERE kode  LIKE '%$keyword%'
           OR nama  LIKE '%$keyword%'
           OR rak   LIKE '%$keyword%'
           OR baris LIKE '%$keyword%'
           OR box   LIKE '%$keyword%'
        ORDER BY id DESC
    ");
} else {
    $data = mysqli_query($conn, "SELECT * FROM inventaris ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Inventaris BMN</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<div class="navbar">
    <h1>Inventaris BMN</h1>
    <div>
        <a href="inventaris/index.php">Data Inventaris</a>
        <a href="auth/logout.php">Logout</a>
    </div>
</div>

<!-- ================= KONTEN ================= -->
<div class="container">

    <!-- CARD -->
    <div class="cards">
        <div class="card">
            <h3>Total Barang</h3>
            <p><?= $totalBarang ?></p>
        </div>
        <div class="card">
            <h3>Total Rak</h3>
            <p><?= $totalRak ?></p>
        </div>
        <div class="card">
            <h3>Total Baris</h3>
            <p><?= $totalBaris ?></p>
        </div>
        <div class="card">
            <h3>Total Box</h3>
            <p><?= $totalBox ?></p>
        </div>
    </div>

    <!-- ================= TABEL ================= -->
    <div class="table-wrapper">
        <div class="table-header">
            <h2>Data Inventaris BMN</h2>

            <!-- FORM SEARCH -->
            <form method="get" style="display:flex; gap:10px;">
                <input type="text"
                       name="search"
                       placeholder="Cari kode, nama, rak, baris, box..."
                       value="<?= htmlspecialchars($keyword) ?>"
                       style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;">
                <button type="submit" class="btn">Cari</button>
                <a href="dashboard.php" class="btn" style="background:#6c757d;">Reset</a>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Rak</th>
                    <th>Baris</th>
                    <th>Box</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($data) > 0) {
                while ($row = mysqli_fetch_assoc($data)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['kode'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['rak'] ?></td>
                    <td><?= $row['baris'] ?></td>
                    <td><?= $row['box'] ?></td>
                    <td class="action">
                        <a href="inventaris/edit.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="inventaris/hapus.php?id=<?= $row['id'] ?>"
                           onclick="return confirm('Yakin hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Data tidak ditemukan</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<!-- ================= FOOTER ================= -->
<div class="footer">
    © <?= date('Y') ?> Sistem Inventaris BMN
</div>

</body>
</html>
