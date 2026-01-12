<?php
include "../config/koneksi.php";

$ruang_id = isset($_GET['ruang_id']) ? intval($_GET['ruang_id']) : 0;

// Ambil data ruang
$ruangData = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM ruang WHERE id = $ruang_id")
);

// Ambil filter
$nama  = isset($_GET['nama']) ? mysqli_real_escape_string($conn, $_GET['nama']) : '';
$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($conn, $_GET['tahun']) : '';
$rak   = isset($_GET['rak']) ? mysqli_real_escape_string($conn, $_GET['rak']) : '';
$box   = isset($_GET['box']) ? mysqli_real_escape_string($conn, $_GET['box']) : '';

// Query inventaris
$query = "SELECT inv.*, r.nama_ruang 
          FROM inventaris inv
          LEFT JOIN ruang r ON inv.ruang_id = r.id
          WHERE 1=1";

if ($ruang_id) $query .= " AND inv.ruang_id = $ruang_id";
if ($nama != '')  $query .= " AND inv.nama LIKE '%$nama%'";
if ($tahun != '') $query .= " AND inv.tahun = '$tahun'";
if ($rak != '')   $query .= " AND inv.rak LIKE '%$rak%'";
if ($box != '')   $query .= " AND inv.box LIKE '%$box%'";

$query .= " ORDER BY inv.id DESC";

$data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventaris <?= $ruangData['nama_ruang'] ?? '' ?></title>
    <link rel="stylesheet" href="../assets/css/ruang.css">
</head>
<body>

<div class="header">
    <div class="header-left">
        <a href="../dashboard.php" class="btn-back">← Dashboard</a>
        <h2>Data Arsip Inactive <?= $ruangData['nama_ruang'] ?? '' ?></h2>
    </div>
    
</div>

<div class="table-wrapper">

    <form method="get" style="display:flex; gap:10px; margin-bottom:15px;">
        <input type="hidden" name="ruang_id" value="<?= $ruang_id ?>">

        <input type="text" name="nama" placeholder="Nama Arsip"
               value="<?= htmlspecialchars($nama) ?>" style="flex:1">

        <input type="text" name="rak" placeholder="Rak"
               value="<?= htmlspecialchars($rak) ?>" style="width:80px">

        <input type="text" name="box" placeholder="Box"
               value="<?= htmlspecialchars($box) ?>" style="width:80px">

        <select name="tahun" style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;">
                <option value="">-- Pilih Tahun --</option>
                <?php
                $qTahun = mysqli_query($conn, "SELECT DISTINCT tahun FROM inventaris ORDER BY tahun ASC");
                while($t = mysqli_fetch_assoc($qTahun)){
                    echo '<option value="'.$t['tahun'].'">'.$t['tahun'].'</option>';
                }
                ?>
            </select>
        <button type="submit" class="btn">Cari</button>
        <a href="index.php?ruang_id=<?= $ruang_id ?>" class="btn-back">Reset</a>


    </form>

    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th style="width:130px">Kode Klasifikasi</th>
                <th style="width:80px">Tahun</th>
                <th style="width:250px">Nama Arsip</th>
                <th style="width:70px">Rak</th>
                <th style="width:70px">Box</th>
                <th style="width:100px">No.Berkas</th>
                <th style="width:90px">Gambar</th>
                <th style="width:110px">Aksi</th>
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
                <td><?= htmlspecialchars($row['kode']) ?></td>
                <td><?= htmlspecialchars($row['tahun']) ?></td>

                <!-- PENTING: class td-nama -->
                <td class="td-nama">
                    <?= htmlspecialchars($row['nama']) ?>
                </td>

                <td><?= htmlspecialchars($row['rak']) ?></td>
                <td><?= htmlspecialchars($row['box']) ?></td>
                <td><?= htmlspecialchars($row['baris']) ?></td>

                <td>
                    <?php if (!empty($row['image']) && file_exists('../uploads/'.$row['image'])): ?>
                        <img src="../uploads/<?= $row['image'] ?>" width="50">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>

                <td class="action">
                    <a href="preview.php?id=<?= $row['id'] ?>" class="aksi-btn preview">Preview</a>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="aksi-btn edit">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>"
                       class="aksi-btn hapus"
                       onclick="return confirm('Yakin hapus data?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="9" style="text-align:center;">Data tidak ditemukan</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
