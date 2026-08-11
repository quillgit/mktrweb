<?php
	function form_2(){

		if 	(($_GET['mod']=='edit_dokumen'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_pelaporan_pelanggaran WHERE id_pelaporan_pelanggaran = '$id'"));
			$nama_pelapor 			= stripslashes($edit['nama_pelapor']);
			$telepon_pelapor 					= stripslashes($edit['telepon_pelapor']);
            $email_pelapor 			= stripslashes($edit['email_pelapor']);
			$nama_terlapor				= stripslashes($edit['nama_terlapor']);
            $jabatan_terlapor					= stripslashes($edit['jabatan_terlapor']);
			$waktu_kejadian					= stripslashes($edit['waktu_kejadian']);
			$lokasi_kejadian 			= stripslashes($edit['lokasi_kejadian']);
			$kronologis_kejadian 		= stripslashes($edit['kronologis_kejadian']);
			$nominal 		= stripslashes($edit['nominal']);
			$from = 'edit_dokumen';
		}
		else
		{ 
			$id 					= isset($_POST['id']) ? $_POST['id']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Formulir Pelaporan Whistleblowing System</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM tabel_pelaporan_pelanggaran WHERE id_pelaporan_pelanggaran = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
                                        <div class="row">
										
                                            <div class="col-md-12 col-12">
												<h6>Nama Pelapor</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$nama_pelapor"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Telepon Pelapor</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$telepon_pelapor"; ?>" readonly/>
                                                </div>
                                            </div>

											<div class="col-md-12 col-12">
												<h6>Email Pelapor</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$email_pelapor"; ?>" readonly/>
                                                </div>
                                            </div>
                                         </div>   
                                            <hr>
                                            
                                            
                                            <div class="row">

											<div class="col-md-12 col-12">
												<h6>Nama Terlapor</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$nama_terlapor"; ?>" readonly/>
                                                </div>
                                            </div>
                                            
                                            

											<div class="col-md-12 col-12">
												<h6>Jabatan Terlapor</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$jabatan_terlapor"; ?>" readonly/>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12 col-12">
												<h6>Tindakan</h6>
												
												<?php
												$tindakan = mysql_query("SELECT * FROM trs_pelaporan_pelanggaran_tindakan WHERE id_pelaporan_pelanggaran = '$id'");
							while ($list_tindakan = mysql_fetch_array($tindakan)){
												?>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$list_tindakan[tindakan]"; ?>" readonly/>
                                                </div>
                                                
                                            <?php
							}
							?>
                                            </div>
                                            
                                            
                                            <hr>

											<div class="col-md-12 col-12">
												<h6>Waktu Kejadian</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="title" value="<?php echo"$waktu_kejadian"; ?>" readonly/>
                                                </div>
                                            </div>
                                            
											
											<div class="col-md-12 col-12">
												<h6>Lokasi Kejadian</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="communication" value="<?php echo"$lokasi_kejadian"; ?>" readonly/>
                                                </div>
                                            </div>
                                            
                                            	<div class="col-md-12 col-12">
												<h6>Kronologis Kejadian</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="communication" value="<?php echo"$kronologis_kejadian"; ?>" readonly/>
                                                </div>
                                            </div>
                                            
                                            	<div class="col-md-12 col-12">
												<h6>Nominal</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="communication" value="<?php echo"$nominal"; ?>" readonly/>
                                                </div>
                                            </div>

											
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Approve</button>
                                                <a href="admin.php?menu=pelaporan_pelanggaran" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
						<h2 class="content-header-title float-left mb-0">Formulir Pelaporan Whistleblowing System</h2>
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
								<th>Nama Pelapor</th>
								<th>Telepon Pelapor</th>
								<th>Email Pelapor</th>
                                <th>Nama Terlapor</th>
								<th>Jabatan Terlapor</th>
								 <th>Tindakan</th>
                                <th>Waktu Kejadian</th>
								<th>Lokasi Kejadian</th>
								<th>Kronologis Kejadian</th>
								<th>Nominal</th>
                                <th>Status</th>
								<th>Created</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody id="product-list">
							<?php
							$no = 1;
							$banner = mysql_query("SELECT * FROM tabel_pelaporan_pelanggaran ORDER BY created DESC");
							while ($list = mysql_fetch_array($banner)){

								if($list['status'] == "1"){
									$status = "<span style='color:red; font-size:16px;'>Laporan</span>";
								}else{
									$status = "<span style='color:blue; font-size:16px;'>Sudah di Tindak</span>";
								}
							echo "
							<tr>
								<td align='center'>$no</td>
								<td><b>$list[nama_pelapor]</b></td>
								<td><b>$list[telepon_pelapor]</b></td>
								<td><b>$list[email_pelapor]</b></td>
                                <td>$list[nama_terlapor]</td>
								<td>$list[jabatan_terlapor]</td>
                                <td>";
                                
                                $banner2 = mysql_query("SELECT * FROM trs_pelaporan_pelanggaran_tindakan WHERE id_pelaporan_pelanggaran = '$list[id_pelaporan_pelanggaran]'");
							while ($list2 = mysql_fetch_array($banner2)){
							    echo "- $list2[tindakan] <br>";
							}
                                
                                echo "</td>
								<td>$list[waktu_kejadian]</td>
								<td>$list[lokasi_kejadian]</td>
								<td>$list[kronologis_kejadian]</td>
								<td>$list[nominal]</td>
								<td>$status</td>
								<td>$list[created]</td>
								<td align='center'><a href='?menu=$_GET[menu]&mod=edit_dokumen&id=$list[id_pelaporan_pelanggaran]'><img src=img/edit.png border=0 /></a> ";
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
			
			$update = "UPDATE tabel_pelaporan_pelanggaran SET	status = '2',
												 updated = '$date',
												 updater = '$_SESSION[namauser]'
												WHERE id_pelaporan_pelanggaran = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
		
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=pelaporan_pelanggaran')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form_2();
			}
		}
	}
	?>

