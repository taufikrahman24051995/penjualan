<?php 

// koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "penjualan");

function query ($query) {
	global $koneksi;
	$result = mysqli_query ($koneksi, $query);
	$rows = [];
	while ( $row = mysqli_fetch_assoc ($result)) {
		$rows [] = $row;
	}
	return $rows;
}

function tambahAdmin ($data) {
	global $koneksi;

	$kode_admin = htmlspecialchars($data["kode_admin"]);
	$nama_admin = htmlspecialchars($data["nama_admin"]);
	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($koneksi, $data["password"]);
	$password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT username FROM admin WHERE username = '$username'");

	if (mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert ('Username sudah terdaftar');
			  </script>";

		return false;
	}

	// cek konfirmasi password
	if ( $password !== $password2) {
		echo "<script>
				alert ('Konfirmasi password tidak sesuai');
			  </script>";

		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan user baru ke database
	mysqli_query($koneksi, "INSERT INTO admin VALUES ('$kode_admin', '$nama_admin', '$username', '$password')");

	return mysqli_affected_rows($koneksi);
}

function editAdmin($data) {
	global $koneksi;

	$kode_admin = htmlspecialchars($data["kode_admin"]);
	$nama_admin = htmlspecialchars($data["nama_admin"]);
	$username = strtolower(stripslashes($data["username"]));
	
	$query = "UPDATE admin SET kode_admin = '$kode_admin', nama_admin = '$nama_admin', username = '$username' WHERE kode_admin = '$kode_admin' ";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);

}

function editPasswordAdmin($data) {
	global $koneksi;

	$password_lama = mysqli_real_escape_string($koneksi, $data["password_lama"]);
	$password_baru = mysqli_real_escape_string($koneksi, $data["password_baru"]);
	$password_baru2 = mysqli_real_escape_string($koneksi, $data["password_baru2"]);

	// cek password sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT * FROM admin WHERE kode_admin = '$_SESSION[kode_admin]' ");
	$data = mysqli_fetch_array($result);

    // cek password
   	$pass = password_verify($password_lama, $data['password']);

   	if ($pass === TRUE) {
        
        	// cek konfirmasi password
			if ( $password_baru !== $password_baru2) {
				echo "<script>
						alert ('Konfirmasi password tidak sesuai');
					  </script>";

				return false;
			}

			// enkripsi password
			$password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
			
			$query = "UPDATE admin SET password = '$password_baru' WHERE kode_admin = '$_SESSION[kode_admin]' ";
			mysqli_query($koneksi, $query);

			return mysqli_affected_rows($koneksi);

	}
}

function tambahPelanggan($data) {
	global $koneksi;

	$kode_pelanggan = htmlspecialchars($data["kode_pelanggan"]);
	$nama_pelanggan = htmlspecialchars($data["nama_pelanggan"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$telepon = htmlspecialchars($data["telepon"]);

	$query = "INSERT INTO pelanggan VALUES ('$kode_pelanggan', '$nama_pelanggan', '$alamat', '$telepon')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function hapusPelanggan($kode_pelanggan) {
	global $koneksi;
	mysqli_query ($koneksi, "DELETE FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
	
	return mysqli_affected_rows($koneksi);
}

function ubahPelanggan($data) {
	global $koneksi;

	$kode_pelanggan = htmlspecialchars($data["kode_pelanggan"]);
	$nama_pelanggan = htmlspecialchars($data["nama_pelanggan"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$telepon = htmlspecialchars($data["telepon"]);
	
	$query = "UPDATE pelanggan SET kode_pelanggan = '$kode_pelanggan', nama_pelanggan = '$nama_pelanggan', alamat = '$alamat', telepon = '$telepon' WHERE kode_pelanggan = '$kode_pelanggan' ";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function tambahBarang ($data) {
	global $koneksi;

	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$nama_barang = htmlspecialchars($data["nama_barang"]);
	$harga = htmlspecialchars($data["harga"]);
	$stok = htmlspecialchars($data["stok"]);

	$query = "INSERT INTO barang VALUES ('$kode_barang', '$nama_barang', '$harga', '$stok')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function hapusBarang($kode_barang) {
	global $koneksi;
	mysqli_query ($koneksi, "DELETE FROM barang WHERE kode_barang='$kode_barang'");
	
	return mysqli_affected_rows($koneksi);
}

function ubahBarang($data) {
	global $koneksi;

	$kode_barang = htmlspecialchars($data["kode_barang"]);
	$nama_barang = htmlspecialchars($data["nama_barang"]);
	$harga = htmlspecialchars($data["harga"]);
	$stok = htmlspecialchars($data["stok"]);
	
	$query = "UPDATE barang SET kode_barang = '$kode_barang', nama_barang = '$nama_barang', harga = '$harga', stok = '$stok' WHERE kode_barang = '$kode_barang' ";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function rupiah($angka) {
	$hasil_rupiah = number_format($angka,2,',','.');
	return $hasil_rupiah;
}

function tambahKeranjang($data) {
	global $koneksi;

	$kode_jual = htmlspecialchars($data["kode_jual"]);
	$kode_admin = htmlspecialchars($_SESSION["kode_admin"]);
	$kode_pelanggan = htmlspecialchars($data["nama_pelanggan"]);
	$kode_barang = htmlspecialchars($data["nama_barang"]);
	$harga = htmlspecialchars($data["harga"]);
	$jumlah = htmlspecialchars($data["jumlah"]);

	$stok = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '$kode_barang' ");
	$data = mysqli_fetch_array($stok);

	if ($jumlah > $data['stok'] ) {
		echo "<script> 
					alert ('Stok barang tidak cukup');
					document.location.href = 'transaksi.php';
			</script>";
			exit;
	} else {
 
	//di cek dulu apakah barang yang di beli sudah ada di tabel keranjang
	$sql = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE kode_barang = '$kode_barang' AND kode_admin = '$_SESSION[kode_admin]' ");
    $ketemu = mysqli_num_rows($sql);
    if ($ketemu === 0){
        // kalau barang belum ada, maka di jalankan perintah insert
        mysqli_query($koneksi, "INSERT INTO keranjang (kode_jual, kode_admin, kode_pelanggan, kode_barang, harga, jumlah)
                VALUES ('$kode_jual', '$kode_admin', '$kode_pelanggan', '$kode_barang', '$harga', '$jumlah')");
    } else {
        //  kalau barang ada, maka di jalankan perintah update
        mysqli_query($koneksi, "UPDATE keranjang
                SET jumlah = jumlah + $jumlah
                WHERE kode_barang = '$kode_barang' AND kode_admin = '$_SESSION[kode_admin]' ");       
    }   

	}

	return mysqli_affected_rows($koneksi);
}

function hapusKeranjang($kode_jual) {
	global $koneksi;
	mysqli_query ($koneksi, "DELETE FROM keranjang WHERE kode_jual = '$kode_jual'");
	
	return mysqli_affected_rows($koneksi);
}

?>



                                        