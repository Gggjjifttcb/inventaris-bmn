<?php
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
        // Logo kiri
        $this->Image('../assets/logo.png',10,10,25);
        // Logo kanan
        $this->Image('../assets/logo1.png',175,10,25);

        // Judul Kop
        $this->SetFont('Arial','B',14);
        $this->Cell(0,7,'KEMENTERIAN PARIWISATA REPUBLIK INDONESIA',0,1,'C');

        $this->SetFont('Arial','B',12);
        $this->Cell(0,7,'POLITEKNIK PARIWISATA LOMBOK',0,1,'C');

        $this->SetFont('Arial','',10);
        $this->MultiCell(0,5,"Jalan Raden Puguh No. 1, Puyung, Jonggat,\nPraya, Lombok Tengah, Provinsi Nusa Tenggara Barat 83561\nTelepon (+62-0370) 6158029; Faksimile (+62 0370) 6158030\nLaman: www.ppl.ac.id  Posel: info@ppl.ac.id",0,'C');

        // Garis
        $this->Ln(3);
        $this->SetLineWidth(0.8);
        $this->Line(10,45,200,45);
        $this->SetLineWidth(0.2);
        $this->Line(10,46,200,46);

        $this->Ln(10);
    }
}

// Membuat PDF
$pdf = new PDF();
$pdf->AddPage();

// Judul Laporan
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Inventaris Ruang '.$ruangData['nama_ruang'],0,1,'C');
$pdf->Ln(5);

// Lebar kolom sesuai index.php
$kolom = [
    'No' => 10,
    'Kode' => 30,
    'Nama Barang' => 50,
    'Rak' => 20,
    'Baris' => 20,
    'Box' => 20,
    'Gambar' => 30
];

// Header tabel
$pdf->SetFont('Arial','B',12);
foreach($kolom as $judul => $lebar){
    $pdf->Cell($lebar,10,$judul,1,0,'C');
}
$pdf->Ln();

// Isi tabel
$pdf->SetFont('Arial','',12);
$no = 1;
while($row = mysqli_fetch_assoc($data)){
    $pdf->Cell($kolom['No'],25,$no++,1,0,'C');
    $pdf->Cell($kolom['Kode'],25,$row['kode'],1,0,'C');
    $pdf->Cell($kolom['Nama Barang'],25,$row['nama'],1,0,'L');
    $pdf->Cell($kolom['Rak'],25,$row['rak'],1,0,'C');
    $pdf->Cell($kolom['Baris'],25,$row['baris'],1,0,'C');
    $pdf->Cell($kolom['Box'],25,$row['box'],1,0,'C');

    // Kolom gambar
    $pdf->Cell($kolom['Gambar'],25,'',1);
    if(!empty($row['image']) && file_exists('../uploads/'.$row['image'])){
        $x = $pdf->GetX() - $kolom['Gambar'];
        $y = $pdf->GetY();
        $pdf->Image('../uploads/'.$row['image'],$x+2,$y+2,$kolom['Gambar']-4,21);
    }

    $pdf->Ln();
}

$pdf->Output('D','Inventaris_Ruang_'.$ruangData['nama_ruang'].'.pdf');
