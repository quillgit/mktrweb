<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_banner WHERE id_banner = '$id'"));
			$title 				= stripslashes($edit['title']);
			$gambar 			= stripslashes($edit['gambar']);
			$konten 			= stripslashes($edit['konten']);
			$title_english 				= stripslashes($edit['title_english']);
			$konten_english 				= stripslashes($edit['konten_english']);
			$link 				= stripslashes($edit['link']);
			$gambar_mobile			= stripslashes($edit['gambar_mobile']);
			$from = 'edit';
		}
		else
		{ 
			$id 			= isset($_POST['id']) ? $_POST['id']:''; 
			$title 			= isset($_POST['title']) ? $_POST['title']:''; 
			$gambar 		= isset($_POST['gambar']) ? $_POST['gambar']:'';
			$konten 		= isset($_POST['konten']) ? $_POST['konten']:'';
			$link 			= isset($_POST['link']) ? $_POST['link']:'';
			$gambar_mobile 			= isset($_POST['gambar_mobile']) ? $_POST['gambar_mobile']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Banner</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_banner WHERE id_banner = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title ..." required="required"/>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
												<h6>Konten</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="konten" value="<?php echo"$konten"; ?>" placeholder="Konten ..." required="required"/>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12 col-12">
												<h6>Title English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title_english" value="<?php echo"$title_english"; ?>" placeholder="Title English ..." required="required"/>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
												<h6>Konten English</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="konten_english" value="<?php echo"$konten_english"; ?>" placeholder="Konten English ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Banner <b>(1920px x 803px)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar"; ?></label>
														<?php
															if (file_exists("../images/banner/$gambar"))
															{
															echo "<p><img src='../images/banner/$gambar' width='200' border= /></p><br>";
															
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
												<h6>Banner Mobile <b>390x400 pixel</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar_mobile">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar_mobile"; ?></label>
														<?php
															if (file_exists("../images/banner/$gambar_mobile"))
															{
															echo "<p><img src='../images/banner/$gambar_mobile' width='200'/></p><br>";
															
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
													<input type="text" class="form-control" name="link" value="<?php echo"$link"; ?>" placeholder="Link ..." required="required"/>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=banner" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_banner WHERE id_banner = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_banner WHERE id_banner ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/banner/$pic"))
					{unlink("../images/banner/$pic");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=banner')</script>";
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
						<h2 class="content-header-title float-left mb-0">Banner</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">About Us</a>
								</li>
								<li class="breadcrumb-item active">Data Banner
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
								<th>Judul</th>
								<th>Judul English</th>
								<th>Banner Desktop</th>
								<th>Banner Mobile</th>
								<th>Link</th>
								<th>Created</th>
								<th>Author</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
						<?php
						$no = 1;
						$data_db = mysql_query("SELECT * FROM tabel_banner where status = '2' ORDER BY created DESC");
						while ($list = mysql_fetch_array($data_db)){
												
							echo "
								<tr>
									<td align='center'>$no</td>
									<td>$list[title]</td>
									<td>$list[title_english]</td>
									<td><img src='../images/banner/$list[gambar]' width='150px' heigh='150px'></td>
									<td><img src='../images/banner/$list[gambar_mobile]' width='50px' heigh='50px'></td>
                                    <td>$list[link]</td>
                                    <td>$list[author]</td>
									<td>$list[created]</td>
									<td class='product-action'>
									<a href='?menu=banner&mod=edit&id=$list[id_banner]'><i class='feather icon-edit'></i></a> |
									";
									
									?>
									
									<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_banner]"; ?>"  onClick="return confirm('Delete : <?php echo "$list[title]"; ?>?')"><i class="feather icon-trash"></i></a>
									
									<?php
									
									echo"
									</td>
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
		</div>
		
		<script src="app-assets/js/scripts/ui/data-list-view-no-add.js"></script>
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
			
			$lok_mobile = $_FILES['gambar_mobile']['tmp_name'];
			$fn_mobile = $_FILES['gambar_mobile']['name'];
			$ft_mobile = $_FILES['gambar_mobile']['type'];
					
			$title 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$konten = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['konten']));
			$link 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
			
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$konten_english = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['konten_english']));
			
			if (!empty($lokasifile)){
				
				if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
				
					$file = str_replace(" ", "-", $namafile);
					$prefix = rand(000,999);
					$nama_file_baru = $prefix.''.$file;
					move_uploaded_file($lokasifile,"../images/banner/$nama_file_baru");
					
				}

			}else{
				$nama_file_baru = "";
			}
			
			if (!empty($lok_mobile)){
				
				if($ft_mobile=="image/jpeg" || $ft_mobile=="image/jpg" || $ft_mobile=="image/png" || $ft_mobile=="image/gif"){
				
					$file1 = str_replace(" ", "-", $fn_mobile);
					$prefix1 = rand(00000,99999);
					$fn_mobile_fin = $prefix1.''.$file1;
					move_uploaded_file($lok_mobile,"../images/banner/$fn_mobile_fin");
					
				}

			}else{
				$fn_mobile_fin = "";
			}
		
			$add = "INSERT INTO tabel_banner 
			(title, konten, title_english, konten_english, gambar, gambar_mobile, link, status, created, author) 
			VALUES 
			('$title', '$konten', '$title_english', '$konten_english', '$nama_file_baru', '$fn_mobile_fin', '$link', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
			
			$id_article = mysql_insert_id();
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=banner')</script>";
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
			
			$lok_mobile = $_FILES['gambar_mobile']['tmp_name'];
			$fn_mobile = $_FILES['gambar_mobile']['name'];
			$ft_mobile = $_FILES['gambar_mobile']['type'];
			
			$title = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$konten = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['konten']));
			$link 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
			
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$konten_english = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['konten_english']));
			
			$update = "UPDATE tabel_banner SET  title = '$title',
                                                 konten = '$konten',
                                                 title_english = '$title_english',
                                                 konten_english = '$konten_english',
												link = '$link',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_banner = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/banner/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_banner WHERE id_banner = '$_POST[id]'"));
						if (!empty($gbr['gambar'])) 
						{
							if (file_exists("../images/banner/$gbr[gambar]"))
							{unlink("../images/banner/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_banner SET gambar = '$nama_file_baru' WHERE id_banner = '$_POST[id]'");	
					}
					
				}
				
				
				if (!empty($lok_mobile)){
					
					if($ft_mobile=="image/jpeg" || $ft_mobile=="image/jpg" || $ft_mobile=="image/png" || $ft_mobile=="image/gif"){
					
						$file1 = str_replace(" ", "-", $fn_mobile);
						$prefix1 = rand(00000,99999);
						$fn_mobile_fin = $prefix1.''.$file1;
						move_uploaded_file($lok_mobile,"../images/banner/$fn_mobile_fin");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_banner WHERE id_banner = '$_POST[id]'"));
						if (!empty($gbr['gambar_mobile'])) 
						{
							if (file_exists("../images/banner/$gbr[gambar_mobile]"))
							{unlink("../images/banner/$gbr[gambar_mobile]");}
						}
						mysql_query("UPDATE tabel_banner SET gambar_mobile = '$fn_mobile_fin' WHERE id_banner = '$_POST[id]'");	
					}
					
				}

				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=banner')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

