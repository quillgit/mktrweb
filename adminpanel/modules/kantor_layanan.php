<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_kantor_layanan WHERE id_kantor_layanan = '$id'"));
			$title 				= stripslashes($edit['title']);
			$title_english 		= stripslashes($edit['title_english']);
			$link_bahasa 		= stripslashes($edit['link_bahasa']);
			$link_english 		= stripslashes($edit['link_english']);
			$gambar 			= stripslashes($edit['gambar']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$title_english 		= isset($_POST['title']) ? $_POST['title_english']:''; 
			$link_bahasa 		= isset($_POST['link_bahasa']) ? $_POST['link_bahasa']:''; 
			$link_english 		= isset($_POST['link_english']) ? $_POST['link_english']:''; 
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Kantor Layanan</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_kantor_layanan WHERE id_kantor_layanan = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title Bahasa ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Link Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="link_bahasa" value="<?php echo"$link_bahasa"; ?>" placeholder="Link Bahasa ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<hr class="english">
											</div>
											
											<div class="col-md-12 col-12">
												<h6>Title English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title_english" value="<?php echo"$title_english"; ?>" placeholder="Title English ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Link English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="link_english" value="<?php echo"$link_english"; ?>" placeholder="Link English ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Icon</h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar"; ?></label>
														<?php
															if (file_exists("../images/icon/$gambar"))
															{
															echo "<p><img src='../images/icon/$gambar' width='200' border= /></p><br>";
															
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
                                                <a href="admin.php?menu=kantor_layanan" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_kantor_layanan WHERE id_kantor_layanan = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_kantor_layanan WHERE id_kantor_layanan ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/icon/$pic"))
					{unlink("../images/icon/$pic");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=kantor_layanan')</script>";
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
						<h2 class="content-header-title float-left mb-0">Kantor Layanan</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Kantor & Layanan</a>
								</li>
								<li class="breadcrumb-item active">Data Kantor Layanan
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
								<th>Link Bahasa</th>
								<th>Judul English</th>
								<th>Link Bahasa</th>
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
		<script type="text/javascript" src="assets/js/menu/data-table-kantor-layanan.js"></script>
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
			$title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$link_bahasa 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link_bahasa']));
			$link_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link_english']));
			
			if (!empty($lokasifile)){
				
				if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
				
					$file = str_replace(" ", "-", $namafile);
					$prefix = rand(000,999);
					$nama_file_baru = $prefix.''.$file;
					move_uploaded_file($lokasifile,"../images/icon/$nama_file_baru");
					
				}

			}else{
				$nama_file_baru = "";
			}
		
			$add = "INSERT INTO tabel_kantor_layanan 
			(title, title_english, link_bahasa, link_english, gambar, status, created, author) 
			VALUES 
			('$title', '$title_english', '$link_bahasa', '$link_english', '$nama_file_baru', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
			
			$id_article = mysql_insert_id();
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=kantor_layanan')</script>";
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

			$title 				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$link_bahasa 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link_bahasa']));
			$link_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link_english']));
			
			$update = "UPDATE tabel_kantor_layanan SET  title = '$title',
												title_english = '$title_english',
												link_bahasa = '$link_bahasa',
												link_english = '$link_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_kantor_layanan = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/icon/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_kantor_layanan WHERE id_kantor_layanan = '$_POST[id]'"));
						if (!empty($gbr['gambar'])) 
						{
							if (file_exists("../images/icon/$gbr[gambar]"))
							{unlink("../images/icon/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_kantor_layanan SET gambar = '$nama_file_baru' WHERE id_kantor_layanan = '$_POST[id]'");	
					}
					
				}

				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=kantor_layanan')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

