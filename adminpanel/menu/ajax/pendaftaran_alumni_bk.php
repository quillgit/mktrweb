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
		FROM tabel_pendaftaran
		WHERE (tabel_pendaftaran.first_name LIKE '%$search%' OR tabel_pendaftaran.last_name LIKE '%$search%') ORDER BY tabel_pendaftaran.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT 
		*
		FROM tabel_pendaftaran 	
		WHERE 1
		ORDER BY tabel_pendaftaran.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_pendaftaran ");
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
        $data_produk[1] = $result_produk["first_name"];
        $data_produk[2] = $result_produk["mid_name"];
        $data_produk[3] = $result_produk["last_name"];
        $data_produk[4] = $result_produk["tahun_tk"];
        $data_produk[5] = $result_produk["tahun_sd"];
        $data_produk[6] = $result_produk["tahun_smp"];
        $data_produk[7] = $result_produk["email"];
        
        $dt_status = $result_produk["status"];
        if ( $dt_status == '1') {
            $view_stat = "<span class=\"badge badge-secondary p-1\"><i class='fa fa-hourglass'></i> PENDING</span>";
        } else if ( $dt_status == '2') {
            $view_stat = "<span class=\"badge badge-success p-1\"><i class='fa fa-check'></i> ACCEPTED</span>";
        }
        
		$data_produk[8] = $view_stat;
        // $data_produk[9] = "<a href='?menu=pendaftaran_alumni&mod=edit&id=$result_produk[id_pendaftaran]'><i class='feather icon-edit'></i></a> <a href='?menu=pendaftaran_alumni&act=delete&id=$result_produk[id_pendaftaran]'><i class='feather icon-trash'></i></a>";
		
		$data_produk[9] = "<div class=\"dropup\">
                <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                    Action
                </button>
                <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
                    <a class=\"dropdown-item\" href=\"?menu=pendaftaran_alumni&mod=acc_member&id=$result_produk[id_pendaftaran]\"><i class='fa fa-check'></i> Accept</a>
                </div>
            </div>";
		
        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>