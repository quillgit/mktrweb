<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fasilitas WHERE id_fasilitas = '$id'"));
			$title 				= stripslashes($edit['title']);
			$gambar 			= stripslashes($edit['gambar']);
			$title_english 		= stripslashes($edit['title_english']);
			//$id_perusahaan 		= isset($_POST['id_perusahaan']) ? $_POST['id_perusahaan']:''; 
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:'';
			$title_english 			= isset($_POST['title_english']) ? $_POST['title_english']:'';
			//$id_perusahaan 	= isset($_POST['s_id_kategori']) ? $_POST['s_id_kategori']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Gallery</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fasilitas WHERE id_fasilitas = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
										
											<!--
											<div class="col-md-12 col-12">
												<h6>Kategori</h6>
                                                <div class="form-label-group">
													<select name="s_id_kategori" class="form-control" >
														<?php
															$s = mysql_query("SELECT id_perusahaan, title FROM tabel_perusahaan");
															while( $r = mysql_fetch_array($s) ) {
																if ($_GET['mod']=='edit'){
																	if( $edit['id_perusahaan'] == $r['id_perusahaan'] ) {
																		echo "<option value=$r[id_perusahaan] selected>$r[title]</option>";
																	} else {
																		echo "<option value=$r[id_perusahaan]>$r[title]</option>";
																	}
																} else {
																	echo "<option value=$r[id_perusahaan]>$r[title]</option>";
																}
															}
														?>
													</select>
                                                </div>
                                            </div>
											-->
										
                                            <div class="col-md-12 col-12">
												<h6>Title (Bahasa)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title (Bahasa) ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Title (English)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title_english" value="<?php echo"$title_english"; ?>" placeholder="Title (English) ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Fasilitas <b>(1920px x 1080px)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar"; ?></label>
														<?php
															if (file_exists("../images/gallery/$gambar"))
															{
															echo "<p><img src='../images/gallery/$gambar' width='200' border= /></p><br>";
															
															}
														
														}else{
														?>
														<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
														<?php
														}
														?>
                                                    </div>
                                                </fieldset>
                                            </div>
											
											
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=fasilitas" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
		
		if (!empty($_GET['act']) ? $_GET['act'] : '' =='delete')
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_fasilitas WHERE id_fasilitas = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_fasilitas WHERE id_fasilitas ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/gallery/$pic"))
					{unlink("../images/gallery/$pic");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=fasilitas')</script>";
			}
			else
			{
			echo "<script>alert('Data Gagal di Delete');</script>";
			}
		}
		
	?>
		<div class="content-header row">
			<div class="content-header-left col-md-9 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h2 class="content-header-title float-left mb-0">Gallery</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Gallery</a>
								</li>
								<li class="breadcrumb-item active">Data Gallery
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
					
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new"><i class='feather icon-plus'></i> Tambah</a></h3>

				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view" id="table-product">
						<thead>
							<tr>
								<th>No</th>
								<th>Judul Bahasa</th>
								<th>Judul English</th>
								<th>Gambar</th>
								<th>Created</th>
								<th>Author</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
						
						</tbody>
					</table>
				</div>
				<!-- dataTable ends -->
				
			</section>
		</div>
		<script type="text/javascript" src="assets/js/menu/data-table-fasilitas.js"></script>
		<!-- Javascript load  -->
		
	<?php
	}
	elseif ($_GET['mod']=='new')
	{
		if (empty($_GET['act']))
		{
		
			form();
		
		}elseif ($_GET['act']=='process'){
			
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];
					
			$title 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			//$s_id_kategori  = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['s_id_kategori']));
			
			if (!empty($lokasifile)){
				
				if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
				
					$file = str_replace(" ", "-", $namafile);
					$prefix = rand(000,999);
					$nama_file_baru = $prefix.''.$file;
					move_uploaded_file($lokasifile,"../images/gallery/$nama_file_baru");
					
				}

			}else{
				$nama_file_baru = "";
			}
		
			$add = "INSERT INTO tabel_fasilitas 
			(id_perusahaan, title, gambar, title_english, status, created, author) 
			VALUES 
			('0', '$title', '$nama_file_baru', '$title_english', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
			
			$id_article = mysql_insert_id();
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=fasilitas')</script>";
			}
			else
			{
				echo "<script>alert('Data Gagal di Simpan');</script>";
				form();
			}
		}

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
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];

			$title = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			//$s_id_kategori  = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['s_id_kategori']));
			
			$update = "UPDATE tabel_fasilitas SET  title = '$title',
												title_english = '$title_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_fasilitas = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/gallery/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_fasilitas WHERE id_fasilitas = '$_POST[id]'"));
						if (!empty($gbr['gambar'])) 
						{
							if (file_exists("../images/gallery/$gbr[gambar]"))
							{unlink("../images/gallery/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_fasilitas SET gambar = '$nama_file_baru' WHERE id_fasilitas = '$_POST[id]'");	
					}
					
				}

				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=fasilitas')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

