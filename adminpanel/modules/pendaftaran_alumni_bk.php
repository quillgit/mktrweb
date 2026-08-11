<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_event WHERE id_event = '$id'"));
			$title 				= stripslashes($edit['title']);
			$content 			= stripslashes($edit['content']);
			$gambar 			= stripslashes($edit['gambar']);
			$start_date 		= stripslashes($edit['start_date']);
			$end_date 			= stripslashes($edit['end_date']);
			$durasi 			= stripslashes($edit['durasi']);
			$lokasi 			= stripslashes($edit['lokasi']);
			$maps 				= stripslashes($edit['maps']);
			$kontak 			= stripslashes($edit['kontak']);
			$meta_keyword 		= stripslashes($edit['meta_keyword']);
			$meta_description 	= stripslashes($edit['meta_description']);		
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$content 			= isset($_POST['content']) ? $_POST['content']:''; 
			$durasi 			= isset($_POST['durasi']) ? $_POST['durasi']:''; 
			$lokasi 			= isset($_POST['lokasi']) ? $_POST['lokasi']:''; 
			$maps 				= isset($_POST['maps']) ? $_POST['maps']:''; 
			$kontak 			= isset($_POST['kontak']) ? $_POST['kontak']:''; 
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$meta_keyword 		= isset($_POST['meta_keyword']) ? $_POST['meta_keyword']:''; 
			$meta_description 	= isset($_POST['meta_description']) ? $_POST['meta_description']:''; 
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
                            <h4 class="card-title">Event</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_event WHERE id_event = '$id'"));
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
												<h6>Content</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="content" placeholder="Content ..."><?php echo"$content"; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
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
											
											<div class="col-md-6 col-6">
												<h6>Durasi (2 Jam)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="durasi" value="<?php echo"$durasi"; ?>" placeholder="Durasi ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-6 col-6">
												<h6>Lokasi (Istora Senayan)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="lokasi" value="<?php echo"$lokasi"; ?>" placeholder="Lokasi ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Kontak</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="kontak" value="<?php echo"$kontak"; ?>" placeholder="Kontak ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Maps (copy Iframe Google Maps)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="maps" value="<?php echo"$maps"; ?>" placeholder="Maps ..." required="required"/>
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
                                                <a href="admin.php?menu=event" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_event WHERE id_event = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_event WHERE id_event ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/post/$pic"))
					{unlink("../images/post/$pic");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=event')</script>";
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
						<h2 class="content-header-title float-left mb-0">Pendaftaran Alumni</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Pendaftaran</a>
								</li>
								<li class="breadcrumb-item active">Data Pendaftaran Alumni
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
								<th>First Name</th>
								<th>Mid Name</th>
								<th>Last Name</th>
								<th>Tahun TK</th>
								<th>Tahun SD</th>
								<th>Tahun SMP</th>
								<th>Email</th>
								<th>Status</th>
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
		<script type="text/javascript" src="assets/js/menu/data-table-pendaftaran-alumni.js"></script>
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
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));;
			//cek SLUG
			$slug	     		= mysql_real_escape_string(slug($_POST['title']));
			
			$meta_keyword 		= mysql_real_escape_string($_POST['meta_keyword']);
			$meta_description 	= mysql_real_escape_string($_POST['meta_description']);
			
			$durasi 			= mysql_real_escape_string($_POST['durasi']);
			$maps 				= mysql_real_escape_string($_POST['maps']);
			$lokasi 			= mysql_real_escape_string($_POST['lokasi']);
			$kontak 			= mysql_real_escape_string($_POST['kontak']);
			
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
			
			$add = "INSERT INTO tabel_event 
			(title, content, gambar, start_date, end_date, durasi, maps, lokasi, kontak, status, created, author, slug, meta_keyword, meta_description) 
			VALUES 
			('$title', '$content', '$nama_file_baru', '$newStartDate', '$newEndDate', '$durasi', '$maps', '$lokasi', '$kontak', '2', '$date', '$_SESSION[namauser]', '$slug', '$meta_keyword', '$meta_description')";
						
			$query = mysql_query($add);
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=event')</script>";
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
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));;
			//cek SLUG
			$slug	     		= mysql_real_escape_string(slug($_POST['title']));
			
			$meta_keyword 		= mysql_real_escape_string($_POST['meta_keyword']);
			$meta_description 	= mysql_real_escape_string($_POST['meta_description']);
			
			$durasi 			= mysql_real_escape_string($_POST['durasi']);
			$maps 				= mysql_real_escape_string($_POST['maps']);
			$lokasi 			= mysql_real_escape_string($_POST['lokasi']);
			$kontak 			= mysql_real_escape_string($_POST['kontak']);
			
			$start_date 		= mysql_real_escape_string($_POST['start_date']);
			$end_date 			= mysql_real_escape_string($_POST['end_date']);
			
			$newStartDate 		= date("Y-m-d", strtotime($start_date));
			$newEndDate 		= date("Y-m-d", strtotime($end_date));
			
			$update = "UPDATE tabel_event SET  title = '$title',
													content = '$content',
													slug = '$slug',
													start_date = '$newStartDate',
													end_date = '$newEndDate',
													durasi = '$durasi',
													maps = '$maps',
													lokasi = '$lokasi',
													kontak = '$kontak',
										meta_keyword = '$meta_keyword',
										meta_description = '$meta_description',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_event = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/post/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_event WHERE id_event = '$_POST[id]'"));
						if (!empty($gbr['gambar'])) 
						{
							if (file_exists("../images/post/$gbr[gambar]"))
							{unlink("../images/post/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_event SET gambar = '$nama_file_baru' WHERE id_event = '$_POST[id]'");	
					}
					
				}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=event')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	
	elseif ($_GET['mod']=='acc_member')
	{
	    $sql = "UPDATE `tabel_pendaftaran` SET `status` = '2' WHERE id_pendaftaran = '$_GET[id]' ";
	    $ins = mysql_query($sql);
        echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=pendaftaran_alumni')</script>";
	}
	?>

