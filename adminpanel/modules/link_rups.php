<?php
	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_link WHERE id_link = '$id'"));
			$title 				= stripslashes($edit['title']);
			$link 	    	    = stripslashes($edit['link']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$title 				= isset($_POST['title']) ? $_POST['title']:''; 
			$link 		= isset($_POST['link']) ? $_POST['link']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Link Rups</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_link WHERE id_link = '$id'"));
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
												<h6>Link</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="link" value="<?php echo"$link"; ?>" placeholder="Link ..."/>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=link_rups" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_link WHERE id_link = '$id'"));
			$pic = isset($gbr['gambar']) ? $gbr['gambar']:'';
			$delete = "DELETE FROM tabel_link WHERE id_link ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../images/post/$pic"))
					{unlink("../images/post/$pic");}
				}
				
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=link_rups')</script>";
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
						<h2 class="content-header-title float-left mb-0">Link Rups</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								</li>
								<li class="breadcrumb-item active">Link Rups
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
								<th>Title</th>
								<th>Link</th>
								<th>Created</th>
								<th>Author</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
						<?php
						$no = 1;
						$data_db = mysql_query("SELECT * FROM tabel_link ORDER BY created DESC");
						while ($list = mysql_fetch_array($data_db)){
												
							echo "
								<tr>
									<td align='center'>$no</td>
									<td>$list[title]</td>
                                    <td>$list[link]</td>
                                    <td>$list[author]</td>
									<td>$list[created]</td>
									<td class='product-action'>
									<a href='?menu=link_rups&mod=edit&id=$list[id_link]'><i class='feather icon-edit'></i></a> |
									";
									
									?>
									
									<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_link]"; ?>"  onClick="return confirm('Delete : <?php echo "$list[title]"; ?>?')"><i class="feather icon-trash"></i></a>
									
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
		
			$title   	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
			$link   	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
		
			$add = "INSERT INTO tabel_link 
			(title, link, created, author) 
			VALUES 
			('$title', '$link', '$date', '$_SESSION[namauser]')";
						
			$query = mysql_query($add);
									
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=link_rups')</script>";
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
			$link   	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['link']));
			
			$update = "UPDATE tabel_link SET  title = '$title',
												link = '$link',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_link = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{

				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=link_rups')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

