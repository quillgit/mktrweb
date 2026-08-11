<?php
	include "configuration/path.php";
	
	date_default_timezone_set("Asia/Bangkok");
	$date = date('Y-m-d H:i:s');
	
	$search = antiinjection($_POST['search']);
	
	$slug	= antiinjection(slug($_POST['search']));
	
	
	$link = "$nama_folder/cari/$slug";
	
	echo "<script>window.location=('$link')</script>";
	
?>
										