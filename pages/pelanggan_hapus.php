<?php

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
}

require 'functions.php';

$kode_pelanggan = $_GET["kode_pelanggan"];

if ( hapusPelanggan($kode_pelanggan) > 0) {
		echo "
			<script>
				alert('Data pelanggan berhasil dihapus');
				document.location.href = 'pelanggan.php';
			</script>
			";
	} else {
		echo "
			<script>
				alert('Data pelanggan gagal dihapus');
				document.location.href = 'pelanggan.php';
			</script>
			";
	}

?>