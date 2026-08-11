<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_about_us WHERE id_about_us = '$id'"));
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
                            <h4 class="card-title">Keanggotaan</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_about_us WHERE id_about_us = '$id'"));
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
                                                <a href="admin.php?menu=keanggotaan" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_keanggotaan WHERE id_keanggotaan = '$id'"));
			$title 					= stripslashes($edit['title']);
			$title_english 			= stripslashes($edit['title_english']);
			$content 			= stripslashes($edit['content']);
			$link 					= stripslashes($edit['link']);
			$content_english 	= stripslashes($edit['content_english']);
			$gambar 			= stripslashes($edit['gambar']);
			$from = 'edit_dokumen';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$link 				= isset($_POST['link']) ? $_POST['link']:''; 
			$title_english 		= isset($_POST['title_english']) ? $_POST['title_english']:'';
			$content 			= isset($_POST['content']) ? $_POST['content']:''; 
			$content_english 	= isset($_POST['content_english']) ? $_POST['content_english']:'';
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Keanggotaan</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_keanggotaan WHERE id_keanggotaan = '$id'"));
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
												<h6>Konten Bahasa</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="content" placeholder="Konten Bahasa ..."><?php echo"$content"; ?></textarea>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<hr class="english">
											</div>
											
											<div class="col-md-12 col-12">
												<h6>Title English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title_english" value="<?php echo"$title_english"; ?>" placeholder="Sub English ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Konten English</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="content_english" placeholder="Konten English ..."><?php echo"$content_english"; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Gambar</h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit_dokumen'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar"; ?></label>
														<?php
															$editf = mysql_fetch_array(mysql_query("SELECT gambar FROM tabel_keanggotaan WHERE id_keanggotaan = '$id'"));
															if (!empty($editf['gambar']))
															{
																if (file_exists("../images/about/$editf[gambar]"))
																{
																echo "<a href='../images/about/$editf[gambar]' target='_blank'>$editf[gambar]</a>";
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

											<div class="col-md-12 col-12">
												<h6>Link</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="link" value="<?php echo"$link"; ?>" placeholder="Link ..."/>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=keanggotaan" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_keanggotaan WHERE id_keanggotaan = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_keanggotaan WHERE id_keanggotaan ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/about/$pic"))
					{unlink("../images/about/$pic");}
				}
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=keanggotaan')</script>";
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
						<h2 class="content-header-title float-left mb-0">Keanggotaan</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">About Us</a>
								</li>
								<li class="breadcrumb-item active">Data Keanggotaan
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
							$banner = mysql_query("SELECT * FROM tabel_about_us where id_about_us = '7'");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[sub_title]</td>
								<td>$list[sub_title_english]</td>
								<td>$list[updated]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit&id=$list[id_about_us]'><img src=img/edit.png border=0 /></a> ";
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
						<h2 class="content-header-title float-left mb-0">Keanggotaan Detail</h2>
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
								<th>Judul</th>
								<th>Judul English</th>
								<th>Link</th>
								<th>Gambar</th>
								<th>Created</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_keanggotaan ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[title]</td>
								<td>$list[title_english]</td>
								<td>$list[link]</td>
								<td><img src='../images/about/$list[gambar]' class='img-fluid' style='max-height: 100px; max-width: 100px;'></td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit_dokumen&id=$list[id_keanggotaan]'><img src=img/edit.png border=0 /></a> ";
							?>
								<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_keanggotaan]"; ?>" 
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
								
			$title 				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));
			$content_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content_english']));
			$link 				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
			
			$lokasifile_f 	= $_FILES['gambar']['tmp_name'];
			$namafile_f   	= $_FILES['gambar']['name'];
			$jenis_file 	= $_FILES['gambar']['type'];

			if (!empty($lokasifile_f)){
				
				if($jenis_file=="image/jpeg" || $jenis_file=="image/jpg" || $jenis_file=="image/png" || $jenis_file=="image/gif"){
				
					$file2 = str_replace(" ", "-", $namafile_f);
					$prefix2 = rand(000,999);
					$nama_file_f = $prefix2.''.$file2;
					move_uploaded_file($lokasifile_f,"../images/about/$nama_file_f");
					
				}

			}else{
				$nama_file_f = "";
			}
			
			$add = "INSERT INTO tabel_keanggotaan 
			(title, title_english, link, content, content_english, gambar, status, created, author) 
			VALUES 
			('$title', '$title_english', '$link', '$content', '$content_english', '$nama_file_f', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=keanggotaan')</script>";
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
			
		
			$title   				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$sub_title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$description 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			$sub_title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title_english']));
			$description_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description_english']));
			$link 					= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
			
			$update = "UPDATE tabel_about_us SET  title = '$title',
													sub_title = '$sub_title',
													link = '$link',
													description = '$description',
													sub_title_english = '$sub_title_english',
													description_english = '$description_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_about_us = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=keanggotaan')</script>";
				
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
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));
			$content_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content_english']));
			
			$lokasifile_f 	= $_FILES['gambar']['tmp_name'];
			$namafile_f   	= $_FILES['gambar']['name'];
			$jenis_file 	= $_FILES['gambar']['type'];;
			
			
			$update = "UPDATE tabel_keanggotaan SET  title = '$title',
													title_english = '$title_english',
													content = '$content',
													content_english = '$content_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_keanggotaan = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile_f)){
						
						if($jenis_file=="image/jpeg" || $jenis_file=="image/jpg" || $jenis_file=="image/png" || $jenis_file=="image/gif"){
						
							$filef = str_replace(" ", "-", $namafile_f);
							$prefixf = rand(000,999);
							$nama_file_f = $prefixf.''.$filef;
							move_uploaded_file($lokasifile_f,"../images/about/$nama_file_f");
							
							$fly = mysql_fetch_array (mysql_query("SELECT gambar FROM tabel_keanggotaan WHERE id_keanggotaan = '$_POST[id]'"));
							if (!empty($fly['gambar'])) 
							{
								if (file_exists("../images/about/$fly[gambar]"))
								{unlink("../images/about/$fly[gambar]");}
							}
							mysql_query("UPDATE tabel_keanggotaan SET gambar = '$nama_file_f' WHERE id_keanggotaan = '$_POST[id]'");	
						}
						
					}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=keanggotaan')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form_2();
			}
		}
	}
	?>

