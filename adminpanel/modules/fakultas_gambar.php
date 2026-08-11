<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fakultas_prodi WHERE id_fakultas_prodi = '$id'"));
			$title 					= stripslashes($edit['title']);
			$title_english 			= stripslashes($edit['title_english']);
			$gambar 				= stripslashes($edit['gambar']);
			$description 			= stripslashes($edit['description']);
			$description_english 	= stripslashes($edit['description_english']);
			$from = 'edit';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$title 					= isset($_POST['title']) ? $_POST['title']:''; 
			$title_english 			= isset($_POST['title_english']) ? $_POST['title_english']:'';
			$gambar 				= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$description 			= isset($_POST['description']) ? $_POST['description']:'';  
			$description_english 	= isset($_POST['description_english']) ? $_POST['description_english']:'';
			$from = 'process';
		}
		
		$cek_fakultas_form = mysql_fetch_array(mysql_query("SELECT title, id_fakultas FROM tabel_fakultas WHERE id_fakultas = '$_GET[id_fakultas]'"));
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Program Studi <?php echo $cek_fakultas_form['title'];?></h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fakultas_prodi WHERE id_fakultas_prodi = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
									
									<input type="hidden" name="id_fakultas" value="<?php echo"$cek_fakultas_form[id_fakultas]"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title Bahasa ..."/>
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
												<h6>Title English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title_english" value="<?php echo"$title_english"; ?>" placeholder="Title English ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Description (English)</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="description_english" placeholder="Description ..."><?php echo"$description_english"; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-md-6 col-6">
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
                                                <a href="admin.php?menu=fakultas_gambar&id=<?php echo $cek_fakultas_form['id_fakultas'];?>" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_fakultas_prodi WHERE id_fakultas_prodi = '$id'"));
			$pic = isset($gbr['file_dokumen']) ? $gbr['file_dokumen']:'';
			$delete = "DELETE FROM tabel_fakultas_prodi WHERE id_fakultas_prodi ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../dokumen/$pic"))
					{unlink("../dokumen/$pic");}
				}
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=fakultas_gambar&id=$_GET[id_fakultas]')</script>";
			}
			else
			{
			echo "<script>alert('Data Gagal di Delete');</script>";
			}
		}
		
		$cek_fakultas = mysql_fetch_array(mysql_query("SELECT title FROM tabel_fakultas WHERE id_fakultas = '$_GET[id]'"));
		
	?>
		
		<div class="content-header row">
			<div class="content-header-left col-md-9 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h2 class="content-header-title float-left mb-0">Program Studi - <?php echo $cek_fakultas['title'];?></h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="admin.php?menu=fakultas">Fakultas</a>
								</li>
								<li class="breadcrumb-item active">Add Program Studi
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
					
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]&id_fakultas=$_GET[id]"; ?>&mod=new"><i class='feather icon-plus'></i> Tambah Program Studi</a></h3>	
					
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view" id="table-product">
						<thead>
							<tr>
								<th>No</th>
								<th>Judul</th>
								<th>Judul English</th>
								<th>File</th>
								<th>Created</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_fakultas_prodi where id_fakultas = '$_GET[id]' ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[title]</td>
								<td>$list[title_english]</td>
								<td><img src='../images/icon/$list[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'></td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit&id=$list[id_fakultas_prodi]&id_fakultas=$_GET[id]'><img src=img/edit.png border=0 /></a> ";
							?>
								<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_fakultas_prodi]"; ?>&id_fakultas=<?php echo "$_GET[id]"; ?>"  onClick="return confirm('Delete : <?php echo "$list[title]"; ?>?')"><img src="img/delete.png"/> </a>
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
								
			$title 					= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$slug	     			= mysql_real_escape_string(slug($_POST['title']));	
			$slug_english	    	= mysql_real_escape_string(slug($_POST['title_english']));
			$description 			= mysql_real_escape_string($_POST['description']);			
			$description_english 	= mysql_real_escape_string($_POST['description_english']);	
			
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];

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
			
			
			$add = "INSERT INTO tabel_fakultas_prodi 
			(id_fakultas, title, title_english, description, description_english, gambar, status, created, author, slug, slug_english) 
			VALUES 
			('$_POST[id_fakultas]', '$title', '$title_english', '$description', '$description_english', '$nama_file_baru', '2', '$date', '$_SESSION[namauser]', '$slug', '$slug_english')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=fakultas_gambar&id=$_POST[id_fakultas]')</script>";
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
			
			$title 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$slug	     		= mysql_real_escape_string(slug($_POST['title']));	
			$slug_english	    = mysql_real_escape_string(slug($_POST['title_english']));	
			$description 			= mysql_real_escape_string($_POST['description']);			
			$description_english 	= mysql_real_escape_string($_POST['description_english']);	
			
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];
			
			$update = "UPDATE tabel_fakultas_prodi SET  title = '$title',
													title_english = '$title_english',
													slug = '$slug',
													slug_english = '$slug_english',
													description = '$description',
													description_english = '$description_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_fakultas_prodi = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/icon/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_fakultas_prodi WHERE id_fakultas_prodi = '$_POST[id]'"));
						if (!empty($gbr['gambar']))  
						{
							if (file_exists("../images/icon/$gbr[gambar]"))
							{unlink("../images/icon/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_fakultas_prodi SET gambar = '$nama_file_baru' WHERE id_fakultas_prodi = '$_POST[id]'");	
					}
					
				}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=fakultas_gambar&id=$_POST[id_fakultas]')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

