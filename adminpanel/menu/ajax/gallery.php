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
		*
		FROM tabel_gallery_kategori 	
		WHERE (tabel_gallery_kategori.title LIKE '%$search%' OR tabel_gallery_kategori.description LIKE '%$search%') AND tabel_gallery_kategori.status = '2' ORDER BY tabel_gallery_kategori.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT 
		*
		FROM tabel_gallery_kategori 	
		WHERE tabel_gallery_kategori.status = '2'
		ORDER BY tabel_gallery_kategori.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_gallery_kategori WHERE tabel_gallery_kategori.status = '2'");
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
		$data_produk[2] = $result_produk["description"];
		$data_produk[3] = $result_produk["created"];
		$data_produk[4] = $result_produk["author"];
        $data_produk[5] = "<a href='?menu=gallery&mod=edit&id=$result_produk[id_kategori]'><i class='feather icon-edit'></i></a> <a href='?menu=gallery&act=delete&id=$result_produk[id_kategori]'><i class='feather icon-trash'></i></a>";
		$data_produk[6] = "<a href='?menu=gallery&mod=detail&id=$result_produk[id_kategori]'><button type='button' class='btn btn-primary'><i class='fa fa-plus-circle'></i></button></a>";
		
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>