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
		FROM tabel_media_sosial 
		WHERE tabel_media_sosial.title LIKE '%$search%' AND tabel_media_sosial.status = '2' ORDER BY tabel_media_sosial.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT 
		*
		FROM tabel_media_sosial 	
		WHERE tabel_media_sosial.status = '2'
		ORDER BY tabel_media_sosial.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_media_sosial WHERE tabel_media_sosial.status = '2'");
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
        $data_produk[2] = "<img src='../images/media_sosial/$result_produk[gambar]' class='img-fluid' style='max-height: 50px; max-width: 50px;'>";
		$data_produk[3] = $result_produk["link"];
		$data_produk[4] = $result_produk["created"];
		$data_produk[5] = $result_produk["author"];
        $data_produk[6] = "<a href='?menu=media_sosial&mod=edit&id=$result_produk[id_media_sosial]'><i class='feather icon-edit'></i></a> <a href='?menu=media_sosial&&act=delete&id=$result_produk[id_media_sosial]'><i class='feather icon-trash'></i></a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>