<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_donasi WHERE id_donasi = '$id'"));
			$title 				= stripslashes($edit['title']);
			$sub_title 			= stripslashes($edit['sub_title']);
			$content 			= stripslashes($edit['content']);
			$gambar 			= stripslashes($edit['gambar']);
			$gambar_sumber_donasi 	= stripslashes($edit['gambar_sumber_donasi']);
			$link 					= stripslashes($edit['link']);
			$sumber_donasi 			= stripslashes($edit['sumber_donasi']);
			$nominal_donasi 		= stripslashes($edit['nominal_donasi']);
			$meta_keyword 			= stripslashes($edit['meta_keyword']);
			$meta_description 		= stripslashes($edit['meta_description']);
			$start_date 			= stripslashes($edit['start_date']);
			$end_date 				= stripslashes($edit['end_date']);
			//$file 					= stripslashes($edit['file']);		
			$from = 'edit';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$title 					= isset($_POST['title']) ? $_POST['title']:''; 
			$sub_title 				= isset($_POST['sub_title']) ? $_POST['sub_title']:''; 
			$content 				= isset($_POST['content']) ? $_POST['content']:''; 
			$gambar 				= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$gambar_sumber_donasi 	= isset($_POST['gambar_sumber_donasi']) ? $_POST['gambar_sumber_donasi']:'';
			$link 					= isset($_POST['link']) ? $_POST['link']:''; 
			$sumber_donasi 			= isset($_POST['sumber_donasi']) ? $_POST['sumber_donasi']:'';
			$nominal_donasi 		= isset($_POST['nominal_donasi']) ? $_POST['nominal_donasi']:'';			
			$meta_keyword 			= isset($_POST['meta_keyword']) ? $_POST['meta_keyword']:''; 
			$meta_description 		= isset($_POST['meta_description']) ? $_POST['meta_description']:''; 
			//$file 					= isset($_POST['file']) ? $_POST['file']:'';
			$start_date 		= isset($_POST['start_date']) ? $_POST['start_date']:'';
			$end_date 			= isset($_POST['end_date']) ? $_POST['end_date']:'';			
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Donasi</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_donasi WHERE id_donasi = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Title Donasi</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title ..." required="required"/>
                                                </div>
                                            </div>
											
											<!--
											<div class="col-md-12 col-12">
												<h6>Sub Title</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="sub_title" value="<?php echo"$sub_title"; ?>" placeholder="Sub Title ..."/>
                                                </div>
                                            </div>
											-->
											
											<div class="col-md-12 col-12">
												<h6>Content</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="content" placeholder="Content Berita ..."><?php echo"$content"; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Nominal Donasi</h6>
                                                <div class="form-label-group">
													<input type="number" class="form-control" name="nominal_donasi" value="<?php echo"$nominal_donasi"; ?>" placeholder="Nominal Donasi ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Sumber Donasi</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="sumber_donasi" value="<?php echo"$sumber_donasi"; ?>" placeholder="Sumber Donasi ..."/>
                                                </div>
                                            </div>
											
											<div class="col-md-6 col-6">
												<h6>Gambar <b>(770px x 515px)</b></h6>
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
												<h6>Gambar Sumber Donasi <b>(100px x 50px)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar_sumber_donasi">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar_sumber_donasi"; ?></label>
														<?php
															if (file_exists("../images/post/$gambar_sumber_donasi"))
															{
															echo "<p><img src='../images/post/$gambar_sumber_donasi' width='200' border= /></p><br>";
															
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
												<h6>Start (Date)</h6>
                                                <div class="form-label-group">
													<input type="date" class="form-control" name="start_date" value="<?php echo"$start_date"; ?>" placeholder="Start Date Donasi ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-6 col-6">
												<h6>End (Date)</h6>
                                                <div class="form-label-group">
													<input type="date" class="form-control" name="end_date" value="<?php echo"$end_date"; ?>" placeholder="End Date Donasi ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Link Donasi</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="link" value="<?php echo"$link"; ?>" placeholder="Link Donasi ..."/>
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
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=donasi" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_donasi WHERE id_donasi = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$pic2 = isset($gbr['gambar_sumber_donasi']) ? $gbr['gambar_sumber_donasi']:'';
			$delete = "DELETE FROM tabel_donasi WHERE id_donasi ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/post/$pic"))
					{unlink("../images/post/$pic");}
				}
				
				if (!empty($pic2)) 
				{ 
					if (file_exists("../images/post/$pic2"))
					{unlink("../images/post/$pic2");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=donasi')</script>";
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
						<h2 class="content-header-title float-left mb-0">Donasi</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Content</a>
								</li>
								<li class="breadcrumb-item active">Donasi
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
								<th>Gambar</th>
								<th>Nominal Donasi</th>
								<th>Sumber Donasi</th>
								<th>Donasi</th>
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
		<script type="text/javascript" src="assets/js/menu/data-table-donasi.js"></script>
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
			
			$lokasifile_d 	= $_FILES['gambar_sumber_donasi']['tmp_name'];
			$namafile_d  	= $_FILES['gambar_sumber_donasi']['name'];
			$jenis_gambar_d = $_FILES['gambar_sumber_donasi']['type'];
					
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			//$sub_title   		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));
			$slug	     		= mysql_real_escape_string(slug($_POST['title']));		
			$sumber_donasi 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sumber_donasi']));
			$link 				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
			$nominal_donasi 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['nominal_donasi']));
			$meta_keyword 		= mysql_real_escape_string($_POST['meta_keyword']);
			$meta_description 	= mysql_real_escape_string($_POST['meta_description']);
			
			$start_date 		= mysql_real_escape_string($_POST['start_date']);
			$end_date 			= mysql_real_escape_string($_POST['end_date']);
			
			$newStartDate 		= date("Y-m-d", strtotime($start_date));
			$newEndDate 		= date("Y-m-d", strtotime($end_date));
			
			
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
			
			if (!empty($lokasifile_d)){
				
				if($jenis_gambar_d=="image/jpeg" || $jenis_gambar_d=="image/jpg" || $jenis_gambar_d=="image/png" || $jenis_gambar_d=="image/gif"){
				
					$file = str_replace(" ", "-", $namafile_d);
					$prefix = rand(000,999);
					$nama_file_baru_d = $prefix.''.$file;
					move_uploaded_file($lokasifile_d,"../images/post/$nama_file_baru_d");
					
				}

			}else{
				$nama_file_baru_d = "";
			}

			//file
			/* $lokasifile_f 	= $_FILES['file_pdf']['tmp_name'];
			$namafile_f   	= $_FILES['file_pdf']['name'];
			$jenis_file 	= $_FILES['file_pdf']['type']; */

			/* if (!empty($lokasifile_f)){
				
				if($jenis_file=="application/pdf" || $jenis_file=="application/msword" || $jenis_file=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_file=="application/excel"){
				
					$file2 = str_replace(" ", "-", $namafile_f);
					$prefix2 = rand(000,999);
					$nama_file_f = $prefix2.''.$file2;
					move_uploaded_file($lokasifile_f,"../doc/$nama_file_f");
					
				}

			}else{
				$nama_file_f = "";
			}
			 */			
			$add = "INSERT INTO tabel_donasi 
			(title, nominal_donasi, content, gambar, gambar_sumber_donasi, sumber_donasi, status, created, author, slug, start_date, end_date, link, meta_keyword, meta_description) 
			VALUES 
			('$title', '$nominal_donasi', '$content', '$nama_file_baru', '$nama_file_baru_d', '$sumber_donasi',  '2', '$date', '$_SESSION[namauser]', '$slug', '$newStartDate', '$newEndDate', '$link', '$meta_keyword', '$meta_description')";
						
			$query = mysql_query($add);
			
			$id_article = mysql_insert_id();
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=donasi')</script>";
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
			
			$lokasifile_d 	= $_FILES['gambar_sumber_donasi']['tmp_name'];
			$namafile_d  	= $_FILES['gambar_sumber_donasi']['name'];
			$jenis_gambar_d = $_FILES['gambar_sumber_donasi']['type'];

			//file
			/* $lokasifile_f 	= $_FILES['file_pdf']['tmp_name'];
			$namafile_f   	= $_FILES['file_pdf']['name'];
			$jenis_file 	= $_FILES['file_pdf']['type']; */
			
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			//$sub_title   		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));
			$slug	     		= mysql_real_escape_string(slug($_POST['title']));		
			$sumber_donasi 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sumber_donasi']));
			$link 				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
			$nominal_donasi 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['nominal_donasi']));
			$meta_keyword 		= mysql_real_escape_string($_POST['meta_keyword']);
			$meta_description 	= mysql_real_escape_string($_POST['meta_description']);
			
			$start_date 		= mysql_real_escape_string($_POST['start_date']);
			$end_date 			= mysql_real_escape_string($_POST['end_date']);
			
			$newStartDate 		= date("Y-m-d", strtotime($start_date));
			$newEndDate 		= date("Y-m-d", strtotime($end_date));
			
			$update = "UPDATE tabel_donasi SET  title = '$title',
													content = '$content',
													slug = '$slug',
													link = '$link',
													sumber_donasi = '$sumber_donasi',
													nominal_donasi = '$nominal_donasi',
													start_date = '$newStartDate',
													end_date = '$newEndDate',
										meta_keyword = '$meta_keyword',
										meta_description = '$meta_description',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_donasi = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/post/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_donasi WHERE id_donasi = '$_POST[id]'"));
						if (!empty($gbr['gambar']))  
						{
							if (file_exists("../images/post/$gbr[gambar]"))
							{unlink("../images/post/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_donasi SET gambar = '$nama_file_baru' WHERE id_donasi = '$_POST[id]'");	
					}
					
				}
				
				if (!empty($lokasifile_d)){
					
					if($jenis_gambar_d=="image/jpeg" || $jenis_gambar_d=="image/jpg" || $jenis_gambar_d=="image/png" || $jenis_gambar_d=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile_d);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile_d,"../images/post/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_donasi WHERE id_donasi = '$_POST[id]'"));
						if (!empty($gbr['gambar_sumber_donasi']))  
						{
							if (file_exists("../images/post/$gbr[gambar_sumber_donasi]"))
							{unlink("../images/post/$gbr[gambar_sumber_donasi]");}
						}
						mysql_query("UPDATE tabel_donasi SET gambar_sumber_donasi = '$nama_file_baru' WHERE id_donasi = '$_POST[id]'");	
					}
					
				}

				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=donasi')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

