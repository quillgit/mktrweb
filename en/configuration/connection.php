<?php
$server = "localhost";
$username = "mktrcoid_web";
$password = "LxnUMP!V,0}E";
$database = "mktrcoid_website";

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
?>
