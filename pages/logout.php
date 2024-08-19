<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location:login.php");
    exit;
}

$_SESSION = [];

session_unset();

session_destroy();

setcookie('id_admin', '', time() - 3600);
setcookie('username', '', time() - 3600);

echo "<script>  
		alert('Kamu berhasil logout');  
		document.location.href='login.php';  
	  </script>";
exit;

?>

