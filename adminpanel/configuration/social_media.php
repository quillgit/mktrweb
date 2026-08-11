<?php

function form(){

	if 	(($_GET['mod']=='edit'))
	{
		$id = abs((int)$_GET['id']);
		$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_sosmed WHERE id_sosmed = '$id'"));
		$title = stripslashes($edit['title']);	
		$konten = stripslashes($edit['konten']);
		$hyperlink = stripslashes($edit['hyperlink']);	
		$job_looking_for = stripslashes($edit['job_looking_for']);
		$from = 'edit';
	}
	else
	{
		$id 				= !empty($_POST['id']);
		$title 				= !empty($_POST['title']);
		$konten 			= !empty($_POST['konten']);
		$hyperlink 			= !empty($_POST['hyperlink']);
		$job_looking_for 	= !empty($_POST['job_looking_for']);
		$from = 'process';
	}
?>

	<aside class="right-side">
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						
						<div class="box-header">
							
							<div>
								<h3 class="box-title">Career</h3>
							</div>
							
							<div style="margin-left:90%; margin-top:10px;">
								<a href="?menu=<?php echo"$_GET[menu]"; ?>"><img src='img/kembali.png' width='100'/></a>
							</div>
						
						</div><!-- /.box-header -->
						
						<!-- form start -->
						<form action="?menu=<?php echo"$_GET[menu]"; ?>&mod=<?php echo"$_GET[mod]"; 
							if ($_GET['mod']=='edit') echo "&id=$id"; ?>&act=process" method="post" enctype="multipart/form-data">
							<?php
							if ($_GET['mod']=='edit')
							{
							$id = abs((int)$_GET['id']);
							$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_sosmed WHERE id_sosmed = '$id'"));
							}
							?>
							<div class="box-body">
							
								<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
															
								<div class="form-group">
                                    <label>Career</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo"$title"; ?>" placeholder="Career ..."/>
                                </div>
								
								<div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" rows="3" name="konten" placeholder="Enter ..."><?php echo"$konten"; ?></textarea>
                                </div>

								<div class="form-group">
                                    <label>Job Description</label>
                                    <textarea class="form-control" rows="3" name="hyperlink" placeholder="Enter ..."><?php echo"$hyperlink"; ?></textarea>
                                </div>

								<div class="form-group">
                                    <label>Requirements</label>
                                    <textarea class="form-control" rows="3" name="job_looking_for" placeholder="Enter ..."><?php echo"$job_looking_for"; ?></textarea>
                                </div>
						
								<div class="form-group">
									<label for="exampleInputFile">Icon</label>
									<input type="file" id="exampleInputFile" name="icon">
								</div>
								<?php
									$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_sosmed WHERE id_sosmed = '$id'"));
									if (!empty($edit['icon']))
									{
										if (file_exists("../images/sebumi_img/sosmed/$edit[icon]"))
										{
										echo "<p><img src='../images/sebumi_img/sosmed/$edit[icon]' width='200' border= /><br />";
										?>
										</p>
										<?php
										}
									}
								?>
								
							</div><!-- /.box-body -->
							
							<div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>
					</div><!-- /.box -->

				</div><!--/.col (left) -->
			</div>
		</section>
	</aside>
<?php
}

if (empty($_GET['mod']))
{

	if (!empty($_GET['act']) ? $_GET['act'] : '' =='delete')
	{
		$id = abs((int)$_GET['id']);
		$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_sosmed WHERE id_sosmed = '$id'"));
		$pic = $gbr['icon'];
		$delete = "DELETE FROM tabel_sosmed WHERE id_sosmed ='$id'";				 
		$query = mysql_query($delete);
		if ($query)
		{
			if (!empty($pic)) 
			{ 
				if (file_exists("../images/sebumi_img/sosmed/$pic"))
				{unlink("../images/sebumi_img/sosmed/$pic");}
			}
		echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=social_media')</script>";
		}
		else
		{
		echo "<script>alert('Data Gagal di Delete');</script>";
		}
	}
?>
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Social Media
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Data Social Media</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
				  
					<div class="box">
						<div class="box-header">
							<h3 class="box-title"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new"><img src="img/add-icon.png"> Tambah</a></h3>
						</div><!-- /.box-header -->

						<div class="box-body table-responsive">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width="30px">No</th>
										<th>Social Media</th>
										<th>Hyper Link</th>
										<th width="200px">Icon </th>
										<th>Created</th>
										<th>Updated</th>
										<th>Author</th>
										<th width="100px">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$banner = mysql_query("SELECT * FROM tabel_sosmed ORDER BY created_at DESC");
									while ($list = mysql_fetch_array($banner)){															
									echo "
									<tr>
										<td align='center'>$no</td>
										<td>$list[judul]</td>
										<td>$list[hyperlink]</td>
										<td align='center'><img src='../images/sebumi_img/sosmed/$list[icon]' width='200px' heigh='100px'></td>
										<td>$list[created_at]</td>
										<td>$list[updated_at]</td>
										<td>$list[author]</td>
										<td align='center'><a href='?menu=$_GET[menu]&mod=edit&id=$list[id_sosmed]'><img src=img/edit.jpg border=0 /></a> ";
									?>
										<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id_sosmed]"; ?>" 
										onClick="return confirm('Delete : <?php echo "$list[id_sosmed]"; ?>?')"><img src="img/delete.jpg"/>
										</a></td>
									</tr>
									<?php
										$no++;
									}
									?>
								</tbody>
								<tfoot>
									<tr>
                                        <th width="30px">No</th>
										<th>Social Media</th>
										<th>Hyper Link</th>
										<th width="200px">Icon </th>
										<th>Created</th>
										<th>Updated</th>
										<th>Author</th>
										<th width="100px">Action</th>
									</tr>
								</tfoot>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>

		</section><!-- /.content -->
	</aside><!-- /.right-side -->
				
	<script type="text/javascript">
		$(function() {
			$("#example1").dataTable();
			$('#example2').dataTable({
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false
			});
		});
	</script>
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
		
		$lokasifile = $_FILES['icon']['tmp_name'];
		$namafile  = $_FILES['icon']['name'];
		$jenis_gambar 	= $_FILES['icon']['type'];
				
		$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
		$konten 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['konten']));
		$hyperlink			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['hyperlink']));
		$job_looking_for	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['job_looking_for']));
		$slug	     		= mysql_real_escape_string(slug($_POST['title']));
		
		if (!empty($lokasifile))
		{

			if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
            
                $file = str_replace(" ", "-", $namafile);
                $prefix = rand(000,999);
                $nama_file_baru = $prefix.''.$file;
                move_uploaded_file($lokasifile,"../images/sebumi_img/sosmed/$nama_file_baru");
                
            }

		}else{
			$nama_file_baru = "";
		}
		
		$add = "INSERT INTO tabel_sosmed 
		(`title`, icon, konten, hyperlink, job_looking_for, created_at, author) 
		VALUES 
		('$title', '$nama_file_baru', '$konten', '$hyperlink', '$job_looking_for', '$date', '$_SESSION[namauser]')";
			
		$query = mysql_query($add);
		
		$id_sosmed = mysql_insert_id();
		
		if ($query)
		{
			echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=social_media')</script>";
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
		
		$lokasifile = $_FILES['icon']['tmp_name'];
		$namafile   = $_FILES['icon']['name'];
		$jenis_gambar	= $_FILES['icon']['type'];
		
		$title   			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['title']));
		$konten 	 		= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['konten']));
		$hyperlink			= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['hyperlink']));
		$job_looking_for	= mysql_real_escape_string(str_replace("'", "&#39;", $_POST['job_looking_for']));
		$slug	     		= mysql_real_escape_string(slug($_POST['title']));
		
		$update = "UPDATE tabel_sosmed SET `title` = '$title',
											konten = '$konten',
											hyperlink = '$hyperlink',
											job_looking_for = '$job_looking_for',
											 updated_at = '$date',
											 updater = '$_SESSION[namauser]'
											WHERE id_sosmed = '$_POST[id]'";
											
											
		$query = mysql_query($update);
		if ($query)
		{
			
			if (!empty($lokasifile))
			{
				if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){

					$file = str_replace(" ", "-", $namafile);
					$prefix = rand(000,999);
					$nama_file_baru = $prefix.''.$file;
					move_uploaded_file($lokasifile,"../images/sebumi_img/sosmed/$nama_file_baru");
					
					$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_sosmed WHERE id_sosmed = '$_POST[id]'"));
					if (!empty($gbr['icon'])) 
					{
						if (file_exists("../images/sebumi_img/sosmed/$gbr[icon]"))
						{unlink("../images/sebumi_img/sosmed/$gbr[icon]");}
					}
					mysql_query("UPDATE tabel_sosmed SET icon = '$nama_file_baru' WHERE id_sosmed = '$_POST[id]'");
					
				}
			}
				
			echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=social_media')</script>";

		}
		else

		{
			echo "<script>alert('Data Gagal di Update');</script>";
			form();
		}
		
	}
}
?>