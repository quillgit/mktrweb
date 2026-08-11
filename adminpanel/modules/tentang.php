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
			$banner_mobile 			= stripslashes($edit['banner_mobile']);
			$status 				= stripslashes($edit['status']);
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
			$banner_mobile 			= isset($_POST['banner']) ? $_POST['banner_mobile']:'';
			$status 				= isset($_POST['status']) ? $_POST['status']:'';	
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
											
											<?php
											if($id != '2'){
											?>
											
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
															if (file_exists("../images/about/$gambar"))
															{
															echo "<p><img src='../images/about/$gambar' width='200' border= /></p><br>";
															
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
											
											<?php
											}
											?>

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
                                            
                                            <div class="col-md-6 col-6">
												<h6>Banner Mobile (390∶400)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="banner_mobile">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$banner_mobile"; ?></label>
														<?php
															if (file_exists("../images/banner/$banner_mobile"))
															{
															echo "<p><img src='../images/banner/$banner_mobile' width='200'/></p><br>";
															
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
												<h6>Status</h6>
                                                <div class="form-label-group">
													<?php
													if($status == "2"){
														$selected2 = "selected";
													}else{
														$selected2 = "";
													}

													if($status == "1"){
														$selected1 = "selected";
													}else{
														$selected1 = "";
													}
													?>
													<select name="status" class="form-control">
														<option value="2" <?php echo $selected2;?>>Publish</option>
														<option value="1" <?php echo $selected1;?>>UnPublish</option>
													</select>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=tentang" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
								<th>Menu</th>
								<th>Judul</th>
								<th>Judul English</th>
								<th>Status</th>
								<th>Updated</th>
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
		
		<script type="text/javascript" src="assets/js/menu/data-table-tentang.js"></script>
		<!-- Javascript load  -->
		
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

			$lok_mobile = $_FILES['banner']['tmp_name'];
			$fn_mobile = $_FILES['banner']['name'];
			$ft_mobile = $_FILES['banner']['type'];
		
		    $lok_banner_mobile = $_FILES['banner_mobile']['tmp_name'];
			$fn_banner_mobile = $_FILES['banner_mobile']['name'];
			$ft_banner_mobile = $_FILES['banner_mobile']['type'];
		
			$title   				= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$sub_title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$description 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			$sub_title_english 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title_english']));
			$description_english 	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description_english']));
			$slug	     			= mysql_real_escape_string(slug($_POST['sub_title']));	
			$slug_english	   		= mysql_real_escape_string(slug($_POST['sub_title_english']));	
			$status 	 			= mysql_real_escape_string($_POST['status']);
			
			$update = "UPDATE tabel_tentang_kami SET  title = '$title',
													sub_title = '$sub_title',
													description = '$description',
													sub_title_english = '$sub_title_english',
													description_english = '$description_english',
													slug = '$slug',
													status = '$status',
													slug_english = '$slug_english',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_tentang_kami = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"../images/about/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_tentang_kami WHERE id_tentang_kami = '$_POST[id]'"));
						if (!empty($gbr['gambar']))  
						{
							if (file_exists("../images/about/$gbr[gambar]"))
							{unlink("../images/about/$gbr[gambar]");}
						}
						mysql_query("UPDATE tabel_tentang_kami SET gambar = '$nama_file_baru' WHERE id_tentang_kami = '$_POST[id]'");	
					}
					
				}

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
				
				if (!empty($lok_banner_mobile)){
					
					if($ft_banner_mobile=="image/jpeg" || $ft_banner_mobile=="image/jpg" || $ft_banner_mobile=="image/png" || $ft_banner_mobile=="image/gif"){
					
						$file1 = str_replace(" ", "-", $fn_banner_mobile);
						$prefix1 = rand(00000,99999);
						$fn_banner_mobile_fin = $prefix1.''.$file1;
						move_uploaded_file($lok_banner_mobile,"../images/banner/$fn_banner_mobile_fin");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_tentang_kami WHERE id_berkelanjutan = '$_POST[id]'"));
						if (!empty($gbr['banner_mobile'])) 
						{
							if (file_exists("../images/banner/$gbr[banner_mobile]"))
							{unlink("../images/banner/$gbr[banner_mobile]");}
						}
						mysql_query("UPDATE tabel_tentang_kami SET banner_mobile = '$fn_banner_mobile_fin' WHERE id_berkelanjutan = '$_POST[id]'");	
					}
					
				}
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=tentang')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

