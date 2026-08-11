<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_banner WHERE id_banner = '$id'"));
			$title 				= stripslashes($edit['title']);
			$gambar 			= stripslashes($edit['gambar']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Setting Home</h4>
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
												<h6>Banner</h6>
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
						<h2 class="content-header-title float-left mb-0">Setting Home</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">MASTER</a>
								</li>
								<li class="breadcrumb-item active">Data Setting Home
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			
			<!-- Data list view starts -->
			<section class="data-thumb-view-header">
					
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Email</th>
								<th>No HP</th>
								<th>Pembayaran</th>
								<th>Kode Bayar</th>
								<th>Created</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$no = 1;
						$supplier = mysql_query("SELECT
						tabel_campaign.title,
						tabel_zakat.title
						FROM
						tabel_campaign ,
						tabel_zakat
						GROUP BY
						tabel_campaign.slug,
						tabel_zakat.slug
						");
						while ($list = mysql_fetch_array($supplier)){
						echo "
							<tr>
								<td>$no</td>
								<td>$list[title]</td>
								<td>$list[title]</td>
								<td>$list[title]</td>
								<td></td>
								<td></td>
								<td></td>
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
		<script src="app-assets/js/scripts/ui/data-list-view.js"></script>
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
					
			$title = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			
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
		
			$add = "INSERT INTO tabel_banner 
			(title, gambar, status, created, author) 
			VALUES 
			('$title', '$nama_file_baru', '2', '$date', '$_SESSION[namauser]')";
						
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

			$title = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			
			$update = "UPDATE tabel_banner SET  title = '$title',
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

