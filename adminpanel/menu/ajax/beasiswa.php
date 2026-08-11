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
		FROM tabel_beasiswa 
		WHERE tabel_beasiswa.title LIKE '%$search%' AND tabel_beasiswa.status = '2' ORDER BY tabel_beasiswa.id_beasiswa ASC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query(" SELECT
		*
		FROM tabel_beasiswa 	
		WHERE tabel_beasiswa.status = '2'
		ORDER BY tabel_beasiswa.id_beasiswa ASC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_beasiswa WHERE tabel_beasiswa.status = '2'");
    $data = new stdClass();
    $data->draw = $draw;
    $data->recordsTotal = mysql_num_rows($records_total);
    $data->recordsFiltered = mysql_num_rows($records_total);
    $data->data = [];
    $no = $start+1;
    while ($result_produk = mysql_fetch_array($supplier)) 
    {
		
		if($result_produk["status_daftar_aktif"] == '2'){
			$status = 'Aktif';
		}else{
			$status = 'Tidak Aktif';
		}
		
        $data_produk = [];
        $data_produk[0] = $no;
        $data_produk[1] = $result_produk["title"];
		$data_produk[2] = $result_produk["description_home"];
		$data_produk[3] = "<img src='../images/icon/$result_produk[gambar]' class='img-fluid' style='max-height: 50px; max-width: 50px;'>";
		$data_produk[4] = $result_produk["updater"];
		$data_produk[5] = $result_produk["updated"];
		$data_produk[6] = $status;
        $data_produk[7] = "<a href='?menu=beasiswa&mod=edit&id=$result_produk[id_beasiswa]'><i class='feather icon-edit'></i></a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>