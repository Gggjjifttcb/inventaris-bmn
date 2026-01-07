<?php
include "../config/koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM ruang ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Tahun</title>
    <link rel="stylesheet" href="../assets/css/ruang.css">
</head>
<body>

<div class="header">
    <a href="../dashboard.php" class="btn-back">← Dashboard</a>
    <h2>Data Tahun</h2>
    <a href="tambah.php" class="btn">+ Tambah </a>
</div>

<table>
    <tr>
        <th>No</th>
        <th>Tahun</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($r = mysqli_fetch_assoc($data)){ ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $r['nama_ruang'] ?></td>
        <td><?= $r['keterangan'] ?></td>
        <td>
                    
                <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-edit">Edit</a>
        <a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-delete"
        onclick="return confirm('Hapus ruang ini?')">Hapus</a>

        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
