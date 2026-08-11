<?php
	include "configuration/path.php";

    $slug = antiinjection($_GET['slug']);

    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, tipe, id_tatakelola_perusahaan, banner, slug, slug_english, banner_mobile FROM tabel_tatakelola_perusahaan WHERE slug = '$slug'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/tatakelola_perusahaan/$list_profile[slug]";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/tatakelola_perusahaan/$list_profile[slug_english]";?>" class="language-btn text-12">ENGLISH</a>
                        </div>
					</li>
				</ul>
				<div class="main-menu__top-right">
				    <a href="<?php echo "$nama_folder";?>/kontak_kami" class="text-white text-14">Kontak Kami</a>
					<div class="main-menu__social">
					    <a href="https://m.facebook.com/p/PT-Menthobi-Karyatama-Raya-Tbk-100081064625604" target="_blank"><i class="icon-facebook"></i></a>
                        <a href="https://instagram.com/mktr.id?igshid=MzRlODBiNWFlZA==" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/pt-menthobi-karyatama-raya/" target="_blank"><i class="icon-link-in"></i></a>
                        <a href="https://www.youtube.com/@mktr5433" target="_blank"><i class="fab fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>
		
		<?php
		header_menu();
		?>
	</header>

    <!--Page Header Start-->
    <section class="page-header" style="width: 100%; overflow: hidden;">
        <div class="page-header__shape-1" style="width: 100%;">
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" class="d-none d-xl-block" style="width: 100%;">
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner_mobile]";?>" class="d-block d-sm-none" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3><?php echo "$list_profile[sub_title]";?></h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><?php echo "$list_profile[sub_title]";?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <section class="blog-one">
        <div class="container">
            <div class="row mb-5">
                <div class="col-xl-4">
                    <div class="service-details__services-box">
                        <h3 class="service-details__services-title">TATA KELOLA PERUSAHAAN</h3>
                        <ul class="service-details__services-list list-unstyled">
                        <?php
                        if($list_profile['kategori'] != 'child'){
                            $menu_keberlanjutan = mysql_query("SELECT
                                tabel_tatakelola_perusahaan.kategori, 
                                tabel_tatakelola_perusahaan.title, 
                                tabel_tatakelola_perusahaan.sub_title, 
                                tabel_tatakelola_perusahaan.slug, 
                                tabel_tatakelola_perusahaan.slug_english, 
                                tabel_tatakelola_perusahaan.id_tatakelola_perusahaan
                            FROM
                                tabel_tatakelola_perusahaan
                            WHERE
                                tabel_tatakelola_perusahaan.kategori != 'child' AND status = '2'");
                            while ($list_menu_keberlanjutan = mysql_fetch_array($menu_keberlanjutan))
                            {
                                if($slug == $list_menu_keberlanjutan['slug']){
                                    $aktif = "class='active'";
                                }else{
                                    $aktif = "";
                                }

                                if($list_menu_keberlanjutan['kategori'] == "parent"){
                                    $span = "<span class='icon-angle-right'></span>";
                                }else{
                                    $span = "";
                                }
                            ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/tatakelola_perusahaan/$list_menu_keberlanjutan[slug]";?>" ><?php echo "$list_menu_keberlanjutan[sub_title]";?> <?php echo $span;?></a></li>
                            <?php
                             if($list_menu_keberlanjutan['id_tatakelola_perusahaan'] == $list_profile['id_tatakelola_perusahaan']){
                                 $menu_keberlanjutan_child = mysql_query("SELECT
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
                                     tabel_tatakelola_perusahaan.child = '$list_profile[id_tatakelola_perusahaan]' AND status = '2'");
                                 while ($list_menu_keberlanjutan_child = mysql_fetch_array($menu_keberlanjutan_child))
                                 {
                                 ?>  
                                 <li><a href="<?php echo "$nama_folder/tatakelola_perusahaan/$list_menu_keberlanjutan_child[slug]";?>" style="text-transform: none; margin-left:10%;"><?php echo $list_menu_keberlanjutan_child['sub_title'];?></a></li>
                             <?php
                                 }
                             }
                             ?>
                            
                            <?php
                            }
                        }else{

                            $menu_keberlanjutan_parent2 = mysql_fetch_array(mysql_query("SELECT
                                     tabel_tatakelola_perusahaan.kategori, 
                                     tabel_tatakelola_perusahaan.title, 
                                     tabel_tatakelola_perusahaan.sub_title, 
                                     tabel_tatakelola_perusahaan.slug, 
                                     tabel_tatakelola_perusahaan.slug_english, 
                                     tabel_tatakelola_perusahaan.id_tatakelola_perusahaan
                                 FROM
                                     tabel_tatakelola_perusahaan
                                 WHERE
                                     tabel_tatakelola_perusahaan.id_tatakelola_perusahaan = '$list_profile[child]' AND status = '2'"));
                        ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/tatakelola_perusahaan/$menu_keberlanjutan_parent2[slug]";?>"><?php echo "$menu_keberlanjutan_parent2[sub_title]";?> <span class='icon-angle-right'></span></a></li>
                            
                        <?php
                       
                            $menu_keberlanjutan = mysql_query("SELECT
                                tabel_tatakelola_perusahaan.kategori, 
                                tabel_tatakelola_perusahaan.title, 
                                tabel_tatakelola_perusahaan.sub_title, 
                                tabel_tatakelola_perusahaan.slug, 
                                tabel_tatakelola_perusahaan.slug_english, 
                                tabel_tatakelola_perusahaan.id_tatakelola_perusahaan
                            FROM
                                tabel_tatakelola_perusahaan
                            WHERE
                                tabel_tatakelola_perusahaan.child = '$list_profile[child]' AND status = '2'");
                            while ($list_menu_keberlanjutan = mysql_fetch_array($menu_keberlanjutan))
                            {
                                if($slug == $list_menu_keberlanjutan['slug']){
                                    $aktif = "class='active'";
                                }else{
                                    $aktif = "";
                                }

                                if($list_menu_keberlanjutan['kategori'] == "parent"){
                                    $span = "<span class='icon-angle-right'></span>";
                                }else{
                                    $span = "";
                                }
                            ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/tatakelola_perusahaan/$list_menu_keberlanjutan[slug]";?>"><?php echo "$list_menu_keberlanjutan[sub_title]";?> <?php echo $span;?></a></li>
                            

                        <?php
                            }
                        }
                        ?>
                            
                        </ul>
                    </div>
                </div>

                
                <?php
                if($list_profile['tipe'] == "text"){
                ?>
    
                <div class="col-xl-8">
                    <div class="shop-details-page1__img">
                        <div>
                            <div class="shop-details-page1__title">
                                <h2 id="item-title"><?php echo "$list_profile[sub_title]";?></h2>
                            </div>
                            <div class="shop-details-page1__text">
                                <?php echo "$list_profile[description]";?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                }else{

                    if($list_profile['id_tatakelola_perusahaan'] == '20'){
                ?>
                    
                    <div class="col-xl-8">
                        
                        <div class="shop-details-page1__img">
                            <div>
                                <div class="shop-details-page1__title">
                                    <h2 id="item-title"><?php echo "$list_profile[sub_title]";?></h2>
                                </div>
                                <div class="shop-details-page1__text">
                                    <?php echo "$list_profile[description]";?>
                                </div>
                            </div>
                        </div>

                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_rups, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_rups WHERE status = '2' ORDER BY laporan_date DESC");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>   
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Unduh</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_tatakelola_perusahaan'] == '3'){
                    ?>

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                            Anggaran Dasar
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_anggaran_dasar, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_anggaran_dasar WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>  
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Unduh</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>


                    <?php
                     }else if($list_profile['id_tatakelola_perusahaan'] == '14'){
                    ?>

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Kebijakan Tata Kelola Teknologi Informasi
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_kebijakan_tatakelola, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_kebijakan_tatakelola WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>  
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Unduh</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <?php
                     }else if($list_profile['id_tatakelola_perusahaan'] == '17'){
                    ?>  

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Transaksi Afiliasi
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $$keanggotaan = mysql_query("SELECT id_laporan_transaksi_afiliasi, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_transaksi_afiliasi WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Unduh</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_tatakelola_perusahaan'] == '22'){
                    ?>  

                    <div class="col-xl-8">
                        
                        <div class="shop-details-page1__img">
                            <div>
                                <div class="shop-details-page1__title">
                                    <h2 id="item-title"><?php echo "$list_profile[sub_title]";?></h2>
                                </div>
                                <div class="shop-details-page1__text">
                                    <?php echo "$list_profile[description]";?>
                                </div>
                            </div>
                        </div>

                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_pedoman, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_pedoman WHERE status = '2'");
                                            while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                            {
                                            ?>   
                                                <div class="row border-top border-bottom align-content-center">
                                                    <div class="col-lg-10 mt-3 mb-3 align-content-center">
                                                        <div><?php echo "$list_keanggotaan[title]";?></div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3 text-right">
                                                        <div class="text-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>" class="ijo" target="_blank">
                                                                <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-20p">
                                                                <div>Unduh</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                   
                <?php
                    }
                }
                ?>

            </div>

        </div>

    </section>