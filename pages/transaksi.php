<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
}

require 'functions.php';   

$sql = mysqli_query($koneksi, "SELECT * FROM keranjang");
$ketemu = mysqli_num_rows($sql);
if ($ketemu === 0){
    $query = mysqli_query($koneksi, "SELECT MAX(kode_jual) as kodeTerbesar FROM jual");
    $data = mysqli_fetch_array($query);
    $kodeJual = $data['kodeTerbesar'];

    $urutan = (int) substr ($kodeJual, 9, 9);

    $urutan++;

    $huruf = "JUAL";
    $kodeJual = $huruf . sprintf("%09s", $urutan);
} else {
    $query = mysqli_query($koneksi, "SELECT MAX(kode_jual) as kodeTerbesar FROM keranjang");
    $data = mysqli_fetch_array($query);
    $kodeJual = $data['kodeTerbesar'];

    $urutan = (int) substr ($kodeJual, 9, 9);

    $urutan++;

    $huruf = "JUAL";
    $kodeJual = $huruf . sprintf("%09s", $urutan);
}

$keranjang = query("SELECT * FROM keranjang INNER JOIN pelanggan ON keranjang.kode_pelanggan = pelanggan.kode_pelanggan INNER JOIN barang ON keranjang.kode_barang = barang.kode_barang WHERE kode_admin = '$_SESSION[kode_admin]' ORDER BY keranjang.kode_jual ASC");

$nama_admin = query("SELECT * FROM admin WHERE kode_admin = '$_SESSION[kode_admin]' ");

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["input_keranjang"]) ) {

    // cek apakah data berhasil ditambahkan atau tidak
    if( tambahKeranjang($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan ke keranjang');
                document.location.href = 'transaksi.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan ke keranjang');
                document.location.href = 'transaksi.php';
            </script>
            ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>APLIKASI PENJUALAN BARANG</title>

        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">
        
        <!-- Social Buttons CSS -->
        <link href="../css/bootstrap-social.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="../css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../css/startmin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="../css/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
          <!-- DataTables CSS -->
        <link href="../css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="../css/dataTables/dataTables.responsive.css" rel="stylesheet">


        <link rel="shorcut icon" href="../img/penjualan.png">

        <style type="text/css">
             .navbar-inverse {
                background-color: #d9534f;
                border-color: red;
            }

             li a {
                color: #d9534f;
                text-decoration: none;
            }

            li a:hover {
                color: red;
                text-decoration: none;
            }
            .navbar-header a{
                font-weight: bold;
            }
            .total {
                background-color: #d9534f;
                color: #fff;
            }
        </style>
               
    </head>
    <body>
           <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
                <div class="navbar-header">
                    <a class="navbar-brand" style="color:white;" href="#">APLIKASI PENJUALAN BARANG</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:white;">
                            <i class="fa fa-user fa-fw"></i>
                            <?php foreach ($nama_admin as $row) : ?>
                                <?php echo $row["nama_admin"]; ?>
                            <?php endforeach; ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="admin_edit.php"><i class="fa fa-user fa-fw"></i> Edit Profil</a>
                            </li>
                            <li>
                                <a href="admin_edit_password.php"><i class="fa fa-gear fa-fw"></i> Ganti Password</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="index.php"><i class="fa fa-home fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="admin.php"><i class="fa fa-user fa-fw"></i> Data Admin</a>
                            </li>
                            <li>
                                <a href="pelanggan.php"><i class="fa fa-users fa-fw"></i> Data Pelanggan</a>
                            </li>
                            <li>
                                <a href="barang.php"><i class="fa fa-briefcase fa-fw"></i> Data Barang</a>
                            </li>
                            <li>
                                <a href="penjualan.php"><i class="fa fa-money fa-fw"></i> Data Penjualan</a>
                            </li>
                            <li>
                                <a href="transaksi.php"><i class="fa fa-handshake-o fa-fw"></i> Transaksi</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-print fa-fw"></i> Laporan<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="admin_laporan.php" target="_blank">Laporan Data Admin</a>
                                    </li>
                                    <li>
                                        <a href="pelanggan_laporan.php" target="_blank">Laporan Data Pelanggan</a>
                                    </li>
                                    <li>
                                        <a href="barang_laporan.php" target="_blank">Laporan Data Barang</a>
                                    </li>
                                    <li>
                                        <a href="penjualan_laporan_cetak.php">Laporan Data Penjualan</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"><i class="fa fa-handshake-o  fa-fw"></i> Transaksi Penjualan</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form class="row" role="form" action="" method="post">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Penjualan</label>
                                            <input name="kode_jual" class="form-control" placeholder="Kode Jual" value="<?php echo $kodeJual; ?>"readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Pelanggan</label>
                                            <select name="nama_pelanggan" class="form-control" autofocus required>
                                                <option value="" >Pilih Nama Pelanggan</option>
                                                <?php 
                                                    $pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                                    $jsArray = "var prdName = new Array();\n";
                                                    while($nama_pelanggan = mysqli_fetch_array($pelanggan) ) {
                                                    echo'<option value = "' .$nama_pelanggan['kode_pelanggan'].'">'. $nama_pelanggan['nama_pelanggan'].' </option>';
                                                    }
                                                 ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                                <label>Nama Barang</label>
                                                <select id="nama_barang" name="nama_barang" onchange="changeValue(this.value)" class="form-control" required>
                                                    <option value="">Pilih Nama Barang</option>
                                                    <?php 
                                                        $barang = mysqli_query($koneksi, "SELECT * FROM barang");
                                                        $jsArray = "var prdName = new Array();\n";
                                                        while($nama_barang = mysqli_fetch_array($barang) ) {
                                                        echo'<option value = "' .$nama_barang['kode_barang'].'">'. $nama_barang['nama_barang'].' </option>';
                                                        $jsArray .= "prdName['" . $nama_barang['kode_barang'] . "'] = {harga: '" .addslashes($nama_barang['harga']) . "'};\n";
                                                        }
                                                     ?>
                                                </select>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-danger" name="input_keranjang"><i class="fa fa-plus fa-fw"></i> Input Keranjang</button>
                                        <br>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="harga">Harga</label>
                                            <input class="form-control" placeholder="Harga" name="harga" id="harga" onkeyup="sum();" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah">Jumlah</label>
                                            <input class="form-control" placeholder="Jumlah" type="number" name="jumlah" id="jumlah" onkeyup="sum();" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>   
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <div align="center">No</div>
                                    </th>
                                    <th>
                                        <div align="center">Nama Pelanggan</div>
                                    </th>
                                    <th>
                                        <div align="center">Nama Barang</div>  
                                    </th>
                                    <th>
                                        <div align="center">Harga</div>
                                    </th>
                                    <th>
                                        <div align="center">Jumlah</div>
                                    </th>
                                    <th>
                                        <div align="center">Sub Total</div>
                                    </th>
                                    <th>
                                        <div align="center">Aksi</div>
                                    </th>
                            </thead>
                            <tbody>

                                <?php $i = 1; ?>
                                <?php $total = 0; ?>
                                <?php foreach ($keranjang as $row) : ?>

                                <?php $subtotal = $row['harga'] * $row['jumlah']; ?>
                                <?php $total = $total + $subtotal; ?>

                                <tr>
                                    <td align="center"><?= $i ?></td>
                                    <td align="center"><?= $row['nama_pelanggan'] ?></td>
                                    <td align="center"><?= $row['nama_barang'] ?></td>
                                    <td align="right"><?= rupiah($row['harga']) ?></td>
                                    <td align="center"><?= $row['jumlah'] ?></td>
                                    <td align="right"><?= rupiah($subtotal) ?></td>
                                    <td align="center">
                                        <a style="text-decoration: none; color: white;" href="transaksi_hapus.php?kode_jual=<?php echo $row["kode_jual"]; ?>" onclick="return confirm('Hapus data di keranjang');" >
                                        <button class="btn btn-warning">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                        </a>
                                    </td>
                                </tr>

                                 <?php $i++; ?>
                                 <?php endforeach; ?>

                                 <?php 

                                    $sql = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE kode_admin = '$_SESSION[kode_admin]' ");
                                    $ketemu = mysqli_num_rows($sql);
                                    if ($ketemu === 0){
                                        echo "<tr>
                                            <td colspan='7' align='center'>
                                                <strong>No data available in table</strong>
                                            </td>
                                        </tr>";
                                    } 

                                 ?>

                                 <tr>
                                    <td colspan="5" align="center" class="total">
                                        <strong>Total Harga</strong></td>
                                    <td colspan="2" align="center" class="total">
                                        <strong><?php echo rupiah($total) ?></strong>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                    <?php 

                        $sql = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE kode_admin = '$_SESSION[kode_admin]' ");
                        $ketemu = mysqli_num_rows($sql);
                        if ($ketemu == 0){
                            echo "";
                        } else {
                            echo "<a href='transaksi_aksi.php'>       
                                    <button type='submit' name='transaksi_input' class='btn btn-primary'><i class='fa fa-plus fa-fw'></i>Input Penjualan
                                    </button>
                                </a>

                                 <a href='transaksi_cetak.php' target='_blank'>       
                                    <button type='submit' name='transaksi_cetak' class='btn btn-warning'><i class='fa fa-print fa-fw'></i>Cetak Transaksi
                                    </button>
                                </a>";
                        }

                     ?>                     
            </div>
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/startmin.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../js/dataTables/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables/dataTables.bootstrap.min.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script>

        <script type="text/javascript">
            <?php echo $jsArray; ?>
            function changeValue(id) {
                document.getElementById('harga').value = prdName[id].harga;
            };
        </script>

        <script type="text/javascript">
            function sum() {
                var txtFirstNumberValue = document.getElementById('harga').value;
                var txtSecondNumberValue = document.getElementById('jumlah').value;
                var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
                if (!isNaN(result)) {
                    document.getElementById('total').value = result;
                }
            }
        </script>

    </body>
</html>
