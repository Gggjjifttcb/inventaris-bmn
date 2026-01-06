<?php
include "../config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil ruang_id dari URL
$ruang_id = isset($_GET['ruang_id']) ? intval($_GET['ruang_id']) : 0;

// Ambil nama ruang
$ruangData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ruang WHERE id=$ruang_id"));

// Ambil search keyword
$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query inventaris
if ($keyword != '') {
    $query = "SELECT * FROM inventaris 
              WHERE ruang_id = $ruang_id
                AND (kode LIKE '%$keyword%' 
                     OR nama LIKE '%$keyword%'
                     OR rak LIKE '%$keyword%'
                     OR baris LIKE '%$keyword%'
                     OR box LIKE '%$keyword%')
              ORDER BY id DESC";
} else {
    $query = "SELECT * FROM inventaris 
              WHERE ruang_id = $ruang_id
              ORDER BY id DESC";
}

$data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventaris Ruang <?= $ruangData['nama_ruang'] ?? '' ?></title>
    <link rel="stylesheet" href="../assets/css/ruang.css">
</head>
<body>

<div class="header">
    <div class="header-left">
        <a href="../dashboard.php" class="btn-back">← Dashboard</a>
        <h2>Inventaris BMN Ruang <?= $ruangData['nama_ruang'] ?? '' ?></h2>
    </div>
    <a href="tambah.php?ruang_id=<?= $ruang_id ?>" class="btn">+ Tambah Data</a>
</div>

<div class="table-wrapper">
    <!-- FORM SEARCH -->
    <form method="get" style="display:flex; gap:10px; margin-bottom:15px;">
        <input type="hidden" name="ruang_id" value="<?= $ruang_id ?>">
        <input type="text"
               name="search"
               placeholder="Cari kode, nama, rak, baris, box..."
               value="<?= htmlspecialchars($keyword) ?>"
               style="padding:8px 12px;border-radius:6px;border:1px solid #ccc; flex:1;">
        <button type="submit" class="btn">Cari</button>
        <a href="index.php?ruang_id=<?= $ruang_id ?>" class="btn btn-back" style="background:#6c757d;">Reset</a>
        <a href="export_pdf.php?ruang_id=<?= $ruang_id ?>" class="btn" style="background:#28a745;">📄 Export PDF</a>
    </form>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Rak</th>
                <th>Baris</th>
                <th>Box</th>
                <th>Gambar</th>
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
                <td>
                    <?php if(!empty($row['image']) && file_exists('../uploads/'.$row['image'])): ?>
                        <img src="../uploads/<?= $row['image'] ?>" width="50">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="action">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus data?')">Hapus</a>
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="8" style="text-align:center;">Data tidak ditemukan</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
