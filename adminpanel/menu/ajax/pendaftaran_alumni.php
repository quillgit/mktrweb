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
    $filterType = $_GET["filterType"];
    $filterTahun = $_GET["filterTahun"];
    
    function cekNullable($datas) {
        if ($datas == '' || $datas == null || empty($datas)) {
            $dispData = '-';
        }
        else {
            $dispData = $datas;
        }
        return $dispData;
    
    }

    if ($filterType == 'tk') {
        if ($filterTahun == '' || empty($filterTahun)) {
            $validFilter = "tabel_pendaftaran.tahun_tk <> '0' ";
        }
        else {
            $validFilter = "tabel_pendaftaran.tahun_tk = '$filterTahun' ";
        }
    } else if ($filterType == 'sd') {
        if ($filterTahun == '' || empty($filterTahun)) {
            $validFilter = "tabel_pendaftaran.tahun_sd <> '0' ";
        }
        else {
            $validFilter = "tabel_pendaftaran.tahun_sd = '$filterTahun' ";
        }
    } else if ($filterType == 'smp') {
        if ($filterTahun == '' || empty($filterTahun)) {
            $validFilter = "tabel_pendaftaran.tahun_smp <> '0' ";
        }
        else {
            $validFilter = "tabel_pendaftaran.tahun_smp = '$filterTahun' ";
        }
    } else if ($filterType == 'goldar') {
        if ($filterTahun == '' || empty($filterTahun)) {
            $validFilter = "tabel_pendaftaran.gol_darah <> '0' ";
        }
        else {
            $validFilter = "tabel_pendaftaran.gol_darah = '$filterTahun' ";
        }
    }
    else {
        // ALL DATA
        $validFilter = 1;
    }

    if(isset($search)) {
        $supplier = mysql_query("SELECT 
		*
		FROM tabel_pendaftaran
		WHERE (tabel_pendaftaran.first_name LIKE '%$search%' OR tabel_pendaftaran.last_name LIKE '%$search%') AND $validFilter
        ORDER BY tabel_pendaftaran.created DESC LIMIT $length OFFSET $start");
    } else {
        $supplier = mysql_query("SELECT 
		*
		FROM tabel_pendaftaran 	
		WHERE $validFilter
		ORDER BY tabel_pendaftaran.created DESC LIMIT $length OFFSET $start");
    }
    
    $records_total = mysql_query("SELECT * FROM tabel_pendaftaran WHERE $validFilter");
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
        $data_produk[1] = cekNullable($result_produk["tahun_tk"]);
        $data_produk[2] = cekNullable($result_produk["tahun_sd"]);
        $data_produk[3] = cekNullable($result_produk["tahun_smp"]);
        $data_produk[4] = cekNullable($result_produk["first_name"]);
        $data_produk[5] = cekNullable($result_produk["mid_name"]);
        $data_produk[6] = cekNullable($result_produk["last_name"]);
        $data_produk[7] = cekNullable($result_produk["nick_name"]);
        $data_produk[8] = $result_produk["jk"];
        $data_produk[9] = $result_produk["gol_darah"];
        $data_produk[10] = cekNullable($result_produk["tmp_lahir"]);
        $data_produk[11] = $result_produk["tgl_lahir"];
        $data_produk[12] = $result_produk["hobby"];
        $data_produk[13] = $result_produk["pekerjaan"];
        $data_produk[14] = $result_produk["handphone"];
        $data_produk[15] = cekNullable($result_produk["alamat_domisili"]);
        $data_produk[16] = "<img src='$nama_folder/images/profile/$result_produk[gambar_profile]' class='img-fluid' style='max-height: 100px; max-width: 80px;'>";;
        $data_produk[17] = $result_produk["email"];

        $dt_status = $result_produk["status"];
        if ( $dt_status == '1') {
            $view_stat = "<span class=\"badge badge-secondary \"><i class='fa fa-hourglass'></i> PENDING</span>";
        } else if ( $dt_status == '2') {
            $view_stat = "<span class=\"badge badge-success\"><i class='fa fa-check'></i> ACCEPTED</span>";
        } else if ( $dt_status == '0') {
            $view_stat = "<span class=\"badge badge-danger\"><i class='fa fa-times'></i> REJECTED</span>";
        }
        
		$data_produk[18] = $view_stat;
        $data_produk[19] = "<a href='?menu=pendaftaran_alumni&mod=detail&id=$result_produk[id_pendaftaran]' class='btn btn-info'> Detail</a>";

        $data->data[] = $data_produk;
        $no+=1;
    }
    echo json_encode($data);
} else {
    echo "Not Found";
}
?>