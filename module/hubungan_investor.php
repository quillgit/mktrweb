<?php
	include "configuration/path.php";

    $slug = antiinjection($_GET['slug']);

    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, tipe, id_tentang_kami, kategori, child, banner, slug, slug_english, banner_mobile FROM tabel_tentang_kami WHERE slug = '$slug'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/hubungan_investor/$list_profile[slug]";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/hubungan_investor/$list_profile[slug_english]";?>" class="language-btn text-12">ENGLISH</a>
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
                        <h3 class="service-details__services-title">HUBUNGAN INVESTOR</h3>
                        <ul class="service-details__services-list list-unstyled">
                        <?php
                        if($list_profile['kategori'] != 'child'){
                            $menu_keberlanjutan = mysql_query("SELECT
                                tabel_tentang_kami.kategori, 
                                tabel_tentang_kami.title, 
                                tabel_tentang_kami.sub_title, 
                                tabel_tentang_kami.slug, 
                                tabel_tentang_kami.slug_english, 
                                tabel_tentang_kami.id_tentang_kami
                            FROM
                                tabel_tentang_kami
                            WHERE
                                tabel_tentang_kami.kategori != 'child' AND status = '2'");
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
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/hubungan_investor/$list_menu_keberlanjutan[slug]";?>"><?php echo "$list_menu_keberlanjutan[sub_title]";?> <?php echo $span;?></a></li>
                            <?php
                             if($list_menu_keberlanjutan['id_tentang_kami'] == $list_profile['id_tentang_kami']){
                                 $menu_keberlanjutan_child = mysql_query("SELECT
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
                                     tabel_tentang_kami.child = '$list_profile[id_tentang_kami]' AND status = '2'");
                                 while ($list_menu_keberlanjutan_child = mysql_fetch_array($menu_keberlanjutan_child))
                                 {
                                 ?>  
                                 <li><a href="<?php echo "$nama_folder/hubungan_investor/$list_menu_keberlanjutan_child[slug]";?>" style="text-transform: none; margin-left:5%;"><?php echo $list_menu_keberlanjutan_child['sub_title'];?></a></li>
                             <?php
                                 }
                             }
                             ?>
                            
                            <?php
                            }
                        }else{

                            $menu_keberlanjutan_parent2 = mysql_fetch_array(mysql_query("SELECT
                                     tabel_tentang_kami.kategori, 
                                     tabel_tentang_kami.title, 
                                     tabel_tentang_kami.sub_title, 
                                     tabel_tentang_kami.slug, 
                                     tabel_tentang_kami.slug_english, 
                                     tabel_tentang_kami.id_tentang_kami
                                 FROM
                                     tabel_tentang_kami
                                 WHERE
                                     tabel_tentang_kami.id_tentang_kami = '$list_profile[child]' AND status = '2'"));
                        ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/hubungan_investor/$menu_keberlanjutan_parent2[slug]";?>"><?php echo "$menu_keberlanjutan_parent2[sub_title]";?> <span class='icon-angle-right'></span></a></li>
                            
                        <?php
                       
                            $menu_keberlanjutan = mysql_query("SELECT
                                tabel_tentang_kami.kategori, 
                                tabel_tentang_kami.title, 
                                tabel_tentang_kami.sub_title, 
                                tabel_tentang_kami.slug, 
                                tabel_tentang_kami.slug_english, 
                                tabel_tentang_kami.id_tentang_kami
                            FROM
                                tabel_tentang_kami
                            WHERE
                                tabel_tentang_kami.child = '$list_profile[child]' AND status = '2'");
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
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/hubungan_investor/$list_menu_keberlanjutan[slug]";?>" style="text-transform: none; margin-left:5%;"><?php echo "$list_menu_keberlanjutan[sub_title]";?> <?php echo $span;?></a></li>
                            

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
                        <div class="shop-details-page1__img-inner mb-5">
                            <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>" alt="image" id="item-main-image">
                        </div>
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

                    if($list_profile['id_tentang_kami'] == '2'){
                ?>
                    
                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Keterbukaan Informasi
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_keterbukaan_informasi, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_keterbukaan_informasi WHERE status = '2'");
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
                    }else if($list_profile['id_tentang_kami'] == '4'){
                    ?>

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                            Propektus
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                           $keanggotaan = mysql_query("SELECT id_laporan_prospektus, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_prospektus WHERE status = '2'");
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
                    }else if($list_profile['id_tentang_kami'] == '5'){
                    ?>

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Laporan Keuangan
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_keuangan , laporan_date, title, title_english, file_dokumen FROM tabel_laporan_keuangan WHERE status = '2'");
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
                    }else if($list_profile['id_tentang_kami'] == '7'){
                    ?>  

                    <!--blog-details-->
                    <div class="col-xl-8">
                        <section>
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Laporan Tahunan
                                            </h3>
                                            <div class="blog-details__content mb-3">
                                                <div class="row">

                                                <?php
                                                $keanggotaan = mysql_query("SELECT id_laporan_tahunan, gambar, title, title_english, file_dokumen FROM tabel_laporan_tahunan WHERE status = '2' ORDER BY created DESC");
                                                while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                                {
                                                ?>
                                                    <div class="col-lg-4 col-6 mb-5">
                                                        <img src="<?php echo "$nama_folder";?>/images/post/<?php echo "$list_keanggotaan[gambar]";?>" class="img-fluid img-laporan mb-3">
                                                        <div class="text-center line-height22 mb-2"><?php echo "$list_keanggotaan[title]";?></div>
                                                        <div class="text-center flex-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>"
                                                                class="ijo" target="_blank">
                                                                <div class="d-flex font-14">
                                                                    <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-15p">
                                                                    <div class="align-content-center">Unduh Laporan</div>
                                                                </div>
                                                            </a>
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
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_tentang_kami'] == '6'){
                    ?>  

                    <!--class="blog-details"-->
                    <div class="col-xl-8">
                        <section>
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                                Presentasi Perusahaan
                                            </h3>
                                            <div class="blog-details__content mb-3">
                                                <div class="row">

                                                <?php
                                                $keanggotaan = mysql_query("SELECT id_laporan_presentasi_perusahaan, gambar, title, title_english, sub_title, sub_title_english, file_dokumen FROM tabel_laporan_presentasi_perusahaan WHERE status = '2'");
                                                while ($list_keanggotaan = mysql_fetch_array($keanggotaan))
                                                {
                                                ?>
                                                    <div class="col-lg-4 col-6 mb-5">
                                                        <img src="<?php echo "$nama_folder";?>/images/post/<?php echo "$list_keanggotaan[gambar]";?>" class="img-fluid img-laporan mb-3">
                                                        <div class="text-center line-height22 mb-2"><?php echo "$list_keanggotaan[title]";?></div>
                                                        <div class="text-center flex-center">
                                                            <a href="<?php echo "$nama_folder/dokumen/$list_keanggotaan[file_dokumen]";?>"
                                                                class="ijo" target="_blank">
                                                                <div class="d-flex font-14">
                                                                    <img src="<?php echo "$nama_folder";?>/assets/images/icon/icon-download.png" class="width-15p">
                                                                    <div class="align-content-center">Unduh Laporan</div>
                                                                </div>
                                                            </a>
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
                            </div>
                        </section>
                    </div>

                    <?php
                    }else if($list_profile['id_tentang_kami'] == '12'){
                    ?>  

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                            Buletin Investo
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_buletin_investor, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_buletin_investor WHERE status = '2'");
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
                    }else if($list_profile['id_tentang_kami'] == '13'){
                    ?>  

                    <div class="col-xl-8">
                        <section class="blog-details">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-7">
                                        <div class="blog-details__left">
                                            <h3 class="blog-details__title">
                                            Laporan Operasional
                                            </h3>
                                            <div class="blog-details__img">
                                            <?php
                                            $keanggotaan = mysql_query("SELECT id_laporan_operasional, laporan_date, title, title_english, file_dokumen FROM tabel_laporan_operasional WHERE status = '2'");
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