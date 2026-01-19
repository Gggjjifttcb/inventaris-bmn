<?php
include "../config/koneksi.php";

$ruang_id = 10;

$nama  = isset($_GET['nama']) ? mysqli_real_escape_string($conn, $_GET['nama']) : '';
$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($conn, $_GET['tahun']) : '';
$rak   = isset($_GET['rak']) ? mysqli_real_escape_string($conn, $_GET['rak']) : '';
$box   = isset($_GET['box']) ? mysqli_real_escape_string($conn, $_GET['box']) : '';

$query = "SELECT * FROM inventaris WHERE ruang_id = 10";

if ($nama !== '')  $query .= " AND nama LIKE '%$nama%'";
if ($tahun !== '') $query .= " AND tahun = '$tahun'";
if ($rak !== '')   $query .= " AND rak LIKE '%$rak%'";
if ($box !== '')   $query .= " AND box LIKE '%$box%'";

$query .= " ORDER BY id DESC";

$data = mysqli_query($conn, $query);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=arsip_inaktif.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table style="border-collapse:collapse;">
    <tr>
        <th style="border:1px solid #000; padding:6px;">No</th>
        <th style="border:1px solid #000; padding:6px;">Kode</th>
        <th style="border:1px solid #000; padding:6px;">Tahun</th>
        <th style="border:1px solid #000; padding:6px;">Nama Arsip</th>
        <th style="border:1px solid #000; padding:6px;">Rak</th>
        <th style="border:1px solid #000; padding:6px;">Box</th>
        <th style="border:1px solid #000; padding:6px;">No. Berkas</th>
    </tr>

<?php
$no = 1;
while ($row = mysqli_fetch_assoc($data)) {
    echo "<tr>";
    echo "<td style='border:1px solid #000; padding:6px;'>".$no++."</td>";
    echo "<td style='border:1px solid #000; padding:6px;'>".$row['kode']."</td>";
    echo "<td style='border:1px solid #000; padding:6px;'>".$row['tahun']."</td>";
    echo "<td style='border:1px solid #000; padding:6px;'>".$row['nama']."</td>";
    echo "<td style='border:1px solid #000; padding:6px;'>".$row['rak']."</td>";
    echo "<td style='border:1px solid #000; padding:6px;'>".$row['box']."</td>";
    echo "<td style='border:1px solid #000; padding:6px;'>".$row['baris']."</td>";
    echo "</tr>";
}
?>
</table>
