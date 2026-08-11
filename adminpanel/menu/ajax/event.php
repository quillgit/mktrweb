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
		tabel_event.created,
		tabel_event.title,
		tabel_event.title_english,
		tabel_event.gambar,
		tabel_event.author,
		tabel_event.id_event,
		tabel_event.event_date,
		tabel_event.id_event_kategori
		FROM tabel_event 
		WHERE (tabel_event.title LIKE '%$search%' OR tabel_event.title_english LIKE '%$search%') AND tabel_event.status = '2' ORDER BY tabel_event.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query(" SELECT
		tabel_event.created,
		tabel_event.title,
		tabel_event.title_english,
		tabel_event.gambar,
		tabel_event.author,
		tabel_event.id_event,
		tabel_event.event_date,
		tabel_event.id_event_kategori
		FROM tabel_event 	
		WHERE tabel_event.status = '2'
		ORDER BY tabel_event.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_event WHERE tabel_event.status = '2'");
    $data = new stdClass();
    $data->draw = $draw;
    $data->recordsTotal = mysql_num_rows($records_total);
    $data->recordsFiltered = mysql_num_rows($records_total);
    $data->data = [];
    $no = $start+1;
    while ($result_produk = mysql_fetch_array($supplier)) 
    {
		
		$cek_kategori = mysql_fetch_array(mysql_query("SELECT title FROM tabel_event_kategori WHERE id_event_kategori = '$result_produk[id_event_kategori]'"));
		
        $data_produk = [];
        $data_produk[0] = $no;
        $data_produk[1] = $cek_kategori["title"];
        $data_produk[2] = $result_produk["title"];
		$data_produk[3] = $result_produk["title_english"];
		$data_produk[4] = $result_produk["event_date"];
        $data_produk[5] = "<img src='../images/post/$result_produk[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'>";
		$data_produk[6] = $result_produk["created"];
		$data_produk[7] = $result_produk["author"];
        $data_produk[8] = "<a href='?menu=event&mod=edit&id=$result_produk[id_event]'><i class='feather icon-edit'></i></a> <a href='?menu=event&&act=delete&id=$result_produk[id_event]'><i class='feather icon-trash'></i></a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>