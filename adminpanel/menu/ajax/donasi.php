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
		tabel_donasi.created,
		tabel_donasi.title,
		tabel_donasi.gambar,
		tabel_donasi.author,
		tabel_donasi.meta_keyword,
		tabel_donasi.meta_description,
		tabel_donasi.nominal_donasi,
		tabel_donasi.sumber_donasi,
		tabel_donasi.gambar_sumber_donasi,
		tabel_donasi.link,
		tabel_donasi.id_donasi
		FROM tabel_donasi 
		WHERE (tabel_donasi.title LIKE '%$search%' OR tabel_donasi.sumber_donasi LIKE '%$search%') AND tabel_donasi.status = '2'ORDER BY tabel_donasi.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query(" SELECT
		tabel_donasi.created,
		tabel_donasi.title,
		tabel_donasi.gambar,
		tabel_donasi.author,
		tabel_donasi.meta_keyword,
		tabel_donasi.meta_description,
		tabel_donasi.nominal_donasi,
		tabel_donasi.sumber_donasi,
		tabel_donasi.gambar_sumber_donasi,
		tabel_donasi.link,
		tabel_donasi.id_donasi
		FROM tabel_donasi 	
		WHERE tabel_donasi.status = '2'
		ORDER BY tabel_donasi.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_donasi WHERE tabel_donasi.status = '2'");
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
        $data_produk[2] = "<img src='../images/post/$result_produk[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'>";
		$data_produk[3] = "Rp. ".$result_produk["nominal_donasi"];
		$data_produk[4] = $result_produk["sumber_donasi"];
		$data_produk[5] = "<img src='../images/post/$result_produk[gambar_sumber_donasi]' class='img-fluid' style='max-height: 100px; max-width: 100px;'>";
		$data_produk[6] = $result_produk["created"];
		$data_produk[7] = $result_produk["author"];
        $data_produk[8] = "<a href='?menu=donasi&mod=edit&id=$result_produk[id_donasi]'><i class='feather icon-edit'></i></a> <a href='?menu=donasi&&act=delete&id=$result_produk[id_donasi]'><i class='feather icon-trash'></i></a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>