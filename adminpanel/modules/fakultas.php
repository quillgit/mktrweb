<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fakultas WHERE id_fakultas = '$id'"));
			$title 					= stripslashes($edit['title']);
			$sub_title 				= stripslashes($edit['sub_title']);
			$description 			= stripslashes($edit['description']);
			$sub_title_english 		= stripslashes($edit['sub_title_english']);
			$description_english 	= stripslashes($edit['description_english']);
			$gambar 				= stripslashes($edit['gambar']);
			$nama_dekan 			= stripslashes($edit['nama_dekan']);
			$jabatan 				= stripslashes($edit['jabatan']);
			$jabatan_english 		= stripslashes($edit['jabatan_english']);
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
			$nama_dekan 			= isset($_POST['nama_dekan']) ? $_POST['nama_dekan']:''; 
			$gambar 				= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$jabatan 				= isset($_POST['jabatan']) ? $_POST['jabatan']:'';  
			$jabatan_english 		= isset($_POST['jabatan_english']) ? $_POST['jabatan_english']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Fakultas</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_fakultas WHERE id_fakultas = '$id'"));
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
												<h6>Nama Dekan</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="nama_dekan" value="<?php echo"$nama_dekan"; ?>" placeholder="Nama Dekan ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<hr class="english">
											</div>
											
											<div class="col-md-12 col-12">
												<h6>Jabatan Dekan (Bahasa)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="jabatan" value="<?php echo"$jabatan"; ?>" placeholder="Jabatan (Bahasa) ..." required="required"/>
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
												<h6>Jabatan Dekan (English)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="jabatan_english" value="<?php echo"$jabatan_english"; ?>" placeholder="Jabatan (English) ..." required="required"/>
                                                </div>
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
											
											<div class="col-md-6 col-6">
												<h6>Foto Dekan</h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar"; ?></label>
														<?php
															if (file_exists("../images/about_us/$gambar"))
															{
															echo "<p><img src='../images/about_us/$gambar' width='200' border= /></p><br>";
															
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
                                                <a href="admin.php?menu=fakultas" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
						<h2 class="content-header-title float-left mb-0">Fakultas</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Program & Akademik</a>
								</li>
								<li class="breadcrumb-item active">Data Fakultas
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
								<th>Nama Dekan</th>
								<th>Foto</th>
								<th>Judul Bahasa</th>
								<th>Judul English</th>
								<th>Updated</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_fakultas");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[nama_dekan]</td>
								<td><img src='../images/about_us/$list[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'></td>
								<td>$list[sub_title]</td>
								<td>$list[sub_title_english]</td>
								<td>$list[updated]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit&id=$list[id_fakultas]'><img src=img/edit.png border=0 /></a> 
								<a href='?menu=fakultas_gambar&id=$list[id_fakultas]'><img src=img/tambah-gambar.png border=0 /></a>
								<a href='?menu=fakultas_dokumen&id=$list[id_fakultas]'><img src=img/pdf.png border=0 /></a>";
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
		
		<script src="app-assets/js/scripts/ui/data-list-view-no-add.js"></script>
		
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
			
			$lokasifile = $_FILES['gambar']['tmp_name'];
			$namafile   = $_FILES['gambar']['name'];
			$jenis_gambar = $_FILES['gambar']['type'];
		
			$title   				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$sub_title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$description 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			$sub_title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title_english']));
			$description_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description_english']));
			$nama_dekan 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['nama_dekan']));
			$jabatan 				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['jabatan']));
			$jabatan_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['jabatan_english']));
			
			
			$update = "UPDATE tabel_fakultas SET  title = '$title',
													sub_title = '$sub_title',
													nama_dekan = '$nama_dekan',
													jabatan = '$jabatan',
													jabatan_english = '$jabatan_english',
													description = '$description',
													sub_title_english = '$sub_title_english',
													description_english = '$description_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_fakultas = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/about_us/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_fakultas WHERE id_fakultas = '$_POST[id]'"));
						if (!empty($gbr['gambar']))  
						{
							if (file_exists("../images/about_us/$gbr[gambar]"))
							{unlink("../images/about_us/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_fakultas SET gambar = '$nama_file_baru' WHERE id_fakultas = '$_POST[id]'");	
					}
					
				}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=fakultas')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

