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
		FROM tabel_perusahaan 
		WHERE title LIKE '%$search%' OR sub_title LIKE '%$search%'ORDER BY id_perusahaan ASC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT 
		*
		FROM tabel_perusahaan 	
		ORDER BY tabel_perusahaan.updated DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_perusahaan");
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
		$data_produk[2] = $result_produk["sub_title"];
		$data_produk[3] = "<img src='../images/about/$result_produk[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'>";
		$data_produk[4] = $result_produk["updater"];
        $data_produk[5] = "<a href='?menu=perusahaan&mod=edit&id=$result_produk[id_perusahaan]'><i class='feather icon-edit'></i></a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>