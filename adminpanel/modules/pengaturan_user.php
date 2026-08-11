<?php
	function form_new(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM pw_users WHERE id = '$id'"));
			$username 			= stripslashes($edit['username']);	
			$nama_lengkap 		= stripslashes($edit['nama_lengkap']);	
			$tipe 				= stripslashes($edit['tipe']);	
			$akses 				= stripslashes($edit['akses']);
			$gambar 			= stripslashes($edit['gambar']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$username		= isset($_POST['username']) ? $_POST['username']:'';
			$password		= isset($_POST['password']) ? $_POST['password']:'';
			$nama_lengkap	= isset($_POST['nama_lengkap']) ? $_POST['nama_lengkap']:'';
			$tipe			= isset($_POST['tipe']) ? $_POST['tipe']:'';
			$gambar 		= isset($_POST['gambar']) ? $_POST['gambar']:'';
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-nama">Users</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM pw_users WHERE id = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
									
                                        <div class="row">
										
											<div class="col-md-12 col-12">
												<h6>Username (huruf kecil semua & tidak dispasi)</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="username" value="<?php echo"$username"; ?>" placeholder="Username ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Nama Lengkap</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="nama_lengkap" value="<?php echo"$nama_lengkap"; ?>" placeholder="Nama Lengkap ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Tipe</h6>	
												<div class="form-label-group">
													<select class="form-control" name="tipe" required="required">
														<option value="admin">Admin</option>
														<option value="admin_verify">Admin Verifikasi</option>											
													</select>
												</div>
											</div>
											
											<div class="col-md-12 col-12">
												<h6>Gambar <b>(200px x 200px)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar" required="required">
														<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                    </div>
                                                </fieldset>
                                            </div>
											
										</div>
										
										<hr>
										
										<div class="row">
										
											<div class="col-md-12 col-12">
												<h6>Password</h6>
                                                <div class="form-label-group">
													<input type="password" class="form-control" name="password" value="<?php echo"$password"; ?>" placeholder="Password ..."/>
                                                </div>
                                            </div>
											
										</div>
										
										
										<div class="row">
										
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=pengaturan_user" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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

	function form(){

		if 	(($_GET['mod']=='edit'))
		{
			$id = isset($_GET['id']) ? $_GET['id']:'';
			$edit = mysql_fetch_array(mysql_query("SELECT * FROM pw_users WHERE id = '$id'"));
			$username 			= stripslashes($edit['username']);	
			$nama_lengkap 		= stripslashes($edit['nama_lengkap']);	
			$tipe 				= stripslashes($edit['tipe']);	
			$akses 				= stripslashes($edit['akses']);
			$gambar 			= stripslashes($edit['gambar']);
			$from = 'edit';
		}
		else
		{ 
			$id 				= isset($_POST['id']) ? $_POST['id']:''; 
			$gambar 			= isset($_POST['gambar']) ? $_POST['gambar']:''; 
			$from = 'process';
		}
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-nama">Users</h4>
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
								$edit = mysql_fetch_array(mysql_query("SELECT * FROM pw_users WHERE id = '$id'"));
								}
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
									
                                        <div class="row">
										
											<div class="col-md-12 col-12">
												<h6>Username</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" value="<?php echo"$username"; ?>" readonly="readonly"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Nama Lengkap</h6>
                                                <div class="form-label-group">
													<input type="text" class="form-control" name="nama_lengkap" value="<?php echo"$nama_lengkap"; ?>" placeholder="Nama Lengkap ..." required="required"/>
                                                </div>
                                            </div>
											
											<div class="col-md-12 col-12">
												<h6>Tipe</h6>	
												<div class="form-label-group">
													<select class="form-control" name="tipe">
														<option value="<?php echo"$tipe"; ?>"><?php echo"$akses"; ?></option>
														<option value="admin">Admin</option>
														<option value="admin_verify">Admin Verifikasi</option>											
													</select>
												</div>
											</div>
											
											<div class="col-md-12 col-12">
												<h6>Gambar <b>(200px x 200px)</b></h6>
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar">
														<?php
														if ($_GET['mod']=='edit'){
														?>
                                                        <label class="custom-file-label" for="inputGroupFile01"><?php echo"$gambar"; ?></label>
														<?php
															if (file_exists("images/user/$gambar"))
															{
															echo "<p><img src='images/user/$gambar' width='200' border= /></p><br>";
															
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
											
										</div>
										
										<div class="row">
										
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                                <a href="admin.php?menu=pengaturan_user" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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


	function form_user(){

		$id 				= isset($_POST['id']) ? $_POST['id']:''; 
		$password 			= isset($_POST['password']) ? $_POST['password']:'';
		$from = 'process';
	?>

		<section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-nama">Ganti Password</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- form start -->
								<form action="?menu=<?php echo"$_GET[menu]"; ?>&mod=<?php echo"$_GET[mod]"; 
								if ($_GET['mod']=='edit_user') echo "&id=$id"; ?>&act=process" method="post" enctype="multipart/form-data">
								<?php
								$id = $_GET['id'];
								?>
								
									<input type="hidden" name="id" value="<?php echo"$id"; ?>" />
								
                                    <div class="form-body">
									
										<div class="row">

											<div class="col-md-12 col-12">
												<h6>New Password</h6>
                                                <div class="form-label-group">
													<input type="password" class="form-control" name="password" value="" placeholder="Password ..." required="required"/>
                                                </div>
                                            </div>
											
                                        </div>
										
										<div class="row">
										
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Ganti</button>
                                                <a href="admin.php?menu=pengaturan_user" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
			$id = abs((int)$_GET['id']);
			$gbr = mysql_fetch_array (mysql_query("SELECT * FROM pw_users WHERE id = '$id'"));
			$delete = "UPDATE pw_users SET password = '', status = '1' WHERE id ='$id'";				 
			$query = mysql_query($delete);
			if ($query)
			{
			echo "<script>alert('Data Berhasil di Delete');window.location=('admin.php?menu=pengaturan_user')</script>";
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
						 <h2 class="content-header-title float-left mb-0">Pengaturan User</h2>
						 <div class="breadcrumb-wrapper col-12">
							 <ol class="breadcrumb">
								 <li class="breadcrumb-item"><a href="admin.php?menu=home">Home</a>
								 </li>
								 <li class="breadcrumb-item active">User
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
				
				<h3 class="box-nama"><a href="?menu=<?php echo "$_GET[menu]"; ?>&mod=new"><i class='feather icon-plus'></i> Tambah Users</a></h3>
					
				<!-- dataTable starts -->
				<div class="table-responsive">
					<table class="table data-thumb-view">
						<thead>
							<tr>
								<th width="30px">No</th>
								<th>Username</th>
								<th>Nama User</th>
								<th>Akses User</th>
								<th>Profile</th>
								<th>Created</th>
								<th>Last Login</th>
								<th width="200px">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$no = 1;
						
						$user1   = mysql_fetch_array(mysql_query("SELECT * FROM pw_users where username = '$_SESSION[namauser]' AND status = '2'"));
											
						if($user1['tipe'] == 'admin'){
							
							$banner = mysql_query("SELECT * FROM pw_users WHERE status = '2' ORDER by created DESC");
							
						}else{
							
							$banner = mysql_query("SELECT * FROM pw_users where username = '$_SESSION[namauser]' AND status = '2'");
							
						}
						
						while ($list = mysql_fetch_array($banner)){
																	
							if($list['tipe'] == "admin"){
								$akses = "Admin";
							}else if($list['tipe'] == "admin_verify"){
								$akses = "Admin Verifikasi";
							}else{
								$akses = "Super Admin";
							}
												
							echo "
								<tr>
									<td align='center'>$no</td>
									<td>$list[username]</td>
									<td>$list[nama_lengkap]</td>
									<td>$akses</td>
									<td align='center'><img src='images/user/$list[gambar]' width='50px' heigh='50px'></td>
									<td>$list[created]</td>
									<td>$list[last_login]</td>
									<td class='product-action'>
									<a href='?menu=pengaturan_user&mod=edit&id=$list[id]'><i class='feather icon-edit'></i></a> | <a href='?menu=pengaturan_user&mod=edit_user&id=$list[id]'><i class='feather icon-user'></i></a> |
									";
									
									if($user1['tipe'] == 'admin'){
									?>
									
									<a href="?menu=<?php echo "$_GET[menu]"; ?>&act=delete&id=<?php echo "$list[id]"; ?>" 
											onClick="return confirm('Delete : <?php echo "$list[nama_lengkap]"; ?>?')"><i class="feather icon-trash"></i>
									
									<?php
									}
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
			
			<script src="app-assets/js/scripts/ui/data-list-view.js"></script>
			
		</div>
		<!-- Javascript load  -->
		
	<?php
	}
	elseif ($_GET['mod']=='new')
	{
		if (empty($_GET['act']))
		{
		
			form_new();
		
		}elseif ($_GET['act']=='process'){
			
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d');
			$lokasifile 	= $_FILES['gambar']['tmp_name'];
			$namafile   	= $_FILES['gambar']['name'];
			$jenis_gambar 	= $_FILES['gambar']['type'];
			
			$pecah = explode(".", $namafile);
			$jmlarray = count($pecah);
			$lastarray = $jmlarray - 1;
			$ekstensi = $pecah[$lastarray];
			
			$username		= antiinjection($_POST['username']);
			$password		= antiinjection(addslashes(strip_tags ($_POST['password'])));
			$nama_lengkap	= antiinjection($_POST['nama_lengkap']);
			$tipe			= antiinjection($_POST['tipe']);
			
			if (!empty($lokasifile))
			{

				if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
				
					$file = str_replace(" ", "-", $namafile);
					$prefix = rand(000,999);
					$nama_file_baru = $prefix.''.$file;
					move_uploaded_file($lokasifile,"images/user/$nama_file_baru");
					
				}

			}
			else
			{
				$nama_file_baru = "";
			}
			
			$cekuser = mysql_query("SELECT * FROM pw_users WHERE username = '$username'");
			$num_row = mysql_num_rows($cekuser);
			if ($num_row <> 0) {
				
				echo "<script>alert('User Sudah Terdaftar !');window.location=('admin.php?menu=pengaturan_user&mod=new')</script>";
				 
			}else{
				
			$password1 = password_hash($password, PASSWORD_DEFAULT);
			
			if($tipe == 'admin'){
				$aksesnya = "Admin";
			}elseif($tipe == 'admin_verify'){
				$aksesnya = "Admin Verifikasi";
			}
			
			$add = "INSERT INTO pw_users 
			(username, password, nama_lengkap, tipe, akses, gambar, created, status) 
			VALUES 
			('$username', '$password1', '$nama_lengkap', '$tipe', '$aksesnya', '$nama_file_baru', '$date', '2')";
			
			}
			
			$query = mysql_query($add);
			if ($query)
			{
				echo "<script>alert('Data Berhasil di Simpan');window.location=('admin.php?menu=pengaturan_user')</script>";
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
			
			$lokasifile 	= $_FILES['gambar']['tmp_name'];
			$namafile   	= $_FILES['gambar']['name'];
			$jenis_gambar 	= $_FILES['gambar']['type'];
			
			//$username		= antiinjection($_POST['username']);
			$nama_lengkap	= antiinjection($_POST['nama_lengkap']);
			$tipe			= antiinjection($_POST['tipe']);
			
			if($tipe == 'admin'){
				$aksesnya = "Admin";
			}elseif($tipe == 'admin_verify'){
				$aksesnya = "Admin Verifikasi";
			}
			
			$update = "UPDATE pw_users SET  	nama_lengkap = '$nama_lengkap',
													tipe = '$tipe',
													akses = '$aksesnya',
													status = '2'
												WHERE id = '$_POST[id]'";
												
												
			$query = mysql_query($update);
			if ($query)
			{
				
				if (!empty($lokasifile)){
					
					if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/png" || $jenis_gambar=="image/gif"){
					
						$file = str_replace(" ", "-", $namafile);
						$prefix = rand(000,999);
						$nama_file_baru = $prefix.''.$file;
						move_uploaded_file($lokasifile,"images/user/$nama_file_baru");
						
						$gbr = mysql_fetch_array (mysql_query("SELECT * FROM pw_users WHERE id = '$_POST[id]'"));
						if (!empty($gbr['gambar'])) 
						{
							if (file_exists("images/user/$gbr[gambar]"))
							{unlink("images/user/$gbr[gambar]");}
						}
						mysql_query("UPDATE pw_users SET gambar = '$nama_file_baru' WHERE id = '$_POST[id]'");	
					}
					
				}
				echo "<script>alert('Data Berhasil di Update');window.location=('admin.php?menu=pengaturan_user')</script>";
				
			}
			else

			{
				echo "<script>alert('Data Gagal di Update');</script>";
				form();
			}
		}
	}
	elseif ($_GET['mod']=='edit_user')
	{
		if (empty($_GET['act']))
		{
			form_user();
		}
		elseif ($_GET['act']=='process')
		{
			date_default_timezone_set("Asia/Bangkok");
			$date = date('Y-m-d H:i:s');
			
			$password			= antiinjection(addslashes(strip_tags ($_POST['password'])));
			$password1 			= password_hash($password, PASSWORD_DEFAULT);

			$update = "UPDATE pw_users SET  password = '$password1',
											updated = '$date',
											updater = '$_SESSION[namauser]'
											WHERE id = '$_POST[id]'";
			
			$query = mysql_query($update);
			if ($query)
			{
				echo "<script>alert('Password Berhasil di Update');window.location=('admin.php?menu=pengaturan_user')</script>";
				
			}
			else

			{
				echo "<script>alert('Password Gagal di Update');</script>";
				form();
			}
		}
	}
	?>

