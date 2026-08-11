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
		tabel_magang.created,
		tabel_magang.title,
		tabel_magang.title_english,
		tabel_magang.gambar,
		tabel_magang.author,
		tabel_magang.id_magang
		FROM tabel_magang 
		WHERE (tabel_magang.title LIKE '%$search%' OR tabel_magang.title_english LIKE '%$search%') AND tabel_magang.status = '2' ORDER BY tabel_magang.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query(" SELECT
		tabel_magang.created,
		tabel_magang.title,
		tabel_magang.title_english,
		tabel_magang.gambar,
		tabel_magang.author,
		tabel_magang.id_magang
		FROM tabel_magang 	
		WHERE tabel_magang.status = '2'
		ORDER BY tabel_magang.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_magang WHERE tabel_magang.status = '2'");
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
		$data_produk[2] = $result_produk["title_english"];
        $data_produk[3] = "<img src='../images/post/$result_produk[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'>";
		$data_produk[4] = $result_produk["created"];
		$data_produk[5] = $result_produk["author"];
        $data_produk[6] = "<a href='?menu=magang&mod=edit&id=$result_produk[id_magang]'><i class='feather icon-edit'></i></a> <a href='?menu=magang&&act=delete&id=$result_produk[id_magang]'><i class='feather icon-trash'></i></a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>