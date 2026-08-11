<?php
	date_default_timezone_set("Asia/Bangkok");
	$date = date('Y-m-d H:i:s');

	function form_detail(){

		include "../configuration/path.php";

		$id = isset($_GET['id']) ? $_GET['id']:'';
		
		$detail = mysql_fetch_array(mysql_query("SELECT
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
			WHERE tabel_komunitas.id_komunitas = '$id'"));
	?>
		
		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detail Komunitas</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- form start -->
                                <div class="form-body">
                                    <div class="row">
										<!-- <h4 style="margin-left:12px; color:#012677">Data Komunitas</h4> -->
                                        <div class="col-md-12 col-12">
											<h6>Kategori</h6>
                                            <div class="form-label-group">
												<input type="text" class="form-control" value="<?php echo"$detail[nama_kategori]"; ?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
											<h6>Nama Komunitas</h6>
                                            <div class="form-label-group">
												<input type="text" class="form-control" value="<?php echo"$detail[title]"; ?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
											<h6>Jumlah Anggota</h6>
											<?php
											$sql_count = mysql_fetch_array(mysql_query("SELECT count(*) as total FROM trs_komunitas WHERE id_komunitas = '$id'"));
        									$dt_count = $sql_count['total'];
											?>
                                            <div class="form-label-group">
												<input type="text" class="form-control" value="<?php echo"$dt_count"; ?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
											<h6>Deskripsi</h6>
                                            <div class="form-label-group">
												<textarea class="form-control" readonly="readonly"><?php echo"$detail[description]"; ?></textarea>
                                            </div>
                                        </div>
										<div class="col-md-12 col-12">
											<h6>Gambar</h6>
                                            <div class="form-label-group">
												<img src="<?php echo "$nama_folder/images/komunitas/$detail[gambar]";?>" width="400" alt="Gambar tidak tersedia."/>
												
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <a href="admin.php?menu=komunitas" class="btn btn-outline-warning mr-1 mb-1">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	<?php
	} // FORM DETAIL



	function form_detail_request(){

		include "../configuration/path.php";

		$id = isset($_GET['id']) ? $_GET['id']:'';
		
		$detail = mysql_fetch_array(mysql_query("SELECT
			tabel_komunitas.id_komunitas, 
			tabel_komunitas.id_kategori, 
			tabel_komunitas.title, 
			tabel_komunitas.description, 
			tabel_komunitas.gambar, 
			tabel_komunitas.slug, 
			tabel_komunitas.status,
			tabel_komunitas.author,
			tabel_komunitas.created,
			tabel_komunitas_kategori.title as nama_kategori,
			tabel_pendaftaran.first_name,
			tabel_pendaftaran.last_name
			FROM tabel_komunitas
			LEFT JOIN tabel_komunitas_kategori ON tabel_komunitas.id_kategori = tabel_komunitas_kategori.id_kategori
			LEFT JOIN tabel_pendaftaran ON tabel_komunitas.author = tabel_pendaftaran.email
			WHERE tabel_komunitas.id_komunitas = '$id'"));
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Action</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- form start -->
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12 col-12">

											<a class="btn btn-primary" href="?menu=komunitas&mod=acc_request&id=<?php echo $id;?>"><i class='feather icon-check'></i> Terima </a>
    										<a class="btn btn-danger" href="?menu=komunitas&mod=reject_request&id=<?php echo $id;?>"><i class='feather icon-x'></i> Tolak </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Request - Detail Komunitas</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- form start -->
                                <div class="form-body">
                                    <div class="row">
										<!-- <h4 style="margin-left:12px; color:#012677">Data Komunitas</h4> -->
                                        <div class="col-md-12 col-12">
											<h6>Kategori</h6>
                                            <div class="form-label-group">
												<input type="text" class="form-control" value="<?php echo"$detail[nama_kategori]"; ?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
											<h6>Nama Komunitas</h6>
                                            <div class="form-label-group">
												<input type="text" class="form-control" value="<?php echo"$detail[title]"; ?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
											<h6>Request by</h6>
                                            <div class="form-label-group">
												<?php
													$pencetus = "$detail[first_name] $detail[last_name] ($detail[author])";
												?>
												<input type="text" class="form-control" value="<?php echo"$pencetus"; ?>" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
											<h6>Deskripsi</h6>
                                            <div class="form-label-group">
												<textarea class="form-control" readonly="readonly"><?php echo"$detail[description]"; ?></textarea>
                                            </div>
                                        </div>
										<div class="col-md-12 col-12">
											<h6>Gambar</h6>
                                            <div class="form-label-group">
												<img src="<?php echo "$nama_folder/images/komunitas/$detail[gambar]";?>" width="400" alt="Gambar tidak tersedia."/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <a href="admin.php?menu=komunitas" class="btn btn-outline-warning mr-1 mb-1">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	<?php
	} // FORM DETAIL REQUEST


	if (empty($_GET['mod']))
	{
	?>
		<div class="content-header row">
			<div class="content-header-left col-md-9 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h2 class="content-header-title float-left mb-0">Komunitas</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item active">Data Komunitas
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<!-- Data list view starts -->
			<section id="data-thumb-view" class="data-thumb-view-header">
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new"><i class='fa fa-hand-pointer-o'></i> Request Komunitas Baru</a></h3>
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view-request" id="table-product-request">
						<thead>
							<tr>
								<th>No</th>
								<th>Kategori</th>
								<th>Nama Komunitas</th>
								<th>Gambar</th>
								<th>Request by</th>
								<th>Created</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="product-list">
						
						</tbody>
					</table>
				</div>
				<!-- dataTable ends -->
				
			</section>
		</div>
		<script type="text/javascript" src="assets/js/menu/data-table-komunitas-request.js"></script>
		<!-- Javascript load  -->

		<div class="content-body mt-2">
			<!-- Data list view starts -->
			<section id="data-thumb-view" class="data-thumb-view-header">
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new"><i class='fa fa-list'></i> Data Komunitas</a></h3>
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view" id="table-product">
						<thead>
							<tr>
								<th>No</th>
								<th>Kategori</th>
								<th>Nama Komunitas</th>
								<th>Jumlah Anggota</th>
								<th>Gambar</th>
								<th>Created</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="product-list">
						</tbody>
					</table>
				</div>
				<!-- dataTable ends -->
				
			</section>
		</div>
		<script type="text/javascript" src="assets/js/menu/data-table-komunitas.js"></script>
		<!-- Javascript load  -->
		
	<?php
	}
	elseif ($_GET['mod']=='detail')
	{
		if (empty($_GET['act']))
		{
			form_detail();
		}
	}
	elseif ($_GET['mod']=='detail_request')
	{
		if (empty($_GET['act']))
		{
			form_detail_request();
		}
	}
	elseif ($_GET['mod']=='delete')
	{
	    $sql = "UPDATE `tabel_komunitas` SET `deleted_at` = '$date', status = '0' WHERE id_komunitas = '$_GET[id]' ";
	    $ins = mysql_query($sql);
        echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=komunitas')</script>";
	}
	elseif ($_GET['mod']=='acc_request')
	{
	    $sql = "UPDATE `tabel_komunitas` SET `updated` = '$date', status = '2' WHERE id_komunitas = '$_GET[id]' ";
	    $ins = mysql_query($sql);
        echo "<script>alert('Data Komunitas Berhasil Diterima');window.location=('admin.php?menu=komunitas')</script>";
	}
	elseif ($_GET['mod']=='reject_request')
	{
	    $sql = "UPDATE `tabel_komunitas` SET `updated` = '$date', status = '3' WHERE id_komunitas = '$_GET[id]' ";
	    $ins = mysql_query($sql);
        echo "<script>alert('Data Komunitas Ditolak');window.location=('admin.php?menu=komunitas')</script>";
	}
		
	?>