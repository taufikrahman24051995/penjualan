<?php
session_start();
require 'functions.php';

// cek cookie
if( isset($_COOKIE['kode_admin']) && isset($_COOKIE['username']) ) {
    $kode_admin = $_COOKIE['kode_admin'];
    $username = $_COOKIE['username'];

    // ambil username berdasarkan id
    $result = mysqli_query($koneksi, "SELECT username FROM admin WHERE kode_admin = $kode_admin");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ( $username === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true;
    }
}

if ( isset ($_SESSION["login"]) ) {
    header("Location:index.php");
    exit;
}
 
if (isset($_POST["login"]) ) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");

    // cek username
    if (mysqli_num_rows ($result) === 1 ) {

    // cek password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"]) ){
            
            // set session
            $_SESSION["login"] = true;
            $_SESSION["kode_admin"] = $row["kode_admin"];

            // cek remember me
            if (isset($_POST["remember"]) ) {
                // buat cookie
                setcookie('kode_admin', $row['kode_admin'], time() + 60);
                setcookie('username', hash('sha256', $row['username']), time() + 60);
            }

            echo "<script>
                alert ('Kamu berhasil login');
                document.location.href = 'index.php';
                </script>";
            exit;
        }
    }
            echo "<script>
                    alert ('Kamu gagal login, periksa username atau password');
                 </script>";
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

        <!-- Custom CSS -->
        <link href="../css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

       <link rel="shorcut icon" href="../img/penjualan.png">
        
        <style type="text/css">
            .panel-merah {
                color: #000;
                border-color: #d9534f;
            }
            .panel-heading {
                color: #fff;
                background-color: #d9534f;
            }
            .panel-title {
                font-weight: bold;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-merah">
                        <div class="panel-heading">
                            <center>
                            <h3 class="panel-title">APLIKASI PENJUALAN BARANG</h3>
                            </center>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="username" autocomplete="off" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" autofocus required>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Ingat Saya
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button class="btn btn-lg btn-danger btn-block" name="login">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/startmin.js"></script>

    </body>
</html>
