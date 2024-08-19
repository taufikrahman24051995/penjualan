<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
};
 
require 'functions.php';

$transaksi = query("SELECT * FROM keranjang INNER JOIN admin ON keranjang.kode_admin = admin.kode_admin INNER JOIN pelanggan ON keranjang.kode_pelanggan = pelanggan.kode_pelanggan INNER JOIN barang ON keranjang.kode_barang = barang.kode_barang WHERE keranjang.kode_admin = '$_SESSION[kode_admin]' ORDER BY keranjang.kode_jual ASC");

//Memanggil file FPDF dari file yang anda download tadi
require('../fpdf/fpdf.php');

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(1,0.5,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',70);
$pdf->Cell(28,2.5,"IT KOMPUTER",0,20,'C');
$pdf->SetFont('Times','I',10);
$pdf->Cell(28,0,"Jalan Puspa Nyidera Pantai Hambawang Timur RT.005 RW.001 Kec. Labuan Amas Selatan Kab. Hulu Sungai Tengah 71361",0,20,'C');

$pdf->Line(1,3.3,28.5,3.3);
$pdf->Line(1,3.4,28.5,3.4);

$pdf->SetFont('Times','B',11);
$pdf->ln(1);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(28,0.7,"Data Transaksi",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Tanggal : ".date("d/m/Y"),0,0,'L');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);

//Tidak berpengaruh dengan database hanya sebagai keterangan pada tabel nantinya
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Kode Jual', 1, 0, 'C');
$pdf->Cell(3.50, 0.8, 'Nama Admin', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama Pelanggan', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Harga', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Subtotal', 1, 0, 'C');

$pdf->ln(0.8);
$pdf->SetFont('Arial','',10);
$no = 1;
$total = 0;

foreach ($transaksi as $lihat) {

	 $subtotal = $lihat['harga'] * $lihat['jumlah'];
     $total = $total + $subtotal;

 $pdf->Cell(1, 0.8, $no, 1, 0, 'C');
 $pdf->Cell(4, 0.8, $lihat['kode_jual'], 1, 0,'C');
 $pdf->Cell(3.50, 0.8, $lihat['nama_admin'], 1, 0,'C');
 $pdf->Cell(5, 0.8, $lihat['nama_pelanggan'], 1, 0,'C');
 $pdf->Cell(5, 0.8, $lihat['nama_barang'], 1, 0,'L');
 $pdf->Cell(3, 0.8, rupiah($lihat['harga']),1, 0, 'C');
 $pdf->Cell(3, 0.8, $lihat['jumlah'],1, 0, 'C');
 $pdf->Cell(3, 0.8, rupiah($subtotal) ,1, 0, 'C');

 $no++;
 $pdf->ln(0.8);
}

$pdf->ln(0);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(24.50, 0.8, "Total Transaksi",1, 0, 'C');
$pdf->Cell(3, 0.8, rupiah($total),1, 0, 'C');

$pdf->ln(1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45,0.7,"Author",0,10,'C');

$pdf->ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,0.7,"Taufik Rahman",0,10,'C');
//Nama file ketika di print
$pdf->Output("laporan_transaksi.pdf","I");

?>