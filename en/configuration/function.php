<?php

	function konten(){
		
		if (empty($_GET['sct'])){
			
			include "module/home.php";

		 //======= TENTANG KAMI =========//
			
		}else if ($_GET['sct']=='profil_kami'){
		
			include "module/profil_kami.php";
			
		}else if ($_GET['sct']=='logo_kami'){
		
			include "module/logo_kami.php";
			
		}else if ($_GET['sct']=='visi_misi'){
		
			include "module/visi_misi.php";
			
		}else if ($_GET['sct']=='peristiwa_penting'){
		
			include "module/peristiwa_penting.php";
			
		}else if ($_GET['sct']=='struktur_kepemilikan'){
		
			include "module/struktur_kepemilikan.php";

        }else if ($_GET['sct']=='struktur_organisasi'){
		
			include "module/struktur_organisasi.php";
			
		}else if ($_GET['sct']=='dewan_komisaris'){
		
			include "module/dewan_komisaris.php";

        }else if ($_GET['sct']=='mktr_so'){
		
			include "module/mktr_so.php";
			
		}else if ($_GET['sct']=='direksi'){
		
			include "module/direksi.php";
			
		}else if ($_GET['sct']=='struktur_group'){
		
			include "module/struktur_group.php";
			
		}else if ($_GET['sct']=='anak_perusahaan_kami'){
		
			include "module/anak_perusahaan_kami.php";
			
		}else if ($_GET['sct']=='penghargaan'){
		
			include "module/penghargaan.php";
			
		}else if ($_GET['sct']=='keanggotaan'){
		
			include "module/keanggotaan.php";
			
        //======= BISNIS INTI  =========//

        }else if ($_GET['sct']=='bisnis_inti'){
            
            include "module/bisnis_inti.php";

        }else if ($_GET['sct']=='keberlanjutan'){
            
            include "module/keberlanjutan.php";

        }else if ($_GET['sct']=='tatakelola_perusahaan'){
            
            include "module/tatakelola_perusahaan.php";

        }else if ($_GET['sct']=='sdm'){
            
            include "module/sdm.php";

        }else if ($_GET['sct']=='hubungan_investor'){
            
            include "module/hubungan_investor.php";
        
        }else if ($_GET['sct']=='berita'){
            
            include "module/berita.php";

        }else if ($_GET['sct']=='berita_detail'){
		
            include "module/berita_detail.php";

        }else if ($_GET['sct']=='form_grievance'){
            
            include "module/form_grievance.php";

        }else if ($_GET['sct']=='pencarian'){
            
            include "module/pencarian.php";
			
        }else if ($_GET['sct']=='cari'){
            
            include "module/cari.php";
            
        }else if ($_GET['sct']=='karir'){
            
            include "module/karir.php";

        }else if ($_GET['sct']=='karir_detail'){
            
            include "module/karir_detail.php";

		}else if ($_GET['sct']=='404'){
		
			include "module/404.php";
			
		}else if ($_GET['sct']=='kontak_kami'){
            
            include "module/kontak_kami.php";
            
		}else if ($_GET['sct']=='pelaporan_pelanggaran'){
		
			include "module/pelaporan_pelanggaran.php";
			
		}else{
		
			include "home.php";
			
		}

	}

	
	function header_menu(){
		include "configuration/path.php";
	?>

        <nav class="main-menu">
			<div class="main-menu__wrapper">
				<div class="main-menu__wrapper-inner">
					<div class="main-menu__left">
						<div class="main-menu__logo">
							<a href="<?php echo "$nama_website";?>">
								<img src="<?php echo "$nama_folder";?>/assets/images/resources/3d MKTR.png" alt="" class="width-80 ">
							</a>
						</div>
						<div class="main-menu__main-menu-box">
							<a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
							<ul class="main-menu__list">
                                <li class="dropdown">
                                    <a href="#">About Us</a>
                                    <ul>
                                        <li><a href="<?php echo "$nama_website/profil_kami";?>">About Us</a></li>
                                        <li><a href="<?php echo "$nama_website/logo_kami";?>">Our Logo</a></li>
                                        <li><a href="<?php echo "$nama_website/visi_misi";?>">Vision, Mission and Values</a></li>
                                        <li><a href="<?php echo "$nama_website/peristiwa_penting";?>">Milestones</a></li>
                                        <li><a href="<?php echo "$nama_website/struktur_kepemilikan";?>">Ownership Structure</a></li>
                                        <li class="dropdown">
                                            <a href="<?php echo "$nama_website/struktur_organisasi";?>">Organization Structure</a>
                                            <ul>
                                                <li><a href="<?php echo "$nama_website/dewan_komisaris";?>">Board of Commissioners</a></li>
                                                <li><a href="<?php echo "$nama_website/direksi";?>">Board of Directors</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo "$nama_website/struktur_group";?>">Group Structure</a></li>
                                        <li><a href="<?php echo "$nama_website/anak_perusahaan_kami";?>">Our Subsidiaries</a></li>
                                        <li><a href="<?php echo "$nama_website/penghargaan";?>">Awards & Recognition</a></li>
                                        <li><a href="<?php echo "$nama_website/keanggotaan";?>">Membership</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Core Business</a>
                                    <ul>
                                        <?php
                                        $menu_bisnis_int = mysql_query("SELECT id_bisnis_inti, sub_title_english, sub_title, slug, slug_english FROM tabel_bisnis_inti");
                                        while ($list_menu_bisnis_int = mysql_fetch_array($menu_bisnis_int))
                                        {
                                        ?>
                                        <li><a href="<?php echo "$nama_website/bisnis/$list_menu_bisnis_int[slug_english]";?>"><?php echo $list_menu_bisnis_int['sub_title_english'];?></a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Sustainability</a>
                                    <ul>
                                        <?php
                                        $menu_keberlanjutan = mysql_query("SELECT
                                            tabel_berkelanjutan.kategori, 
                                            tabel_berkelanjutan.title, 
                                            tabel_berkelanjutan.sub_title, 
                                            tabel_berkelanjutan.child,
                                            tabel_berkelanjutan.description, 
                                            tabel_berkelanjutan.sub_title_english, 
                                            tabel_berkelanjutan.description_english, 
                                            tabel_berkelanjutan.slug, 
                                            tabel_berkelanjutan.slug_english, 
                                            tabel_berkelanjutan.id_berkelanjutan
                                        FROM
                                            tabel_berkelanjutan
                                        WHERE
                                            tabel_berkelanjutan.kategori != 'child' AND status = '2'");
                                        while ($list_menu_keberlanjutan = mysql_fetch_array($menu_keberlanjutan))
                                        {
                                        ?>  
                                        <li class="dropdown">
                                            <a href="<?php echo "$nama_website/keberlanjutan/$list_menu_keberlanjutan[slug_english]";?>"><?php echo $list_menu_keberlanjutan['sub_title_english'];?></a>
                                            <ul>
                                            <?php
                                            if($list_menu_keberlanjutan['kategori'] == 'parent'){
                                                $menu_keberlanjutan_child = mysql_query("SELECT
                                                    tabel_berkelanjutan.kategori, 
                                                    tabel_berkelanjutan.title, 
                                                    tabel_berkelanjutan.sub_title, 
                                                    tabel_berkelanjutan.description, 
                                                    tabel_berkelanjutan.sub_title_english, 
                                                    tabel_berkelanjutan.description_english, 
                                                    tabel_berkelanjutan.slug, 
                                                    tabel_berkelanjutan.slug_english, 
                                                    tabel_berkelanjutan.id_berkelanjutan
                                                FROM
                                                    tabel_berkelanjutan
                                                WHERE
                                                    tabel_berkelanjutan.child = '$list_menu_keberlanjutan[id_berkelanjutan]' AND status = '2'");
                                                while ($list_menu_keberlanjutan_child = mysql_fetch_array($menu_keberlanjutan_child))
                                                {
                                                ?>  
                                                <li><a href="<?php echo "$nama_website/keberlanjutan/$list_menu_keberlanjutan_child[slug_english]";?>"><?php echo $list_menu_keberlanjutan_child['sub_title_english'];?></a></li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </ul>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Corporate governance</a>
                                    <ul>
                                        <?php
                                        $menu_keberlanjutan1 = mysql_query("SELECT
                                            tabel_tatakelola_perusahaan.kategori, 
                                            tabel_tatakelola_perusahaan.title, 
                                            tabel_tatakelola_perusahaan.sub_title, 
                                            tabel_tatakelola_perusahaan.child,
                                            tabel_tatakelola_perusahaan.description, 
                                            tabel_tatakelola_perusahaan.sub_title_english, 
                                            tabel_tatakelola_perusahaan.description_english, 
                                            tabel_tatakelola_perusahaan.slug, 
                                            tabel_tatakelola_perusahaan.slug_english, 
                                            tabel_tatakelola_perusahaan.id_tatakelola_perusahaan
                                        FROM
                                            tabel_tatakelola_perusahaan
                                        WHERE
                                            tabel_tatakelola_perusahaan.kategori != 'child' AND status = '2'");
                                        while ($list_menu_keberlanjutan1 = mysql_fetch_array($menu_keberlanjutan1))
                                        {
                                        ?>  
                                        <li class="dropdown">
                                            <a href="<?php echo "$nama_website/tatakelola_perusahaan/$list_menu_keberlanjutan1[slug_english]";?>"><?php echo $list_menu_keberlanjutan1['sub_title_english'];?></a>
                                            <ul>
                                            <?php
                                            if($list_menu_keberlanjutan1['kategori'] == 'parent'){
                                                $menu_keberlanjutan_child1 = mysql_query("SELECT
                                                    tabel_tatakelola_perusahaan.kategori, 
                                                    tabel_tatakelola_perusahaan.title, 
                                                    tabel_tatakelola_perusahaan.sub_title, 
                                                    tabel_tatakelola_perusahaan.description, 
                                                    tabel_tatakelola_perusahaan.sub_title_english, 
                                                    tabel_tatakelola_perusahaan.description_english, 
                                                    tabel_tatakelola_perusahaan.slug, 
                                                    tabel_tatakelola_perusahaan.slug_english, 
                                                    tabel_tatakelola_perusahaan.id_tatakelola_perusahaan
                                                FROM
                                                    tabel_tatakelola_perusahaan
                                                WHERE
                                                    tabel_tatakelola_perusahaan.child = '$list_menu_keberlanjutan1[id_tatakelola_perusahaan]' AND status = '2'");
                                                while ($list_menu_keberlanjutan_child1 = mysql_fetch_array($menu_keberlanjutan_child1))
                                                {
                                                ?>  
                                                <li><a href="<?php echo "$nama_website/tatakelola_perusahaan/$list_menu_keberlanjutan_child1[slug_english]";?>"><?php echo $list_menu_keberlanjutan_child1['sub_title_english'];?></a></li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </ul>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Investor Relations</a>
                                    <ul>
                                        <?php
                                        $menu_hi = mysql_query("SELECT
                                        tabel_tentang_kami.kategori, 
                                        tabel_tentang_kami.title, 
                                        tabel_tentang_kami.sub_title, 
                                        tabel_tentang_kami.child,
                                        tabel_tentang_kami.description, 
                                        tabel_tentang_kami.sub_title_english, 
                                        tabel_tentang_kami.description_english, 
                                        tabel_tentang_kami.slug, 
                                        tabel_tentang_kami.slug_english, 
                                        tabel_tentang_kami.id_tentang_kami
                                        FROM
                                        tabel_tentang_kami
                                        WHERE
                                        tabel_tentang_kami.kategori != 'child' AND status = '2'");
                                        while ($list_menu_hi = mysql_fetch_array($menu_hi))
                                        {
                                        ?>  
                                        <li class="dropdown">
                                            <a href="<?php echo "$nama_website/hubungan_investor/$list_menu_hi[slug_english]";?>"><?php echo $list_menu_hi['sub_title_english'];?></a>
                                            <ul>
                                            <?php
                                            if($list_menu_hi['kategori'] == 'parent'){
                                                $menu_hi_child = mysql_query("SELECT
                                                tabel_tentang_kami.kategori, 
                                                tabel_tentang_kami.title, 
                                                tabel_tentang_kami.sub_title, 
                                                tabel_tentang_kami.description, 
                                                tabel_tentang_kami.sub_title_english, 
                                                tabel_tentang_kami.description_english, 
                                                tabel_tentang_kami.slug, 
                                                tabel_tentang_kami.slug_english, 
                                                tabel_tentang_kami.id_tentang_kami
                                                FROM
                                                tabel_tentang_kami
                                                WHERE
                                                tabel_tentang_kami.child = '$list_menu_hi[id_tentang_kami]'  AND status = '2'");
                                                while ($list_menu_hi_child = mysql_fetch_array($menu_hi_child))
                                                {
                                                ?>  
                                                <li><a href="<?php echo "$nama_website/hubungan_investor/$list_menu_hi_child[slug_english]";?>"><?php echo $list_menu_hi_child['sub_title_english'];?></a></li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </ul>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                        <li><a href="<?php echo "$nama_website/news";?>">News & Activities</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Human Resource</a>
                                    <ul>
                                        <?php
                                        $menu_sdm = mysql_query("SELECT
                                            tabel_sumber_daya.kategori, 
                                            tabel_sumber_daya.title, 
                                            tabel_sumber_daya.sub_title, 
                                            tabel_sumber_daya.child,
                                            tabel_sumber_daya.description, 
                                            tabel_sumber_daya.sub_title_english, 
                                            tabel_sumber_daya.description_english, 
                                            tabel_sumber_daya.slug, 
                                            tabel_sumber_daya.slug_english, 
                                            tabel_sumber_daya.id_sumber_daya
                                        FROM
                                            tabel_sumber_daya
                                        WHERE
                                            tabel_sumber_daya.kategori != 'child' AND status = '2' AND id_sumber_daya != '9'");
                                        while ($list_menu_sdm = mysql_fetch_array($menu_sdm))
                                        {
                                        ?>  
                                        <li class="dropdown">
                                            <a href="<?php echo "$nama_website/sdm/$list_menu_sdm[slug_english]";?>"><?php echo $list_menu_sdm['sub_title_english'];?></a>
                                            <ul>
                                            <?php
                                            if($list_menu_sdm['kategori'] == 'parent'){
                                                $menu_sdm_child = mysql_query("SELECT
                                                    tabel_sumber_daya.kategori, 
                                                    tabel_sumber_daya.title, 
                                                    tabel_sumber_daya.sub_title, 
                                                    tabel_sumber_daya.description, 
                                                    tabel_sumber_daya.sub_title_english, 
                                                    tabel_sumber_daya.description_english, 
                                                    tabel_sumber_daya.slug, 
                                                    tabel_sumber_daya.slug_english, 
                                                    tabel_sumber_daya.id_sumber_daya
                                                FROM
                                                    tabel_sumber_daya
                                                WHERE
                                                    tabel_sumber_daya.child = '$list_menu_sdm[id_sumber_daya]' AND status = '2'");
                                                while ($list_menu_sdm_child = mysql_fetch_array($menu_sdm_child))
                                                {
                                                ?>  
                                                <li><a href="<?php echo "$nama_website/sdm/$list_menu_sdm_child[slug_english]";?>"><?php echo $list_menu_sdm_child['sub_title_english'];?></a></li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </ul>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                        <li><a href="<?php echo "$nama_website/career";?>">Career</a></li>
                                    </ul>
                                </li>
                                <!--<li>-->
                                <!--    <a href="<?php echo "$nama_website/kontak_kami";?>">Contact Us</a>-->
                                <!--</li>-->
                            </ul>
						</div>
					</div>
					<div class="main-menu__right">
						<div class="main-menu__search-and-btn-box">
							<div class="main-menu__search-box">
								<a href="#"class="main-menu__search search-toggler icon-search-interface-symbol"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>

		
	<?php
	}
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return $rupiah;
	}
	
	function limitWord($string, $word_limit) {
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}
	
	function slug($str)
	{
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;
	}

    function TanggalBulan($date){
		
		$BulanIndo = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
	 
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);
	 
		$result = $tgl . "<br>" . $BulanIndo[(int)$bulan-1];		
		return($result);
		
	}
	
	function TanggalIndo($date){
		
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	 
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);
	 
		$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
		return($result);
		
	}
	
	function TanggalIndon($date){
		
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	 
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);
		$jam 	= substr($date, 11, 2);
		$menit 	= substr($date, 14, 2);
		$detik 	= substr($date, 17, 2);	
	 
		$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun . " Pukul ". $jam . ":". $menit . ":". $detik . " WIB";		
		return($result);
	}
		
	function antiinjection($data){
 
		$filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
		 
		return $filter_sql;
	 
	}
	
	function IntervalDays($CheckIn,$CheckOut){
		$CheckInX = explode("-", $CheckIn);
		$CheckOutX =  explode("-", $CheckOut);
		$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
		$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
		$interval =($date2 - $date1)/(3600*24);
		// returns numberofdays
		return  $interval ;
	}
	
	function give_alert($pesan) {
		echo "<script>alert('$pesan');</script>";
	}

	function go_to($path) {
		echo "<script>window.location.href='$path';</script>";
	}
	?>	