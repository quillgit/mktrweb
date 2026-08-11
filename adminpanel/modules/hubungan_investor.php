<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_tentang_kami WHERE id_tentang_kami = '$id'"));
			$title 					= stripslashes($edit['title']);
			$sub_title 				= stripslashes($edit['sub_title']);
			$description 			= stripslashes($edit['description']);
			$sub_title_english 		= stripslashes($edit['sub_title_english']);
			$description_english 	= stripslashes($edit['description_english']);
			$gambar 				= stripslashes($edit['gambar']);
			$banner 				= stripslashes($edit['banner']);
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
			$gambar 				= isset($_POST['gambar']) ? $_POST['gambar']:'';
			$banner 				= isset($_POST['banner']) ? $_POST['banner']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Hubungan Investor</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_tentang_kami WHERE id_tentang_kami = '$id'"));
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

											<div class="col-md-6 col-6">
												<h6>Banner (1905∶1273)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="banner">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$banner"; ?></label>
														<?php
															if (file_exists("../images/banner/$banner"))
															{
															echo "<p><img src='../images/banner/$banner' width='200'/></p><br>";
															
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
                                                <a href="admin.php?menu=hubungan_investor" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_hubungan_investor WHERE id_hubungan_investor = '$id'"));
			$title 					= stripslashes($edit['title']);
			$title_english 			= stripslashes($edit['title_english']);
			$file_dokumen 			= stripslashes($edit['file_dokumen']);
			$from = 'edit_dokumen';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$title 					= isset($_POST['title']) ? $_POST['title']:''; 
			$title_english 			= isset($_POST['title_english']) ? $_POST['title_english']:'';
			$file_dokumen 			= isset($_POST['file_dokumen']) ? $_POST['file_dokumen']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Hubungan Investor</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_hubungan_investor WHERE id_hubungan_investor = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title Bahasa ..."/>
                                                </div>
                                            </div>
											
											 <div class="col-md-12 col-12">
												<h6>Title English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title_english" value="<?php echo"$title_english"; ?>" placeholder="Title English ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>File Dokumen</h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="file_dokumen">
														<?php
														if ($_GET['mod']=='edit_dokumen'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$file_dokumen"; ?></label>
														<?php
															$editf = mysql_fetch_array(mysql_query("SELECT file_dokumen FROM tabel_hubungan_investor WHERE id_hubungan_investor = '$id'"));
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
                                                <a href="admin.php?menu=hubungan_investor" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_hubungan_investor WHERE id_hubungan_investor = '$id'"));
			$pic = isset($gbr['file_dokumen']) ? $gbr['file_dokumen']:'';
			$delete = "DELETE FROM tabel_hubungan_investor WHERE id_hubungan_investor ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../dokumen/$pic"))
					{unlink("../dokumen/$pic");}
				}
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=hubungan_investor')</script>";
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
						<h2 class="content-header-title float-left mb-0">Hubungan Investor</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Tentang Kami</a>
								</li>
								<li class="breadcrumb-item active">Data Hubungan Investor
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
								<th>Judul Bahasa</th>
								<th>Judul English</th>
								<th>Updated</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_tentang_kami where id_tentang_kami = '3'");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[sub_title]</td>
								<td>$list[sub_title_english]</td>
								<td>$list[updated]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit&id=$list[id_tentang_kami]'><img src=img/edit.png border=0 /></a> ";
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
						<h2 class="content-header-title float-left mb-0">Upload Dokumen Hubungan Investor</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<!-- Data list view starts -->
			<section id="data-thumb-view" class="data-thumb-view-header">
					
				<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new"><i class='feather icon-plus'></i> Tambah Dokumen</a></h3>	
					
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
							$banner = mysql_query("SELECT * FROM tabel_hubungan_investor ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[title]</td>
								<td>$list[title_english]</td>
								<td><a href='../dokumen/$list[file_dokumen]' target='_blank'>$list[file_dokumen]</a></td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit_dokumen&id=$list[id_hubungan_investor]'><img src=img/edit.png border=0 /></a> ";
							?>
								<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_hubungan_investor]"; ?>" 
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
		
	<?php
	}
	elseif ($_GET['mod']=='new')
	{
		if (empty($_GET['act']))
		{
		
			form_2();
		
		}elseif ($_GET['act']=='process'){
			
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
								
			$title 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			
			$lokasifile_f 	= $_FILES['file_dokumen']['tmp_name'];
			$namafile_f   	= $_FILES['file_dokumen']['name'];
			$jenis_file 	= $_FILES['file_dokumen']['type'];

			

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
			
			$add = "INSERT INTO tabel_hubungan_investor 
			(title, title_english, file_dokumen, status, created, author) 
			VALUES 
			('$title', '$title_english', '$nama_file_f', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=hubungan_investor')</script>";
			}
			else
			{
				echo "<script>alert('Data Gagal di Simpan');</script>";
				form_2();
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

			$lok_mobile = $_FILES['banner']['tmp_name'];
			$fn_mobile = $_FILES['banner']['name'];
			$ft_mobile = $_FILES['banner']['type'];
			
		
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$sub_title   		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$description 	 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			$sub_title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title_english']));
			$description_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description_english']));
			
			
			$update = "UPDATE tabel_tentang_kami SET  title = '$title',
													sub_title = '$sub_title',
													description = '$description',
													sub_title_english = '$sub_title_english',
													description_english = '$description_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_tentang_kami = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{

				if (!empty($lok_mobile)){
					
					if($ft_mobile=="image/jpeg" || $ft_mobile=="image/jpg" || $ft_mobile=="image/png" || $ft_mobile=="image/gif"){
					
						$file1 = str_replace(" ", "-", $fn_mobile);
						$prefix1 = rand(00000,99999);
						$fn_mobile_fin = $prefix1.''.$file1;
						move_uploaded_file($lok_mobile,"../images/banner/$fn_mobile_fin");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_tentang_kami WHERE id_tentang_kami = '$_POST[id]'"));
						if (!empty($gbr['banner'])) 
						{
							if (file_exists("../images/banner/$gbr[banner]"))
							{unlink("../images/banner/$gbr[banner]");}
						}
						mysql_query("UPDATE tabel_tentang_kami SET banner = '$fn_mobile_fin' WHERE id_tentang_kami = '$_POST[id]'");	
					}
					
				}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=hubungan_investor')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
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
			
			$title 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			
			$lokasifile_f 	= $_FILES['file_dokumen']['tmp_name'];
			$namafile_f   	= $_FILES['file_dokumen']['name'];
			$jenis_file 	= $_FILES['file_dokumen']['type'];;
			
			
			$update = "UPDATE tabel_hubungan_investor SET  title = '$title',
													title_english = '$title_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_hubungan_investor = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile_f)){
						
						if($jenis_file=="application/pdf" || $jenis_file=="application/msword" || $jenis_file=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_file=="application/excel" || $jenis_file=="image/jpeg" || $jenis_file=="image/jpg" || $jenis_file=="image/png" || $jenis_file=="image/gif"){
						
							$filef = str_replace(" ", "-", $namafile_f);
							$prefixf = rand(000,999);
							$nama_file_f = $prefixf.''.$filef;
							move_uploaded_file($lokasifile_f,"../dokumen/$nama_file_f");
							
							$fly = mysql_fetch_array (mysql_query("SELECT file_dokumen FROM tabel_hubungan_investor WHERE id_hubungan_investor = '$_POST[id]'"));
							if (!empty($fly['file_dokumen'])) 
							{
								if (file_exists("../dokumen/$fly[file_dokumen]"))
								{unlink("../dokumen/$fly[file_dokumen]");}
							}
							mysql_query("UPDATE tabel_hubungan_investor SET file_dokumen = '$nama_file_f' WHERE id_hubungan_investor = '$_POST[id]'");	
						}
						
					}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=hubungan_investor')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form_2();
			}
		}
	}
	?>

