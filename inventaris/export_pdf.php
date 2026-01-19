<?php
include "../config/koneksi.php";
require('fpdf/fpdf.php');

/* =========================
   KUNCI RUANG ARSIP INAKTIF
========================= */
$ruang_id = 10;

/* =========================
   AMBIL FILTER DARI URL
========================= */
$nama  = isset($_GET['nama']) ? mysqli_real_escape_string($conn, $_GET['nama']) : '';
$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($conn, $_GET['tahun']) : '';
$rak   = isset($_GET['rak']) ? mysqli_real_escape_string($conn, $_GET['rak']) : '';
$box   = isset($_GET['box']) ? mysqli_real_escape_string($conn, $_GET['box']) : '';

/* =========================
   QUERY SAMA DENGAN INDEX
========================= */
$query = "SELECT inv.*, r.nama_ruang
          FROM inventaris inv
          LEFT JOIN ruang r ON inv.ruang_id = r.id
          WHERE inv.ruang_id = 10";

if ($nama != '') {
    $query .= " AND inv.nama LIKE '%$nama%'";
}
if ($tahun != '') {
    $query .= " AND inv.tahun = '$tahun'";
}
if ($rak != '') {
    $query .= " AND inv.rak LIKE '%$rak%'";
}
if ($box != '') {
    $query .= " AND inv.box LIKE '%$box%'";
}

$query .= " ORDER BY inv.id DESC";

$data = mysqli_query($conn, $query);

/* =========================
   PDF SETUP
========================= */
$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'LAPORAN ARSIP INAKTIF',0,1,'C');

$pdf->Ln(3);
$pdf->SetFont('Arial','',10);

/* INFO FILTER */
$filterText = [];
if ($nama)  $filterText[] = "Nama: $nama";
if ($tahun) $filterText[] = "Tahun: $tahun";
if ($rak)   $filterText[] = "Rak: $rak";
if ($box)   $filterText[] = "Box: $box";

$pdf->Cell(0,7,'Filter: '.(count($filterText) ? implode(', ', $filterText) : 'Semua Data'),0,1);

$pdf->Ln(3);

/* =========================
   HEADER TABEL
========================= */
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,8,'No',1);
$pdf->Cell(35,8,'Kode',1);
$pdf->Cell(20,8,'Tahun',1);
$pdf->Cell(80,8,'Nama Arsip',1);
$pdf->Cell(20,8,'Rak',1);
$pdf->Cell(20,8,'Box',1);
$pdf->Cell(30,8,'No Berkas',1);
$pdf->Ln();

/* =========================
   ISI DATA
========================= */
$pdf->SetFont('Arial','',9);
$no = 1;

if (mysqli_num_rows($data) > 0) {
    while ($row = mysqli_fetch_assoc($data)) {
        $pdf->Cell(10,8,$no++,1);
        $pdf->Cell(35,8,$row['kode'],1);
        $pdf->Cell(20,8,$row['tahun'],1);
        $pdf->Cell(80,8,$row['nama'],1);
        $pdf->Cell(20,8,$row['rak'],1);
        $pdf->Cell(20,8,$row['box'],1);
        $pdf->Cell(30,8,$row['baris'],1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(215,8,'Data tidak ditemukan',1,1,'C');
}

/* =========================
   OUTPUT
========================= */
$pdf->Output('I','arsip_inaktif.pdf');
