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
		FROM msg_inbox 
		WHERE (msg_inbox.subject LIKE '%$search%' OR msg_inbox.email LIKE '%$search%' OR msg_inbox.name LIKE '%$search%') ORDER BY msg_inbox.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT
		*
		FROM msg_inbox 	
		ORDER BY msg_inbox.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM msg_inbox");
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
		$data_produk[1] = $result_produk["name"];
		$data_produk[2] = $result_produk["email"];
		$data_produk[3] = $result_produk["message"];
		$data_produk[4] = $result_produk["created"];
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>