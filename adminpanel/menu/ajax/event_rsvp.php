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
            trs_rsvp_event.id_member, 
            trs_rsvp_event.id_event, 
    		tabel_event.title,
    		tabel_event.status,
    		tabel_event.created,
    		tabel_pendaftaran.first_name,
    		tabel_pendaftaran.last_name,
    		tabel_pendaftaran.email
    		FROM trs_rsvp_event 
    		LEFT JOIN tabel_event ON trs_rsvp_event.id_event = tabel_event.id_event
    		LEFT JOIN tabel_pendaftaran ON trs_rsvp_event.id_member = tabel_pendaftaran.id_pendaftaran
    		WHERE (tabel_event.title LIKE '%$search%') AND tabel_event.status = '2' ORDER BY tabel_event.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT 
		    trs_rsvp_event.id_member, 
            trs_rsvp_event.id_event, 
    		tabel_event.title,
    		tabel_event.status,
    		tabel_event.created,
    		tabel_pendaftaran.first_name,
    		tabel_pendaftaran.last_name,
    		tabel_pendaftaran.email
    		FROM trs_rsvp_event 
    		LEFT JOIN tabel_event ON trs_rsvp_event.id_event = tabel_event.id_event
    		LEFT JOIN tabel_pendaftaran ON trs_rsvp_event.id_member = tabel_pendaftaran.id_pendaftaran
		WHERE tabel_event.status = '2'
		ORDER BY tabel_event.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT
            trs_rsvp_event.id_member, 
            trs_rsvp_event.id_event, 
    		tabel_event.title,
    		tabel_event.status,
    		tabel_event.created,
    		tabel_pendaftaran.first_name,
    		tabel_pendaftaran.last_name,
    		tabel_pendaftaran.email
    		FROM trs_rsvp_event 
    		LEFT JOIN tabel_event ON trs_rsvp_event.id_event = tabel_event.id_event
    		LEFT JOIN tabel_pendaftaran ON trs_rsvp_event.id_member = tabel_pendaftaran.id_pendaftaran
        WHERE tabel_event.status = '2'");
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
		$data_produk[2] = $result_produk["first_name"]." ".$result_produk["last_name"];
		$data_produk[3] = $result_produk["email"];
		$data_produk[4] = $result_produk["created"];
        // $data_produk[6] = "<a href='?menu=event&mod=edit&id=$result_produk[id_event]'><i class='feather icon-edit'></i></a> <a href='?menu=event&act=delete&id=$result_produk[id_event]'><i class='feather icon-trash'></i></a>";
		
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>