<?php

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
}

require 'functions.php';

$kode_barang = $_GET["kode_barang"];

if ( hapusBarang($kode_barang) > 0) {
		echo "
			<script>
				alert('Data barang berhasil dihapus');
				document.location.href = 'barang.php';
			</script>
			";
	} else {
		echo "
			<script>
				alert('Data barang gagal dihapus');
				document.location.href = 'barang.php';
			</script>
			";
	}

?>