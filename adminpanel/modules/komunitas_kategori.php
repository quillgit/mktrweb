<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_komunitas_kategori WHERE id_kategori = '$id'"));
			$title 				= stripslashes($edit['title']);
			$deskripsi 			= stripslashes($edit['deskripsi']);	
			$from = 'edit';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$title 					= isset($_POST['title']) ? $_POST['title']:''; 			
			$deskripsi 				= isset($_POST['deskripsi']) ? $_POST['deskripsi']:''; 			
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Kategori Komunitas</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_komunitas_kategori WHERE id_kategori = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Nama Kategori</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Title ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Deskripsi</h6>
                                                <div class="form-label-group">
													<textarea class="form-control" rows="3" name="deskripsi" placeholder="Deskripsi Kategori ..."><?php echo"$deskripsi"; ?></textarea>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=komunitas_kategori" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$delete = "DELETE FROM tabel_komunitas_kategori WHERE id_kategori ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=komunitas_kategori')</script>";
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
						<h2 class="content-header-title float-left mb-0">Kategori Komunitas</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item active">Data Kategori Komunitas
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
								<th>Nama Kategori</th>
								<th>Deskripsi</th>
								<th>Created</th>
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
		<script type="text/javascript" src="assets/js/menu/data-table-komunitas-kategori.js"></script>
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
					
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$deskripsi   		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['deskripsi']));
					
			$add = "INSERT INTO tabel_komunitas_kategori 
			(title, deskripsi, status, created, author) 
			VALUES 
			('$title', '$deskripsi',  '2', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
						
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=komunitas_kategori')</script>";
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
			
			$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$deskripsi   		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['deskripsi']));
			
			$update = "UPDATE tabel_komunitas_kategori SET  title = '$title',
													deskripsi = '$deskripsi',
													updated = '$date',
													updater = '$_SESSION[namauser]'
												WHERE id_kategori = '$_POST[id]'";
			$query = mysql_query($update);
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=komunitas_kategori')</script>";
			}
			else
			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

