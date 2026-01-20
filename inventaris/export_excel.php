<?php
include "../config/koneksi.php";

$ruang_id = 10;

$nama  = $_GET['nama']  ?? '';
$tahun = $_GET['tahun'] ?? '';
$rak   = $_GET['rak']   ?? '';
$box   = $_GET['box']   ?? '';

$query = "SELECT * FROM inventaris WHERE ruang_id = $ruang_id";

if ($nama  !== '') $query .= " AND nama  LIKE '%$nama%'";
if ($tahun !== '') $query .= " AND tahun = '$tahun'";
if ($rak   !== '') $query .= " AND rak   LIKE '%$rak%'";
if ($box   !== '') $query .= " AND box   LIKE '%$box%'";

$data = mysqli_query($conn, $query);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=arsip_inaktif.xls");
header("Pragma: no-cache");
header("Expires: 0");

$base_url = "http://localhost/inventaris-bmn/uploads/";
?>

<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <tr style="background:#e9ecef; font-weight:bold; text-align:center; vertical-align:middle;">
        <th width="40">No</th>
        <th width="200">Kode Klasifikasi</th>
        <th width="120">Tahun</th>
        <th width="450">Nama Arsip</th>
        <th width="129">Rak</th>
        <th width="120">Box</th>
        <th width="120">No. Berkas</th>
        <th width="150">Gambar</th>
    </tr>

<?php
$no = 1;
while ($row = mysqli_fetch_assoc($data)) {
    echo "<tr height='110' style='text-align:center; vertical-align:middle;'>";
    echo "<td>{$no}</td>";
    echo "<td>{$row['kode']}</td>";
    echo "<td>{$row['tahun']}</td>";
    echo "<td>{$row['nama']}</td>";
    echo "<td>{$row['rak']}</td>";
    echo "<td>{$row['box']}</td>";
    echo "<td>{$row['baris']}</td>";

    if (!empty($row['image']) && file_exists("../uploads/".$row['image'])) {
        $img = $base_url.$row['image'];
        echo "
        <td>
            <div style='width:100px; height:100px; overflow:hidden; display:flex; align-items:center; justify-content:center;'>
                <img src='$img' width='100' height='72'>
            </div>
        </td>";
    } else {
        echo "<td>-</td>";
    }

    echo "</tr>";
    $no++;
}
?>
</table>
