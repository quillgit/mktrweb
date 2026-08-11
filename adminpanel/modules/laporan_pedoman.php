<?php
	function form_2(){

		if 	(($_GET['mod']=='edit_dokumen'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_laporan_pedoman WHERE id_laporan_pedoman = '$id'"));
			$title 					= stripslashes($edit['title']);
			$title_english 			= stripslashes($edit['title_english']);
			$file_dokumen 			= stripslashes($edit['file_dokumen']);
			$laporan_date 			= stripslashes($edit['laporan_date']);
			$from = 'edit_dokumen';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$title 					= isset($_POST['title']) ? $_POST['title']:''; 
			$title_english 			= isset($_POST['title_english']) ? $_POST['title_english']:'';
			$file_dokumen 			= isset($_POST['file_dokumen']) ? $_POST['file_dokumen']:''; 
			$laporan_date 			= isset($_POST['laporan_date']) ? $_POST['laporan_date']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pedoman Umum Governansi Korporat Indonesia</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_laporan_pedoman WHERE id_laporan_pedoman = '$id'"));
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
															$editf = mysql_fetch_array(mysql_query("SELECT file_dokumen FROM tabel_laporan_pedoman WHERE id_laporan_pedoman = '$id'"));
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
											
											<div class="col-md-12 col-12">
												<h6>Laporan Date</h6>
                                                <div class="form-label-group">
													<input type="date" class="form-control" name="laporan_date" value="<?php echo"$laporan_date"; ?>" placeholder="Laporan Date ..." required="required"/>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=laporan_pedoman" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_laporan_pedoman WHERE id_laporan_pedoman = '$id'"));
			$pic = isset($gbr['file_dokumen']) ? $gbr['file_dokumen']:'';
			$delete = "DELETE FROM tabel_laporan_pedoman WHERE id_laporan_pedoman ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../dokumen/$pic"))
					{unlink("../dokumen/$pic");}
				}
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=laporan_pedoman')</script>";
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
						<h2 class="content-header-title float-left mb-0">Pedoman Umum Governansi Korporat Indonesia</h2>
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
								<th>Laporan Date</th>
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
							$banner = mysql_query("SELECT * FROM tabel_laporan_pedoman ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[laporan_date]</td>
								<td>$list[title]</td>
								<td>$list[title_english]</td>
								<td><a href='../dokumen/$list[file_dokumen]' target='_blank'>$list[file_dokumen]</a></td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit_dokumen&id=$list[id_laporan_pedoman]'><img src=img/edit.png border=0 /></a> ";
							?>
								<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_laporan_pedoman]"; ?>" 
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
								
			$title 			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$title_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title_english']));
			
			$laporan_date 		= mysql_real_escape_string($_POST['laporan_date']);
			$newlaporan_date 	= date("Y-m-d", strtotime($laporan_date));
			
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
			
			$add = "INSERT INTO tabel_laporan_pedoman 
			(title, title_english, file_dokumen, laporan_date, status, created, author) 
			VALUES 
			('$title', '$title_english', '$nama_file_f', '$newlaporan_date', '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=laporan_pedoman')</script>";
			}
			else
			{
				echo "<script>alert('Data Gagal di Simpan');</script>";
				form_2();
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
			
			$laporan_date 		= mysql_real_escape_string($_POST['laporan_date']);
			$newlaporan_date 	= date("Y-m-d", strtotime($laporan_date));
			
			$update = "UPDATE tabel_laporan_pedoman SET  title = '$title',
													title_english = '$title_english',
													laporan_date = '$newlaporan_date',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_laporan_pedoman = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile_f)){
						
						if($jenis_file=="application/pdf" || $jenis_file=="application/msword" || $jenis_file=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $jenis_file=="application/excel" || $jenis_file=="image/jpeg" || $jenis_file=="image/jpg" || $jenis_file=="image/png" || $jenis_file=="image/gif"){
						
							$filef = str_replace(" ", "-", $namafile_f);
							$prefixf = rand(000,999);
							$nama_file_f = $prefixf.''.$filef;
							move_uploaded_file($lokasifile_f,"../dokumen/$nama_file_f");
							
							$fly = mysql_fetch_array (mysql_query("SELECT file_dokumen FROM tabel_laporan_pedoman WHERE id_laporan_pedoman = '$_POST[id]'"));
							if (!empty($fly['file_dokumen'])) 
							{
								if (file_exists("../dokumen/$fly[file_dokumen]"))
								{unlink("../dokumen/$fly[file_dokumen]");}
							}
							mysql_query("UPDATE tabel_laporan_pedoman SET file_dokumen = '$nama_file_f' WHERE id_laporan_pedoman = '$_POST[id]'");	
						}
						
					}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=laporan_pedoman')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form_2();
			}
		}
	}
	?>

