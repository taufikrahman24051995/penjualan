<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
};
 
require 'functions.php';

//Memanggil file FPDF dari file yang anda download tadi
require('../fpdf/fpdf.php');

$pdf = new FPDF("P","cm","A4");

$pdf->SetMargins(1,0.5,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',70);
$pdf->Cell(19,2.5,"IT KOMPUTER",0,20,'C');
$pdf->SetFont('Times','I',10);
$pdf->Cell(19,0,"Jalan Puspa Nyidera Pantai Hambawang Timur RT.005 RW.001 Kec. Labuan Amas Selatan Kab. Hulu Sungai Tengah 71361",0,20,'C');

$pdf->Line(1,3.3,20,3.3);
$pdf->Line(1,3.4,20,3.4);

$pdf->SetFont('Times','B',11);
$pdf->ln(1);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(19,0.7,"Data Pelanggan",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Tanggal : ".date("d/m/Y"),0,0,'L');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);

//Tidak berpengaruh dengan database hanya sebagai keterangan pada tabel nantinya
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Kode Pelanggan', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama Pelanggan', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Alamat', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Telepon', 1, 0, 'C');

$pdf->ln(0.8);
$pdf->SetFont('Arial','',10);
$no=1;

$query = mysqli_query($koneksi,"SELECT * FROM pelanggan");
while ($lihat = mysqli_fetch_array($query) ) {

 $pdf->Cell(1, 0.8, $no, 1, 0, 'C');
 $pdf->Cell(4, 0.8, $lihat['kode_pelanggan'], 1, 0,'C');
 $pdf->Cell(5, 0.8, $lihat['nama_pelanggan'], 1, 0,'L');
 $pdf->Cell(6, 0.8, $lihat['alamat'],1, 0, 'L');
 $pdf->Cell(3, 0.8,$lihat['telepon'],1, 0, 'C');

 $no++;
 $pdf->ln(0.8);
}

$pdf->ln(1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(30,0.7,"Author",0,10,'C');

$pdf->ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,0.7,"Taufik Rahman",0,10,'C');
//Nama file ketika di print
$pdf->Output("laporan_pemasok.pdf","I");

?>