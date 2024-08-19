<?php

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
}

require 'functions.php';

$kode_jual = $_GET["kode_jual"];

if ( hapusKeranjang($kode_jual) > 0) {
		echo "
			<script>
				alert('Data berhasil dihapus dari keranjang');
				document.location.href = 'transaksi.php';
			</script>
			";
	} else {
		echo "
			<script>
				alert('Data gagal dihapus dari keranjang');
				document.location.href = 'transaksi.php';
			</script>
			";
	}

?>