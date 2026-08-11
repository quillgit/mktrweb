<?php

include "../../parser-php-version.php"; //Konversi dan migrasi PHP version
include "../../configuration/connection.php";
include "../../configuration/function.php";
session_start();
if(!isset($_SESSION["namauser"])) {
    header("Location: ../../index.php");
    exit();
}

if($_GET) {
    $draw = $_GET["draw"];
    $start = $_GET["start"];
    $length = $_GET["length"];
    $search = $_GET["search"]["value"];
    if(isset($search)) {
        $supplier = mysql_query("SELECT 
		tabel_komunitas_kategori.id_kategori, 
		tabel_komunitas_kategori.title, 
		tabel_komunitas_kategori.deskripsi, 
		tabel_komunitas_kategori.slug, 
		tabel_komunitas_kategori.created, 
		tabel_komunitas_kategori.author, 
		tabel_komunitas_kategori.`status`
		FROM tabel_komunitas_kategori 
		WHERE (tabel_komunitas_kategori.title LIKE '%$search%' OR tabel_komunitas_kategori.deskripsi LIKE '%$search%') ORDER BY tabel_komunitas_kategori.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query(" SELECT
		tabel_komunitas_kategori.id_kategori, 
		tabel_komunitas_kategori.title, 
		tabel_komunitas_kategori.deskripsi, 
		tabel_komunitas_kategori.slug, 
		tabel_komunitas_kategori.created, 
		tabel_komunitas_kategori.author, 
		tabel_komunitas_kategori.`status`
		FROM tabel_komunitas_kategori 	
		WHERE 1
		ORDER BY tabel_komunitas_kategori.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_komunitas_kategori ");
    $data = new stdClass();
    $data->draw = $draw;
    $data->recordsTotal = mysql_num_rows($records_total);
    $data->recordsFiltered = mysql_num_rows($records_total);
    $data->data = [];
    $no = $start+1;
    while ($result_produk = mysql_fetch_array($supplier)) 
    {
        $data_produk = [];
        $data_produk[0] = $no;
        $data_produk[1] = $result_produk["title"];
		$data_produk[2] = $result_produk["deskripsi"];
		$data_produk[3] = $result_produk["created"];
        $data_produk[4] = "<a href='?menu=komunitas_kategori&mod=edit&id=$result_produk[id_kategori]'><i class='feather icon-edit'></i></a> <a href='?menu=komunitas_kategori&&act=delete&id=$result_produk[id_kategori]' data-confirm='Anda yakin akan menghapus data ini?'><i class='feather icon-trash'></i></a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>