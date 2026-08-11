<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_gallery_kategori WHERE id_kategori = '$id'"));
			$title 				= stripslashes($edit['title']);	
			$description 		= stripslashes($edit['description']);
			//$gambar 			= stripslashes($edit['gambar']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; ; 
			$description 		= isset($_POST['description']) ? $_POST['description']:''; 
			//$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:'';
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_gallery_kategori WHERE id_kategori = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Nama Album</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Nama Album ..." required="required"/>
                                                </div>
                                            </div>
											
											
											<div class="col-md-12 col-12">
												<h6>Description</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="description" placeholder="Description ..."><?php echo"$description"; ?></textarea>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=gallery" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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

	
	function form_detail(){

		$id = isset($_GET['id']) ? $_GET['id']:'';
		
		$cek_campaign = mysql_fetch_array(mysql_query("SELECT title FROM tabel_gallery_kategori WHERE id_kategori = '$id'"));
		
	?>

		<div class="content-header row">
			<div class="content-header-left col-md-9 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h2 class="content-header-title float-left mb-0">Gallery | <?php echo "$cek_campaign[title]";?></h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=gallery">Kembali</a>
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
				
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new_gambar&id_kategori=<?php echo "$id"; ?>"><i class='feather icon-plus'></i> Tambah</a></h3>
				
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Foto</th>
							<th>Created</th>
							<th>Updated</th>
							<th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					$no = 1;
					$supplier = mysql_query("SELECT 
					id_gallery,
					id_kategori,
					title,
					gambar,
					created,
					updated
					FROM 
					tabel_gallery
					WHERE id_kategori = '$id'
					ORDER BY created DESC
					");
					while ($list = mysql_fetch_array($supplier)){
					echo "
                        <tr>
                            <td>$no</td>
                            <td>$list[title]</td>
                            <td><img src='../images/post/$list[gambar]' class='img-fluid' style='max-height: 50px; max-width: 50px;'></td>
                            <td>$list[created]</td>
							<td>$list[updated]</td>
							<td><a href='?menu=gallery&mod=edit_gambar&id=$list[id_gallery]&id_kategori=$list[id_kategori]'><i class='feather icon-edit'></i></a> <a href='?menu=gallery&mod=delete_gambar&actd=delete&id=$list[id_gallery]&id_kategori=$list[id_kategori]'><i class='feather icon-trash'></i></a></td>
                        </tr>
					";
						$no++;
					}
					?>
                    </tbody>
                </table>
				</div>
				<!-- dataTable ends -->
				
			</section>
			
			<script src="app-assets/js/scripts/ui/data-list-view.js"></script>
		</div>
		<!-- Javascript load  -->
	<?php
	}
	
	function form_detail_action(){
		
		$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori']:'';
		
		$cek_kategori = mysql_fetch_array(mysql_query("SELECT title FROM tabel_gallery_kategori WHERE id_kategori = '$id_kategori'"));

		if 	(($_GET['mod']=='edit_gambar'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_gallery WHERE id_gallery = '$id'"));
			$title 				= stripslashes($edit['title']);	
			$gambar 			= stripslashes($edit['gambar']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; ; 
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Gallery | <?php echo "$cek_kategori[title]";?></h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- form start -->
								<form action="?menu=<?php echo"$_GET[menu]"; ?>&mod=<?php echo"$_GET[mod]"; 
								if ($_GET['mod']=='edit_gambar') echo "&id=$id&id_kategori=$id_kategori"; ?>&act=process" method="post" enctype="multipart/form-data">
								<?php
								if ($_GET['mod']=='edit')
								{
								$id = abs((int)$_GET['id']);
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_gallery WHERE id_kategori = '$id_kategori'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
									<input type="hidden" name="id_kategori" value="<?php echo"$id_kategori"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Gambar <b>(700px x 500px)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit_gambar'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar"; ?></label>
														<?php
															if (file_exists("../images/post/$gambar"))
															{
															echo "<p><img src='../images/post/$gambar' width='200' border= /></p><br>";
															
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
                                                <a href="admin.php?menu=gallery" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_gallery_kategori WHERE id_kategori = '$id'"));
			//$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_gallery_kategori WHERE id_kategori ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				
				$delete_gallery = "DELETE FROM tabel_gallery WHERE id_kategori ='$id'";				 
				$query_deletegallery = mysql_query($delete_gallery);
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=gallery')</script>";
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
								<li class="breadcrumb-item active">Gallery
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
								<th>Nama Album</th>
								<th>Deksripsi</th>
								<th>Created</th>
								<th>Author</th>
								<th>ACTION</th>
								<th>TAMBAH GAMBAR</th>
							</tr>
						</thead>
						<tbody id="product-list">
						
						</tbody>
					</table>
				</div>
				<!-- dataTable ends -->
				
			</section>
		</div>
		<script type="text/javascript" src="assets/js/menu/data-table-gallery.js"></script>
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
					
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$description 	 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			$slug = slug($title);

			$add = "INSERT INTO tabel_gallery_kategori 
			(title, description, slug, created, author, status) 
			VALUES 
			('$title', '$description', '$slug', '$date', '$_SESSION[namauser]', '2')";
						
			$query = mysql_query($add);
			
			$id_article = mysql_insert_id();
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=gallery&mod=detail&id=$id_article')</script>";
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
			
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$description 	 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			$slug 				= slug($title);
			
			$update = "UPDATE tabel_gallery_kategori SET title = '$title',
												slug = '$slug',
												description = '$description',
												 updated = '$date',
												  status = '2',
												 updater = '$_SESSION[namauser]'
												WHERE id_kategori = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=gallery')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	elseif ($_GET['mod']=='detail')
	{
		if (empty($_GET['act']))
		{
			form_detail();
		}
	}
	elseif ($_GET['mod']=='new_gambar')
	{
		if (empty($_GET['act']))
		{
		
			form_detail_action();
		
		}elseif ($_GET['act']=='process'){
			
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
					
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$slug = slug($title);
			
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];
			
			if (!empty($lokasifile)){
				
				if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
				
					$file = str_replace(" ", "-", $namafile);
					$prefix = rand(000,999);
					$nama_file_baru = $prefix.''.$file;
					move_uploaded_file($lokasifile,"../images/post/$nama_file_baru");
					
				}

			}else{
				$nama_file_baru = "";
			}

			$add = "INSERT INTO tabel_gallery 
			(id_kategori, title, gambar, slug, created, author, status) 
			VALUES 
			('$_POST[id_kategori]', '$title', '$nama_file_baru', '$slug', '$date', '$_SESSION[namauser]', '2')";
						
			$query = mysql_query($add);
			
			$id_article = mysql_insert_id();
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=gallery&mod=detail&id=$_POST[id_kategori]')</script>";
			}
			else
			{
				echo "<script>alert('Data Gagal di Simpan');</script>";
				form_detail_action();
			}
		}

	}
	elseif ($_GET['mod']=='edit_gambar')
	{
		if (empty($_GET['act']))
		{
			form_detail_action();
		}
		elseif ($_GET['act']=='process')
		{
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
			
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];
			
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$slug 				= slug($title);
			
			$update = "UPDATE tabel_gallery SET title = '$title',
												slug = '$slug',
												 updated = '$date',
												  status = '2',
												 updater = '$_SESSION[namauser]'
												WHERE id_gallery = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/post/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT gambar FROM tabel_gallery WHERE id_gallery = '$_POST[id]'"));
						
						if (!empty($gbr['gambar'])) 
						{
							if (file_exists("../images/post/$gbr[gambar]"))
							{unlink("../images/post/$gbr[gambar]");}
						}
						
						mysql_query("UPDATE tabel_gallery SET gambar = '$nama_file_baru' WHERE id_gallery = '$_POST[id]'");	
					}
					
				}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=gallery&mod=detail&id=$_POST[id_kategori]')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form_detail_action();
			}
		}
	}
	elseif ($_GET['mod']=='delete_gambar')
	{
		if (!empty($_GET['actd']) ? $_GET['actd'] : '' =='delete')
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_gallery WHERE id_gallery = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_gallery WHERE id_gallery ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/post/$pic"))
					{unlink("../images/post/$pic");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=gallery&mod=detail&id=$_GET[id_kategori]')</script>";
			}
			else
			{
			echo "<script>alert('Data Gagal di Delete');</script>";
			}
		}
	}
	?>

