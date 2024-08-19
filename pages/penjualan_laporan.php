<?php 

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
};
 
require 'functions.php';

//Memanggil file FPDF dari file yang anda download tadi
require('../fpdf/fpdf.php');

$pdf = new FPDF("L","cm","A4");

//Panggil tabel admin
if (!isset($_POST['tanggal_awal']) && !isset($_POST['tanggal_akhir'])) {

$beli = mysqli_query($koneksi, "SELECT * FROM jual INNER JOIN detail_jual ON jual.kode_jual = detail_jual.kode_jual INNER JOIN pelanggan ON jual.kode_pelanggan = pelanggan.kode_pelanggan INNER JOIN admin ON jual.kode_admin = admin.kode_admin INNER JOIN barang ON barang.kode_barang = detail_jual.kode_barang ORDER BY jual.kode_jual ASC");

} else {

$tanggal_awal=date('Y-m-d', strtotime($_POST["tanggal_awal"]));
$tanggal_akhir=date('Y-m-d', strtotime($_POST["tanggal_akhir"]));

$beli = mysqli_query($koneksi, "SELECT * FROM jual INNER JOIN detail_jual ON jual.kode_jual = detail_jual.kode_jual INNER JOIN pelanggan ON jual.kode_pelanggan = pelanggan.kode_pelanggan INNER JOIN admin ON jual.kode_admin = admin.kode_admin INNER JOIN barang ON barang.kode_barang = detail_jual.kode_barang WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY jual.kode_jual ASC ");

}

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
$pdf->Cell(28,0.7,"Data Penjualan",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Tanggal : ".date("d/m/Y"),0,0,'L');

$pdf->ln(1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Kode Jual', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Admin', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Pelanggan', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Barang', 1, 0, 'C');
$pdf->Cell(3.25, 0.8, 'Harga', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(3.25, 0.8, 'Sub Total', 1, 0, 'C');

$pdf->ln(0.8);
$pdf->SetFont('Arial','',8);
$no=1;
$total = 0;

foreach ($beli as $lihat) {

	 $subtotal = $lihat['harga'] * $lihat['jumlah'];
     $total = $total + $subtotal;
 	
	 $pdf->Cell(1, 0.8, $no, 1, 0, 'C');
	 $pdf->Cell(3, 0.8, $lihat['kode_jual'], 1, 0,'C');
	 $pdf->Cell(3, 0.8, date('d-m-Y', strtotime($lihat["tanggal"])), 1, 0,'C');
	 $pdf->Cell(3, 0.8, $lihat['nama_admin'],1, 0, 'C');
	 $pdf->Cell(4, 0.8, $lihat['nama_pelanggan'],1, 0, 'C');
	 $pdf->Cell(4, 0.8, $lihat['nama_barang'],1, 0, 'C');
	 $pdf->Cell(3.25, 0.8, rupiah($lihat["harga"]),1, 0, 'C');
	 $pdf->Cell(3, 0.8, $lihat['jumlah'],1, 0, 'C');
	 $pdf->Cell(3.25, 0.8, rupiah($lihat["subtotal"]),1, 0, 'C');

	 $no++;
	 $pdf->ln(0.8);
}

$pdf->ln(0);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(24.25, 0.8, "Total Penjualan",1, 0, 'C');
$pdf->Cell(3.25, 0.8, rupiah($total),1, 0, 'C');

$pdf->ln(1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45,0.7,"Author",0,10,'C');

$pdf->ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,0.7,"Taufik Rahman",0,10,'C');

//Nama file ketika di print
$pdf->Output("laporan_penjualan.pdf","I");

?>