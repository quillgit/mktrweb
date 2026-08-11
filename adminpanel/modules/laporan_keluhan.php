<?php
	function form_2(){

		if 	(($_GET['mod']=='edit_dokumen'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_laporan_keluhan WHERE id_laporan_keluhan = '$id'"));
			$laporan_date 			= stripslashes($edit['laporan_date']);
			$name 					= stripslashes($edit['name']);
            $organization 			= stripslashes($edit['organization']);
			$address 				= stripslashes($edit['address']);
            $email 					= stripslashes($edit['email']);
			$phone 					= stripslashes($edit['phone']);
			$communication 			= stripslashes($edit['communication']);
			$status_laporan 		= stripslashes($edit['status_laporan']);
			$from = 'edit_dokumen';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:''; 
			$status_laporan 		= isset($_POST['status_laporan']) ? $_POST['status_laporan']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Keluhan/Pengaduan</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_laporan_keluhan WHERE id_laporan_keluhan = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Laporan Date</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$laporan_date"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Name</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$name"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Occupation/Organization</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$organization"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Address</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$address"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Email</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$email"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Phone/Fax</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$phone"; ?>" readonly/>
                                                </div>
                                            </div>
                                            
											
											<div class="col-md-12 col-12">
												<h6>Preferred Language of Communication</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="communication" value="<?php echo"$communication"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Status</h6>
                                                <div class="form-label-group">
													<select name="status_laporan" class="form-control">

														<?php
														if($status_laporan == "laporan"){
															$select_laporan = "selected";
														}elseif($status_laporan == "dropped"){
															$select_dropped = "selected";
														}elseif($status_laporan == "closed"){
															$select_closed = "selected";
														}elseif($status_laporan == "monitoring"){
															$select_monitoring = "selected";
														}

														?>
														<option value="laporan" <?php echo $select_laporan;?>>Laporan</option>
														<option value="dropped"  <?php echo $select_dropped;?>>Dropped</option>
														<option value="closed"  <?php echo $select_closed;?>>Closed</option>
														<option value="monitoring"  <?php echo $select_monitoring;?>>Monitoring</option>

													</select>
                                                </div>
                                            </div>
											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=laporan_keluhan" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM tabel_laporan_keluhan WHERE id_laporan_keluhan = '$id'"));
			$pic = isset($gbr['file_dokumen']) ? $gbr['file_dokumen']:'';
			$delete = "DELETE FROM tabel_laporan_keluhan WHERE id_laporan_keluhan ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
				if (!empty($pic)) 
				{ 
					if (file_exists("../dokumen/$pic"))
					{unlink("../dokumen/$pic");}
				}
				
				echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=laporan_keluhan')</script>";
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
						<h2 class="content-header-title float-left mb-0">Daftar Keluhan/Pengaduan</h2>
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
								<th>Laporan Date</th>
								<th>Name</th>
								<th>Occupation/Organization</th>
                                <th>Address</th>
								<th>Email</th>
                                <th>Phone/Fax</th>
								<th>Preferred Language of Communication</th>
                                <th>Status</th>
								<th>Created</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_laporan_keluhan ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){

								if($list['status_laporan'] == "laporan"){
									$status = "<span style='color:grey; font-size:16px;'>Laporan</span>";
								}else if($list['status_laporan'] == "dropped"){
									$status = "<span style='color:red; font-size:18px;'>Dropped</span>";
								}else if($list['status_laporan'] == "closed"){
									$status = "<span style='color:green; font-size:18px;'>Closed</span>";
								}else{
									$status = "<span style='color:blue; font-size:18px;'>Monitoring</span>";
								}
							echo "
							<tr>
								<td align='center'>$no</td>
								<td>$list[laporan_date]</td>
								<td>$list[name]</td>
								<td>$list[organization]</td>
                                <td>$list[address]</td>
								<td>$list[email]</td>
                                <td>$list[phone]</td>
								<td>$list[communication]</td>
								<td>$status</td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit_dokumen&id=$list[id_laporan_keluhan]'><img src=img/edit.png border=0 /></a> ";
							?>
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
			
			$status_laporan 	    = mysql_real_escape_string(str_replace("'", "&#39;", $_POST['status_laporan']));
			
			$update = "UPDATE tabel_laporan_keluhan SET  status_laporan = '$status_laporan',
												status = '2',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_laporan_keluhan = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
		
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=laporan_keluhan')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form_2();
			}
		}
	}
	?>

