<?php
	include "../parser-php-version.php";
	include "../configuration/connection.php";
	

	if(isset($_POST['id'])){
		
		$kategori = $_POST['id'];

		$rs = mysql_fetch_array(mysql_query("SELECT
		tabel_produk.title,
		tabel_produk.id_product_category,
		tabel_produk.content,
		tabel_produk.harga_modal,
		tabel_produk.harga,
		tabel_produk.harga_2,
		tabel_produk.harga_3,
		tabel_produk.stock,
		tabel_produk.berat,
		tabel_produk.gambar,
		tabel_produk.keyword,
		tabel_produk.id_product,
		tabel_produk.id_supplier
		FROM
		tabel_produk
		LEFT JOIN tabel_produk_kategori ON tabel_produk.id_product_category = tabel_produk_kategori.id_produk_kategori
		LEFT JOIN tabel_supplier ON tabel_produk.id_supplier = tabel_supplier.id_supplier
		 where tabel_produk.id_product = '$kategori'"));
		
		
		echo json_encode($rs);
	
	}						
?>
