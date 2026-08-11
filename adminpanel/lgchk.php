<?php
include "parser-php-version.php"; //Konversi dan migrasi PHP version
include "configuration/connection.php";
include "configuration/function.php";

$name = antiinjection($_POST['uword']);
$pass = antiinjection($_POST['pword']);

$qry = "SELECT * FROM pw_users WHERE username = '$name' AND status = '2'";
$login = mysql_query($qry);
$login or die(errorhandler($query, mysql_error()));
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
if( password_verify($pass, $r['password']) ) {
	
	session_start(); //untuk memulai session
		  
	// isi dari variabel session
	$_SESSION['namauser']	= $r['username'];
	$_SESSION['passuser']	= $r['password'];
	$_SESSION['id_user']  	= $r['id_users'];
	//$_SESSION['accesslevel']= explode("-",$r['access']);
	
	date_default_timezone_set("Asia/Bangkok");
	$date = date('Y-m-d H:i:s');
	$update=mysql_query("UPDATE pw_users SET last_login ='$date' WHERE username='$r[username]'");

	header('location:admin.php?menu=home');
}
else{
  header('location:index.php?message=gagal');
}
?>
