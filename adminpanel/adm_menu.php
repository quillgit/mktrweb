			<div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mr-auto">
                        <a class="navbar-brand" href="?menu=home">
                            <img src="images/logo/logo_mktr.png" style="width: 50px" alt="Santa Maria Fatima logo">
							<div class="set-font-menu">MKTR CMS</div>
                        </a>
                    </li>
                    <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
                </ul>
            </div>
            <div class="shadow-bottom"></div>
            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

					<!--
					<li class="active nav-item"><a href="?menu=home"><i class="feather icon-home"></i><span class="menu-title" data-i18n="eCommerce">Dashboard</span></a>
					</li>-->

					<?php
					$user   = mysql_fetch_array(mysql_query("SELECT * FROM pw_users where username = '$_SESSION[namauser]'"));
					
					if($user['tipe'] == 'admin'){
						
						$qry = mysql_query("SELECT id_menu FROM menu where keterangan = 'admin' ORDER BY order_by ASC");
						
						while ($list1 = mysql_fetch_array($qry))
						{
							
							$list   = mysql_fetch_array(mysql_query("SELECT * FROM adm_menu where id = '$list1[id_menu]'"));
							
							if ($list['type']=='single')
							{
								
								if($_GET["menu"] == $list["menu"]) {
									echo "<li class='nav-item active'>";
								} else {
									echo "<li class='nav-item'>";
								}
								echo "
									<a href='?menu=$list[menu]'>
										<i class='$list[icon]'></i> <span>$list[judul]</span>
									</a>
								</li>
								";
							}						
							elseif ($list['type']=='parent')
							{
								echo 
								"
								<li class=' navigation-header'><span>$list[judul]</span>
								</li>
								";
								

								$qchild = mysql_query("SELECT adm_menu.* FROM adm_menu INNER JOIN menu ON adm_menu.id = menu.id_menu WHERE menu.keterangan = 'admin' AND parent = '$list[id]' ORDER BY id ASC");
								while ($child = mysql_fetch_row($qchild))
								{
									if($_GET["menu"] == $child[5]) {
										echo "<li class='nav-item active'>";
									} else {
										echo "<li class='nav-item'>";
									}
									echo "<a href='?menu=$child[5]'><i class='$child[4]'></i> $child[1]</a></li>";
									
									if($child[5] == 'pendaftaran_alumni'){
										
										$cek_register_new = mysql_num_rows(mysql_query("SELECT * FROM tabel_pendaftaran where status = '1'"));
										
										echo "<span class='badge badge badge-warning badge-pill float-right mr-2' style='margin-top:-30px;'>$cek_register_new</span>";
									
									}
									
								}	
							}
						}
						
					}else if($user['tipe'] == 'admin_verify'){
						
						$qry = mysql_query("SELECT id_menu FROM menu where keterangan = 'admin_verify' ORDER BY order_by ASC");
						
						while ($list1 = mysql_fetch_array($qry))
						{
							
							$list   = mysql_fetch_array(mysql_query("SELECT * FROM adm_menu where id = '$list1[id_menu]'"));
							
							if ($list['type']=='single')
							{
								
								if($_GET["menu"] == $list["menu"]) {
									echo "<li class='nav-item active'>";
								} else {
									echo "<li class='nav-item'>";
								}
								echo "
									<a href='?menu=$list[menu]'>
										<i class='$list[icon]'></i> <span>$list[judul]</span>
									</a>
								</li>
								";
							}						
							elseif ($list['type']=='parent')
							{
								echo 
								"
								<li class=' navigation-header'><span>$list[judul]</span>
								</li>
								";
								

								$qchild = mysql_query("SELECT adm_menu.* FROM adm_menu INNER JOIN menu ON adm_menu.id = menu.id_menu WHERE menu.keterangan = 'admin' AND parent = '$list[id]' ORDER BY id ASC");
								while ($child = mysql_fetch_row($qchild))
								{
									if($_GET["menu"] == $child[5]) {
										echo "<li class='nav-item active'>";
									} else {
										echo "<li class='nav-item'>";
									}
									echo "<a href='?menu=$child[5]'><i class='$child[4]'></i> $child[1]</a></li>";
									
								}	
							}
						}
					}
					
					?>

                </ul>
            </div>