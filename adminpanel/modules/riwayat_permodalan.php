<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit 					= mysql_fetch_array(mysql_query("SELECT * FROM tabel_pemegang_saham WHERE id_pemegang_saham = '$id'"));
			$title 					= stripslashes($edit['title']);
			$sub_title 				= stripslashes($edit['sub_title']);
			$description 			= stripslashes($edit['description']);
			$sub_title_english 		= stripslashes($edit['sub_title_english']);
			$description_english 	= stripslashes($edit['description_english']);
			$from = 'edit';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$title 					= isset($_POST['title']) ? $_POST['title']:''; 
			$sub_title 				= isset($_POST['sub_title']) ? $_POST['sub_title']:''; 
			$description 			= isset($_POST['description']) ? $_POST['description']:''; 
			$sub_title_english 		= isset($_POST['sub_title_english']) ? $_POST['sub_title_english']:''; 
			$description_english 	= isset($_POST['description_english']) ? $_POST['description_english']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Riwayat Permodalan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- form start -->
								<form action="?menu=<?php echo"$_GET[menu]"; ?>&mod=<?php echo"$_GET[mod]"; 
								if ($_GET['mod']=='edit') echo "&id=$id"; ?>&act=process" method="post" enctype="multipart/form-data">
								<?php
								if ($_GET['mod']=='edit')
								{
								$id = abs((int)$_GET['id']);
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_pemegang_saham WHERE id_pemegang_saham = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title ..." readonly="readonly"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Sub Title (Bahasa)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="sub_title" value="<?php echo"$sub_title"; ?>" placeholder="Sub Title ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Description (Bahasa)</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="description" placeholder="Description ..."><?php echo"$description"; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<hr class="english">
											</div>
											
											<div class="col-md-12 col-12">
												<h6>Sub Title (English)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="sub_title_english" value="<?php echo"$sub_title_english"; ?>" placeholder="Sub Title ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Description (English)</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="description_english" placeholder="Description ..."><?php echo"$description_english"; ?></textarea>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=riwayat_permodalan" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	<?php
	}

	
	function form_2(){

		if 	(($_GET['mod']=='edit_dokumen'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_riwayat_permodalan WHERE id_riwayat_permodalan = '$id'"));
			$keterangan 			= stripslashes($edit['keterangan']);
			$keterangan_english 	= stripslashes($edit['keterangan_english']);
			$jumlah_saham 			= stripslashes($edit['jumlah_saham']);
			$nilai_nominal 			= stripslashes($edit['nilai_nominal']);
			$jumlah_nilai 			= stripslashes($edit['jumlah_nilai']);
			$laporan_date 			= stripslashes($edit['laporan_date']);
			$from = 'edit_dokumen';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$keterangan 			= isset($_POST['keterangan']) ? $_POST['keterangan']:''; 
			$keterangan_english 	= isset($_POST['keterangan_english']) ? $_POST['keterangan_english']:'';
			$jumlah_saham 			= isset($_POST['jumlah_saham']) ? $_POST['jumlah_saham']:''; 
			$nilai_nominal 			= isset($_POST['nilai_nominal']) ? $_POST['nilai_nominal']:''; 
			$jumlah_nilai 			= isset($_POST['jumlah_nilai']) ? $_POST['jumlah_nilai']:''; 
			$laporan_date 			= isset($_POST['laporan_date']) ? $_POST['laporan_date']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detail Riwayat Permodalan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- form start -->
								<form action="?menu=<?php echo"$_GET[menu]"; ?>&mod=<?php echo"$_GET[mod]"; 
								if ($_GET['mod']=='edit_dokumen') echo "&id=$id"; ?>&act=process" method="post" enctype="multipart/form-data">
								<?php
								if ($_GET['mod']=='edit_dokumen')
								{
								$id = abs((int)$_GET['id']);
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_riwayat_permodalan WHERE id_riwayat_permodalan = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
											
											<div class="col-md-12 col-12">
												<h6>Laporan Date</h6>
                                                <div class="form-label-group">
													<input type="date" class="form-control" name="laporan_date" value="<?php echo"$laporan_date"; ?>" placeholder="Laporan Date ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Jumlah Saham</h6>
                                                <div class="form-label-group">
													<input type="number" class="form-control" name="jumlah_saham" value="<?php echo"$jumlah_saham"; ?>" placeholder="Jumlah Saham ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Nilai Nominal</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="nilai_nominal" value="<?php echo"$nilai_nominal"; ?>" placeholder="Nilai Nominal ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Jumlah Nilai</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="jumlah_nilai" value="<?php echo"$jumlah_nilai"; ?>" placeholder="Jumlah Nilai ..."/>
                                                </div>
                                            </div>
										
                                            <div class="col-md-12 col-12">
												<h6>Keterangan Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="keterangan" value="<?php echo"$keterangan"; ?>" placeholder="Keterangan Bahasa ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Keterangan English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="keterangan_english" value="<?php echo"$keterangan_english"; ?>" placeholder="Keterangan English ..."/>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=riwayat_permodalan" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	<?php
	}


	if (empty($_GET['mod']))
	{
		
		
	?>
		<div class="content-header row">
			<div class="content-header-left col-md-9 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h2 class="content-header-title float-left mb-0">Riwayat Permodalan</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Informasi Pemegang Saham</a>
								</li>
								<li class="breadcrumb-item active">Data Riwayat Permodalan
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
					
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view" id="table-product">
						<thead>
							<tr>
								<th>No</th>
								<th>Judul</th>
								<th>Judul English</th>
								<th>Updated</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_pemegang_saham where id_pemegang_saham = '2'");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[sub_title]</td>
								<td>$list[sub_title_english]</td>
								<td>$list[updated]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit&id=$list[id_pemegang_saham]'><img src=img/edit.png border=0 /></a> ";
							?>
								</td>
							</tr>
							<?php
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
				<!-- dataTable ends -->
				
			</section>
		</div>
		
		<div class="content-header row">
			<div class="content-header-left col-md-9 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h2 class="content-header-title float-left mb-0">Detail</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<!-- Data list view starts -->
			<section id="data-thumb-view" class="data-thumb-view-header">
					
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new"><i class='feather icon-plus'></i> Tambah Tabel</a></h3>	
					
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view" id="table-product">
						<thead>
							<tr>
								<th>No</th>
								<th>Bulan Tahun</th>
								<th>Jumlah Saham</th>
								<th>Nilai Nominal (Rp)</th>
								<th>Jumlah Nilai (Rp)</th>
								<th>Keterangan</th>
								<th>Created</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_riwayat_permodalan ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>".BulanTahunIndo($list['laporan_date'])."</td>
								<td>".number_format($list['jumlah_saham'])."</td>
								<td>".number_format($list['nilai_nominal'])."</td>
								<td>".number_format($list['jumlah_nilai'])."</td>
								<td>$list[keterangan]</td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit_dokumen&id=$list[id_riwayat_permodalan]'><img src=img/edit.png border=0 /></a> ";
							?>
								<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_riwayat_permodalan]"; ?>" 
											onClick="return confirm('Delete : <?php echo "$list[title]"; ?>?')"><img src="img/delete.png"/>
											</a>
								</td>
							</tr>
							<?php
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
				<!-- dataTable ends -->
				
			</section>
		</div>
		
		<script src="app-assets/js/scripts/ui/data-list-view-no-add.js"></script>
		<!-- Javascript load  -->
		
	<?php
	}
	elseif ($_GET['mod']=='edit')
	{
		if (empty($_GET['act']))
		{
			form();
		}
		elseif ($_GET['act']=='process')
		{
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
			
			//$lokasifile = $_FILES['gambar']['tmp_name'];
			//$namafile   = $_FILES['gambar']['name'];
			//$jenis_gambar = $_FILES['gambar']['type'];
		
			$title   				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$sub_title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$description 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			$sub_title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title_english']));
			$description_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description_english']));
			
			
			$update = "UPDATE tabel_pemegang_saham SET  title = '$title',
													sub_title = '$sub_title',
													description = '$description',
													sub_title_english = '$sub_title_english',
													description_english = '$description_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_pemegang_saham = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				/*
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/about/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_pemegang_saham WHERE id_pemegang_saham = '$_POST[id]'"));
						if (!empty($gbr['gambar']))  
						{
							if (file_exists("../images/about/$gbr[gambar]"))
							{unlink("../images/about/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_pemegang_saham SET gambar = '$nama_file_baru' WHERE id_pemegang_saham = '$_POST[id]'");	
					}
					
				}
				*/
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=riwayat_permodalan')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	elseif ($_GET['mod']=='new')
	{
		if (empty($_GET['act']))
		{
		
			form_2();
		
		}elseif ($_GET['act']=='process'){
			
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
								
			$keterangan 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['keterangan']));
			$keterangan_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['keterangan_english']));
			$jumlah_saham 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['jumlah_saham']));
			$nilai_nominal 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['nilai_nominal']));
			$jumlah_nilai 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['jumlah_nilai']));
			
			$laporan_date 			= mysql_real_escape_string($_POST['laporan_date']);
			$newlaporan_date 		= date("Y-m-d", strtotime($laporan_date));
			
			$add = "INSERT INTO tabel_riwayat_permodalan 
			(keterangan, keterangan_english, jumlah_saham, nilai_nominal, jumlah_nilai, laporan_date, status, created, author) 
			VALUES 
			('$keterangan', '$keterangan_english', '$jumlah_saham', '$nilai_nominal', '$jumlah_nilai', '$newlaporan_date', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=riwayat_permodalan')</script>";
			}
			else
			{
				echo "<script>alert('Data Gagal di Simpan');</script>";
				form_2();
			}
		}

	}
	elseif ($_GET['mod']=='edit_dokumen')
	{
		if (empty($_GET['act']))
		{
			form_2();
		}
		elseif ($_GET['act']=='process')
		{
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
			
			$keterangan 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['keterangan']));
			$keterangan_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['keterangan_english']));
			$jumlah_saham 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['jumlah_saham']));
			$nilai_nominal 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['nilai_nominal']));
			$jumlah_nilai 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['jumlah_nilai']));
			
			$laporan_date 		= mysql_real_escape_string($_POST['laporan_date']);
			$newlaporan_date 	= date("Y-m-d", strtotime($laporan_date));
			
			$update = "UPDATE tabel_riwayat_permodalan SET  keterangan = '$keterangan',
													keterangan_english = '$keterangan_english',
													jumlah_saham = '$jumlah_saham',
													nilai_nominal = '$nilai_nominal',
													jumlah_nilai = '$jumlah_nilai',
													laporan_date = '$newlaporan_date',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_riwayat_permodalan = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=riwayat_permodalan')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form_2();
			}
		}
	}
	?>

