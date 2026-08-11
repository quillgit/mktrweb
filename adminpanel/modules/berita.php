<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_berita WHERE id_berita = '$id'"));
			$title 				= stripslashes($edit['title']);
			$title_english 		= stripslashes($edit['title_english']);
			$content 			= stripslashes($edit['content']);
			$content_english 	= stripslashes($edit['content_english']);
			$gambar 			= stripslashes($edit['gambar']);
			$keterangan_gambar 	= stripslashes($edit['keterangan_gambar']);
			$sumber_artikel 	= stripslashes($edit['sumber_artikel']);
			$meta_keyword 		= stripslashes($edit['meta_keyword']);
			$meta_description 	= stripslashes($edit['meta_description']);	
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$title_english 		= isset($_POST['title_english']) ? $_POST['title_english']:''; 
			$content 			= isset($_POST['content']) ? $_POST['content']:''; 
			$content_english 	= isset($_POST['content_english']) ? $_POST['content_english']:'';
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$keterangan_gambar 	= isset($_POST['keterangan_gambar']) ? $_POST['keterangan_gambar']:''; 
			$sumber_gambar 		= isset($_POST['sumber_gambar']) ? $_POST['sumber_gambar']:''; 
			$sumber_artikel 	= isset($_POST['sumber_artikel']) ? $_POST['sumber_artikel']:''; 
			$meta_keyword 		= isset($_POST['meta_keyword']) ? $_POST['meta_keyword']:''; 
			$meta_description 	= isset($_POST['meta_description']) ? $_POST['meta_description']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Berita</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_berita WHERE id_berita = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
									
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title Bahasa</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title ..." required="required"/>
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
												<hr class="english">
											</div>
											
											<div class="col-md-6 col-6">
												<h6>Gambar</h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit'){
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
											
											<div class="col-md-6 col-6">
												<h6>&nbsp </h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="keterangan_gambar" value="<?php echo"$keterangan_gambar"; ?>" placeholder="Keterangan Gambar ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Meta Keyword (Masukkan Meta Keyword sesuai isi artikel contoh : cctv, cctvbali, cctvkalideres) <i>isi 3 Meta Keyword</i></h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="meta_keyword" value="<?php echo"$meta_keyword"; ?>" placeholder="Meta Keyword ..." required="required"/>
                                                </div>
                                            </div>
                                            
											<div class="col-md-12 col-12">
												<h6>Meta Description (Masukkan Deskripsi sesuai isi artikel : Gaji para ahli blockchain tersebut setara dengan gaji para spesialis kecerdasan buatan (AI) )</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="meta_description" value="<?php echo"$meta_description"; ?>" placeholder="Meta Description ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Sumber Artikel</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="sumber_artikel" value="<?php echo"$sumber_artikel"; ?>" placeholder="Sumber Berita ..."/>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=berita" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_berita WHERE id_berita = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_berita WHERE id_berita ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/post/$pic"))
					{unlink("../images/post/$pic");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=berita')</script>";
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
						<h2 class="content-header-title float-left mb-0">Berita</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Content</a>
								</li>
								<li class="breadcrumb-item active">Berita
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
		<script type="text/javascript" src="assets/js/menu/data-table-berita.js"></script>
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
					
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english   	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));
			$content_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content_english']));
			$keterangan_gambar 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['keterangan_gambar']));
			$slug	     		= mysql_real_escape_string(slug($_POST['title']));	
			$slug_english	    = mysql_real_escape_string(slug($_POST['title_english']));			
			$sumber_artikel 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sumber_artikel']));
			$meta_keyword 		= mysql_real_escape_string($_POST['meta_keyword']);
			$meta_description 	= mysql_real_escape_string($_POST['meta_description']);
			
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
		
			$add = "INSERT INTO tabel_berita 
			(title, title_english, content, content_english, gambar, keterangan_gambar, sumber_artikel, status, created, author, slug, slug_english, meta_keyword, meta_description) 
			VALUES 
			('$title', '$title_english', '$content', '$content_english', '$nama_file_baru', '$keterangan_gambar', '$sumber_artikel',  '2', '$date', '$_SESSION[namauser]', '$slug', '$slug_english', '$meta_keyword', '$meta_description')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=berita')</script>";
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
			
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english   	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));
			$content_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content_english']));
			$keterangan_gambar 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['keterangan_gambar']));
			$slug	     		= mysql_real_escape_string(slug($_POST['title']));	
			$slug_english	    = mysql_real_escape_string(slug($_POST['title_english']));			
			$sumber_artikel 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sumber_artikel']));
			$meta_keyword 		= mysql_real_escape_string($_POST['meta_keyword']);
			$meta_description 	= mysql_real_escape_string($_POST['meta_description']);
			
			$update = "UPDATE tabel_berita SET  title = '$title',
												title_english = '$title_english',
													content = '$content',
													content_english = '$content_english',
													slug = '$slug',
													slug_english = '$slug_english',
													keterangan_gambar = '$keterangan_gambar',
													sumber_artikel = '$sumber_artikel',
										meta_keyword = '$meta_keyword',
										meta_description = '$meta_description',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_berita = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/post/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_berita WHERE id_berita = '$_POST[id]'"));
						if (!empty($gbr['gambar']))  
						{
							if (file_exists("../images/post/$gbr[gambar]"))
							{unlink("../images/post/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_berita SET gambar = '$nama_file_baru' WHERE id_berita = '$_POST[id]'");	
					}
					
				}

				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=berita')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

