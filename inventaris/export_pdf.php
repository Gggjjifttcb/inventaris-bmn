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
    // Logo
    $this->Image('../assets/logo.png',10,10,25); // sesuaikan ukuran logo
    $this->Image('../assets/logo1.png',175,10,25); // x=170 (posisi horizontal), y=10, lebar=25
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
    $this->Line(10,45,200,45);  // Garis tebal
    $this->SetLineWidth(0.2);
    $this->Line(10,46,200,46);  // Garis tipis

    $this->Ln(10); // jarak sebelum konten
}

}

// Buat PDF
$pdf = new PDF();
$pdf->AddPage();

// Judul Laporan
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Inventaris Ruang '.$ruangData['nama_ruang'],0,1,'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'No',1);
$pdf->Cell(30,10,'Kode',1);
$pdf->Cell(50,10,'Nama Barang',1);
$pdf->Cell(20,10,'Rak',1);
$pdf->Cell(20,10,'Baris',1);
$pdf->Cell(20,10,'Box',1);
$pdf->Ln();

// Isi tabel
$pdf->SetFont('Arial','',12);
$no = 1;
while($row = mysqli_fetch_assoc($data)){
    $pdf->Cell(10,10,$no++,1);
    $pdf->Cell(30,10,$row['kode'],1);
    $pdf->Cell(50,10,$row['nama'],1);
    $pdf->Cell(20,10,$row['rak'],1);
    $pdf->Cell(20,10,$row['baris'],1);
    $pdf->Cell(20,10,$row['box'],1);
    $pdf->Ln();
}

$pdf->Output('D','Inventaris_Ruang_'.$ruangData['nama_ruang'].'.pdf');
