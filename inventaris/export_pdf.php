<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";
require('fpdf/fpdf.php');

/* ================= AMBIL PARAMETER ================= */
$ruang_id = isset($_GET['ruang_id']) ? intval($_GET['ruang_id']) : 0;

$nama  = isset($_GET['nama'])  ? mysqli_real_escape_string($conn, $_GET['nama'])  : '';
$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($conn, $_GET['tahun']) : '';
$rak   = isset($_GET['rak'])   ? mysqli_real_escape_string($conn, $_GET['rak'])   : '';
$box   = isset($_GET['box'])   ? mysqli_real_escape_string($conn, $_GET['box'])   : '';

/* ================= DATA RUANG ================= */
$ruangData = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM ruang WHERE id = $ruang_id")
);

/* ================= QUERY INVENTARIS ================= */
$query = "SELECT * FROM inventaris WHERE ruang_id = $ruang_id";

if ($nama != '')  $query .= " AND nama LIKE '%$nama%'";
if ($tahun != '') $query .= " AND tahun = '$tahun'";
if ($rak != '')   $query .= " AND rak LIKE '%$rak%'";
if ($box != '')   $query .= " AND box LIKE '%$box%'";

$query .= " ORDER BY id ASC";
$data = mysqli_query($conn, $query);

/* ================= CLASS PDF ================= */
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../assets/logo.png',10,10,25);
        $this->Image('../assets/logo1.png',175,10,25);

        $this->SetFont('Arial','B',12);
        $this->Cell(0,7,'KEMENTERIAN PARIWISATA REPUBLIK INDONESIA',0,1,'C');

        $this->SetFont('Arial','B',16);
        $this->Cell(0,7,'POLITEKNIK PARIWISATA LOMBOK',0,1,'C');

        $this->SetFont('Arial','',10);
        $this->MultiCell(0,5,
            "Jalan Raden Puguh No. 1, Puyung, Jonggat\n".
            "Praya, Lombok Tengah, NTB 83561\n".
            "Telepon (+62-0370) 6158029",
            0,'C'
        );

        $this->Ln(3);
        $this->Line(10,45,200,45);
        $this->Line(10,46,200,46);
        $this->Ln(8);
    }

    function HeaderTable($kolom)
    {
        $this->SetFont('Arial','B',10);
        foreach ($kolom as $judul => $w) {
            $this->Cell($w, 8, $judul, 1, 0, 'C');
        }
        $this->Ln();
    }

    function Row($data, $widths, $aligns, $imagePath = null, $kolomHeader = null)
    {
        $this->SetFont('Arial','',10);

        $lineHeight = 6;
        $nb = 0;

        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($widths[$i], $data[$i]));
        }

        $rowHeight = max($lineHeight * $nb, 25);

        if ($this->GetY() + $rowHeight > $this->PageBreakTrigger) {
            $this->AddPage();
            $this->HeaderTable($kolomHeader);
        }

        for ($i = 0; $i < count($data); $i++) {
            $x = $this->GetX();
            $y = $this->GetY();
            $w = $widths[$i];

            $this->Rect($x, $y, $w, $rowHeight);

            if ($i == count($data)-1 && $imagePath && file_exists($imagePath)) {
                $this->Image($imagePath, $x+2, $y+2, $w-4, $rowHeight-4);
            } else {
                $this->MultiCell($w, $lineHeight, $data[$i], 0, $aligns[$i]);
            }

            $this->SetXY($x + $w, $y);
        }

        $this->Ln($rowHeight);
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        $wmax = ($w - 2*$this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        $sep = -1; $i = 0; $l = 0; $nl = 1;

        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $l = 0; $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                $i = ($sep == -1) ? $i+1 : $sep+1;
                $sep = -1; $l = 0; $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}

/* ================= CETAK PDF ================= */
$pdf = new PDF();
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Inventaris Ruang '.$ruangData['nama_ruang'],0,1,'C');
$pdf->Ln(4);

$kolom = [
    'No' => 10,
    'Kode' => 25,
    'Tahun' => 15,
    'Nama Arsip' => 45,
    'Rak' => 15,
    'Box' => 15,
    'No. Berkas' => 25,
    'Gambar' => 40
];

$widths = array_values($kolom);
$aligns = ['C','C','C','L','C','C','C','C'];

$pdf->HeaderTable($kolom);

$no = 1;
while ($row = mysqli_fetch_assoc($data)) {

    $imagePath = (!empty($row['image']) && file_exists('../uploads/'.$row['image']))
        ? '../uploads/'.$row['image']
        : null;

    $pdf->Row([
        $no++,
        $row['kode'],
        $row['tahun'],
        $row['nama'],
        $row['rak'],
        $row['box'],
        $row['baris'],
        ''
    ], $widths, $aligns, $imagePath, $kolom);
}

ob_end_clean();
$pdf->Output('D', 'Inventaris_'.$ruangData['nama_ruang'].'.pdf');
exit;
