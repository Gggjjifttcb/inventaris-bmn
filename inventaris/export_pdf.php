<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

include "../config/koneksi.php";
require('fpdf/fpdf.php');

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$ruang_id = isset($_GET['ruang_id']) ? intval($_GET['ruang_id']) : 0;
$ruangData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ruang WHERE id=$ruang_id"));
$data = mysqli_query($conn, "SELECT * FROM inventaris WHERE ruang_id=$ruang_id ORDER BY id ASC");

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
            "Telp (0370) 6158029 | Fax (0370) 6158030",
            0,'C'
        );

        $this->Ln(0);
        $this->Cell(0,5,'Laman: www.ppl.ac.id | Posel: info@ppl.ac.id',0,1,'C');

        $this->Ln(3);
        $this->SetLineWidth(0.8);
        $this->Line(10,45,200,45);
        $this->SetLineWidth(0.2);
        $this->Line(10,46,200,46);
        $this->Ln(10);
    }

    /* ========= ROW DINAMIS (TINGGI IKUT GAMBAR) ========= */
    function Row($data, $widths, $aligns, $imagePath = null)
    {
        $lineHeight = 7;
        $minImageHeight = 30; // 🔥 tinggi gambar target (mm)

        // Hitung tinggi dari teks
        $nb = 0;
        for ($i=0; $i<count($data); $i++) {
            $nb = max($nb, $this->NbLines($widths[$i], $data[$i]));
        }
        $textHeight = $lineHeight * $nb;

        // Tinggi baris = teks ATAU gambar (mana yang lebih besar)
        $rowHeight = max($textHeight, $minImageHeight);

        if ($this->GetY() + $rowHeight > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);

        for ($i=0; $i<count($data); $i++) {

            $w = $widths[$i];
            $a = $aligns[$i] ?? 'L';
            $x = $this->GetX();
            $y = $this->GetY();

            // Border
            $this->Rect($x, $y, $w, $rowHeight);

            // === GAMBAR ===
            if ($i == count($data)-1 && $imagePath && file_exists($imagePath)) {

                list($imgWpx, $imgHpx) = getimagesize($imagePath);

                $maxW = $w - 6;
                $maxH = $rowHeight - 6;

                $ratio = min($maxW/$imgWpx, $maxH/$imgHpx);

                $imgW = $imgWpx * $ratio;
                $imgH = $imgHpx * $ratio;

                $imgX = $x + ($w - $imgW) / 2;
                $imgY = $y + ($rowHeight - $imgH) / 2;

                $this->Image($imagePath, $imgX, $imgY, $imgW, $imgH);
            }
            else {
                $this->MultiCell($w, $lineHeight, $data[$i], 0, $a);
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
        $sep = -1;
        $i = 0; $j = 0; $l = 0; $nl = 1;

        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                $i = ($sep == -1) ? $i+1 : $sep+1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}

/* ========= PDF ========= */
$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Inventaris '.$ruangData['nama_ruang'],0,1,'C');
$pdf->Ln(5);

$kolom = [
    'No' => 10,
    'Kode' => 30,
    'Nama Barang' => 55,
    'Rak' => 15,
    'Baris' => 15,
    'Box' => 15,
    'Gambar' => 50
];

$pdf->SetFont('Arial','B',12);
foreach ($kolom as $j => $w) {
    $pdf->Cell($w,10,$j,1,0,'C');
}
$pdf->Ln();

$pdf->SetFont('Arial','',11);

$widths = array_values($kolom);
$aligns = ['C','C','L','C','C','C','C'];

$no = 1;
while ($row = mysqli_fetch_assoc($data)) {

    $imagePath = (!empty($row['image']) && file_exists('../uploads/'.$row['image']))
        ? '../uploads/'.$row['image']
        : null;

    $pdf->Row([
        $no++,
        $row['kode'],
        $row['nama'],
        $row['rak'],
        $row['baris'],
        $row['box'],
        ''
    ], $widths, $aligns, $imagePath);
}

ob_end_clean();
$pdf->Output('D','Inventaris_Ruang_'.$ruangData['nama_ruang'].'.pdf');
exit;
