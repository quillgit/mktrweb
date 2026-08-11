<?php
	include "../parser-php-version.php";
	include "../configuration/connection.php";
	

	if(isset($_POST['id'])){
		
		$kategori = $_POST['id'];

		$rs = mysql_fetch_array(mysql_query("SELECT * FROM mst_stok_opname where id_stok_opname = '$kategori'"));
		
		
		echo json_encode($rs);
	
	}						
?>
