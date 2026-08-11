<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fakultas_dokumen WHERE id_fakultas_dokumen = '$id'"));
			$title 					= stripslashes($edit['title']);
			$title_english 			= stripslashes($edit['title_english']);
			$sub_title 				= stripslashes($edit['sub_title']);
			$sub_title_english 		= stripslashes($edit['sub_title_english']);
			$file_dokumen 			= stripslashes($edit['file_dokumen']);
			$gambar 				= stripslashes($edit['gambar']);
			$from = 'edit';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$title 					= isset($_POST['title']) ? $_POST['title']:''; 
			$title_english 			= isset($_POST['title_english']) ? $_POST['title_english']:'';
			$sub_title 				= isset($_POST['sub_title']) ? $_POST['sub_title']:''; 
			$sub_title_english 		= isset($_POST['sub_title_english']) ? $_POST['sub_title_english']:'';
			$file_dokumen 			= isset($_POST['file_dokumen']) ? $_POST['file_dokumen']:''; 
			$gambar 				= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$from = 'process';
		}
		
		$cek_fakultas_form = mysql_fetch_array(mysql_query("SELECT title, id_fakultas FROM tabel_fakultas WHERE id_fakultas = '$_GET[id_fakultas]'"));
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Dokumen <?php echo $cek_fakultas_form['title'];?></h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fakultas_dokumen WHERE id_fakultas_dokumen = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
									
									<input type="hidden" name="id_fakultas" value="<?php echo"$cek_fakultas_form[id_fakultas]"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Program Studi Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Program Studi Bahasa ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Terakreditasi Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="sub_title" value="<?php echo"$sub_title"; ?>" placeholder="Terakreditasi Bahasa ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<hr class="english">
											</div>
											
											<div class="col-md-12 col-12">
												<h6>Program Studi English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title_english" value="<?php echo"$title_english"; ?>" placeholder="Program Studi English ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Terakreditasi English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="sub_title_english" value="<?php echo"$sub_title_english"; ?>" placeholder="Terakreditasi English ..."/>
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
											
											<div class="col-md-12 col-12">
												<h6>File Dokumen</h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="file_dokumen">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$file_dokumen"; ?></label>
														<?php
															$editf = mysql_fetch_array(mysql_query("SELECT file_dokumen FROM tabel_fakultas_dokumen WHERE id_fakultas_dokumen = '$id'"));
															if (!empty($editf['file_dokumen']))
															{
																if (file_exists("../dokumen/$editf[file_dokumen]"))
																{
																echo "<a href='../dokumen/$editf[file_dokumen]' target='_blank'>$editf[file_dokumen]</a>";
																?>
																</p>
																<?php
																}
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
                                                <a href="admin.php?menu=fakultas_dokumen&id=<?php echo $cek_fakultas_form['id_fakultas'];?>" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_fakultas_dokumen WHERE id_fakultas_dokumen = '$id'"));
			$pic = isset($gbr['file_dokumen']) ? $gbr['file_dokumen']:'';
			$delete = "DELETE FROM tabel_fakultas_dokumen WHERE id_fakultas_dokumen ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../dokumen/$pic"))
					{unlink("../dokumen/$pic");}
				}
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=fakultas_dokumen&id=$_GET[id_fakultas]')</script>";
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
						<h2 class="content-header-title float-left mb-0">DOKUMEN - <?php echo $cek_fakultas['title'];?></h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="admin.php?menu=fakultas">Fakultas</a>
								</li>
								<li class="breadcrumb-item active">Add Dokumen
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
					
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]&id_fakultas=$_GET[id]"; ?>&mod=new"><i class='feather icon-plus'></i> Tambah Dokumen</a></h3>	
					
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view" id="table-product">
						<thead>
							<tr>
								<th>No</th>
								<th>Program Studi Bahasa</th>
								<th>Terakreditasi Bahasa</th>
								<th>Program Studi English</th>
								<th>Terakreditasi English</th>
								<th>Icon</th>
								<th>File</th>
								<th>Created</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_fakultas_dokumen where id_fakultas = '$_GET[id]' ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[title]</td>
								<td>$list[sub_title]</td>
								<td>$list[title_english]</td>
								<td>$list[sub_title_english]</td>
								<td><img src='../images/icon/$list[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'></td>
								<td><a href='../dokumen/$list[file_dokumen]' target='_blank'>$list[file_dokumen]</a></td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit&id=$list[id_fakultas_dokumen]&id_fakultas=$_GET[id]'><img src=img/edit.png border=0 /></a> ";
							?>
								<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_fakultas_dokumen]"; ?>&id_fakultas=<?php echo "$_GET[id]"; ?>"  onClick="return confirm('Delete : <?php echo "$list[title]"; ?>?')"><img src="img/delete.png"/> </a>
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
								
			$title 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$sub_title 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$sub_title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title_english']));
			
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];
			
			$lokasifile_f 	= $_FILES['file_dokumen']['tmp_name'];
			$namafile_f   	= $_FILES['file_dokumen']['name'];
			$jenis_file 	= $_FILES['file_dokumen']['type'];
			
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

			if (!empty($lokasifile_f)){
				
				if($jenis_file=="application/pdf" || $jenis_file=="application/msword" || $jenis_file=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_file=="application/excel" || $jenis_file=="image/jpeg" || $jenis_file=="image/jpg" || $jenis_file=="image/png" || $jenis_file=="image/gif"){
				
					$file2 = str_replace(" ", "-", $namafile_f);
					$prefix2 = rand(000,999);
					$nama_file_f = $prefix2.''.$file2;
					move_uploaded_file($lokasifile_f,"../dokumen/$nama_file_f");
					
				}

			}else{
				$nama_file_f = "";
			}
			
			$add = "INSERT INTO tabel_fakultas_dokumen 
			(id_fakultas, title, title_english, sub_title, sub_title_english, file_dokumen, gambar, status, created, author) 
			VALUES 
			('$_POST[id_fakultas]', '$title', '$title_english', '$sub_title', '$sub_title_english', '$nama_file_f', '$nama_file_baru', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=fakultas_dokumen&id=$_POST[id_fakultas]')</script>";
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
			$sub_title 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$sub_title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title_english']));
			
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];
			
			$lokasifile_f 	= $_FILES['file_dokumen']['tmp_name'];
			$namafile_f   	= $_FILES['file_dokumen']['name'];
			$jenis_file 	= $_FILES['file_dokumen']['type'];;
			
			
			$update = "UPDATE tabel_fakultas_dokumen SET  title = '$title',
													title_english = '$title_english',
													sub_title = '$sub_title',
													sub_title_english = '$sub_title_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_fakultas_dokumen = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile_f)){
					
					if($jenis_file=="application/pdf" || $jenis_file=="application/msword" || $jenis_file=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_file=="application/excel" || $jenis_file=="image/jpeg" || $jenis_file=="image/jpg" || $jenis_file=="image/png" || $jenis_file=="image/gif"){
					
						$filef = str_replace(" ", "-", $namafile_f);
						$prefixf = rand(000,999);
						$nama_file_f = $prefixf.''.$filef;
						move_uploaded_file($lokasifile_f,"../dokumen/$nama_file_f");
						
						$fly = mysql_fetch_array (mysql_query("SELECT file_dokumen FROM tabel_fakultas_dokumen WHERE id_fakultas_dokumen = '$_POST[id]'"));
						if (!empty($fly['file_dokumen'])) 
						{
							if (file_exists("../dokumen/$fly[file_dokumen]"))
							{unlink("../dokumen/$fly[file_dokumen]");}
						}
						mysql_query("UPDATE tabel_fakultas_dokumen SET file_dokumen = '$nama_file_f' WHERE id_fakultas_dokumen = '$_POST[id]'");	
					}
					
				}
				
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/icon/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_fakultas_dokumen WHERE id_fakultas_dokumen = '$_POST[id]'"));
						if (!empty($gbr['gambar']))  
						{
							if (file_exists("../images/icon/$gbr[gambar]"))
							{unlink("../images/icon/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_fakultas_dokumen SET gambar = '$nama_file_baru' WHERE id_fakultas_dokumen = '$_POST[id]'");	
					}
					
				}

				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=fakultas_dokumen&id=$_POST[id_fakultas]')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

