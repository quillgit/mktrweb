<?php

include "../../parser-php-version.php"; //Konversi dan migrasi PHP version
include "../../configuration/connection.php";
include "../../configuration/function.php";
include "../../configuration/path.php";
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
		tabel_komunitas.id_komunitas, 
		tabel_komunitas.id_kategori, 
		tabel_komunitas.title, 
		tabel_komunitas.description, 
		tabel_komunitas.gambar, 
		tabel_komunitas.slug, 
		tabel_komunitas.status,
		tabel_komunitas.author,
		tabel_komunitas.created,
		tabel_komunitas_kategori.title as nama_kategori
		FROM tabel_komunitas 
		LEFT JOIN tabel_komunitas_kategori ON tabel_komunitas.id_kategori = tabel_komunitas_kategori.id_kategori
		WHERE (tabel_komunitas.title LIKE '%$search%' OR tabel_komunitas.description LIKE '%$search%') AND tabel_komunitas.status = '1' 
		ORDER BY tabel_komunitas.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT
		tabel_komunitas.id_komunitas, 
		tabel_komunitas.id_kategori, 
		tabel_komunitas.title, 
		tabel_komunitas.description, 
		tabel_komunitas.gambar, 
		tabel_komunitas.slug, 
		tabel_komunitas.status,
		tabel_komunitas.author,
		tabel_komunitas.created,
		tabel_komunitas_kategori.title as nama_kategori
		FROM tabel_komunitas 
		LEFT JOIN tabel_komunitas_kategori ON tabel_komunitas.id_kategori = tabel_komunitas_kategori.id_kategori
		WHERE tabel_komunitas.status = '1'
		ORDER BY tabel_komunitas.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_komunitas WHERE status = '1'");
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
        $data_produk[1] = $result_produk["nama_kategori"];
        $data_produk[2] = $result_produk["title"];
		$data_produk[3] = "<img src='$nama_folder/images/komunitas/$result_produk[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'>";
		$data_produk[4] = $result_produk["author"];
		$data_produk[5] = $result_produk["created"];
        $data_produk[6] = "<a href='?menu=komunitas&mod=detail_request&id=$result_produk[id_komunitas]' class='btn btn-info'><i class='feather icon-check'></i> Review</a>";
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>