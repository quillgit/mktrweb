<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_about_us WHERE id_about_us = '$id'"));
			$title 				= stripslashes($edit['title']);
			$sub_title 			= stripslashes($edit['sub_title']);
			$content 			= stripslashes($edit['content']);
			$gambar 			= stripslashes($edit['gambar']);
			//$description 		= stripslashes($edit['description']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$sub_title 			= isset($_POST['sub_title']) ? $_POST['sub_title']:''; 
			//$description 		= isset($_POST['description']) ? $_POST['description']:'';
			$content 			= isset($_POST['content']) ? $_POST['content']:''; 
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Disclamer Pendaftaran</h4>
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
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Content</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="content" placeholder="Content ..."><?php echo"$content"; ?></textarea>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=ketentuan_pendaftaran" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
						<h2 class="content-header-title float-left mb-0">Disclamer Pendaftaran</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item"><a href="#">Pendaftaran</a>
								</li>
								<li class="breadcrumb-item active">Data
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
								<th>Judul</th>
								<th>Content</th>
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
		<script type="text/javascript" src="assets/js/menu/data-table-ketentuan-pendaftaran.js"></script>
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

			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			//$sub_title   		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['sub_title']));
			$content 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['content']));
			//$description 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['description']));
			
			$update = "UPDATE tabel_about_us SET  title = '$title',
													content = '$content',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_about_us = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=ketentuan_pendaftaran')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

