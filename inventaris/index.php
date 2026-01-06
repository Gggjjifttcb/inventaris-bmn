<?php
include "../config/koneksi.php";
$result = mysqli_query($conn, "SELECT * FROM inventaris");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Inventaris BMN</title>
    <link rel="stylesheet" href="../assets/css/inventaris.css">
</head>
<body>

<div class="header">
    <h2>Data Inventaris BMN</h2>
    <a href="tambah.php" class="btn">+ Tambah Data</a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Rak</th>
                <th>Baris</th>
                <th>Box</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['kode'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['rak'] ?></td>
                <td><?= $row['baris'] ?></td>
                <td><?= $row['box'] ?></td>
                <td class="action">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Yakin hapus data?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
