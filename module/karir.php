    <?php
	include "configuration/path.php";
	
    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, tipe, id_sumber_daya, banner, slug, slug_english, banner_mobile FROM tabel_sumber_daya WHERE id_sumber_daya = '9'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/karir";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/career";?>" class="language-btn text-12">ENGLISH</a>
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
                            <h3 class="service-details__services-title">SUMBER DAYA MANUSIA</h3>
                            <ul class="service-details__services-list list-unstyled">
                                <?php
                                $menu_keberlanjutan = mysql_query("SELECT
                                    tabel_sumber_daya.kategori, 
                                    tabel_sumber_daya.title, 
                                    tabel_sumber_daya.sub_title, 
                                    tabel_sumber_daya.slug, 
                                    tabel_sumber_daya.slug_english, 
                                    tabel_sumber_daya.id_sumber_daya
                                FROM
                                    tabel_sumber_daya WHERE status = '2'");
                                while ($list_menu_keberlanjutan = mysql_fetch_array($menu_keberlanjutan))
                                {

                                    if($list_menu_keberlanjutan['id_sumber_daya'] == "9"){

                                    ?>

                                    <li class='active'><a href="<?php echo "$nama_folder/karir";?>" style="text-transform: none;"><?php echo "$list_menu_keberlanjutan[sub_title]";?></a></li>
                                    <?php
                                        
                                    }else{


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
                                    <li <?php echo $aktif;?>><a href="<?php echo "$nama_folder/sdm/$list_menu_keberlanjutan[slug]";?>" style="text-transform: none;"><?php echo "$list_menu_keberlanjutan[sub_title]";?> <?php echo $span;?></a></li>
                                <?php
                                    }
                                }
                                ?>
                                
                            </ul>
                        </div>
                </div>


                <!--Start Shop Details Page1 Img-->
                <div class="col-xl-8">
                    <div class="shop-details-page1__img">
                    
                        <div class="mb-3">
                         <?php echo "$list_profile[description]";?>
                        </div>

                        <div class="row">
                        <?php
                        $lowongan_kerja = mysql_query("SELECT id_lowongan_kerja, title_english, title, slug, slug_english, gambar FROM tabel_lowongan_kerja");
                        while ($list_lowongan_kerja = mysql_fetch_array($lowongan_kerja))
                        {
                        ?>
                            <div class="col-lg-4 mb-5">
                                <a href="<?php echo "$nama_folder/apply/$list_lowongan_kerja[id_lowongan_kerja]/$list_lowongan_kerja[slug]";?>">
                                    <div class="border padding-20 card-karir">
                                    <img src="<?php echo "$nama_folder/images/post/$list_lowongan_kerja[gambar]";?>" style="width:100%;"> 
                                        
                                        <div style="padding:10px;">
                                        <h5 class="ijo bold mb-2"><?php echo "$list_lowongan_kerja[title]";?></h5>
                                        <div><img src="<?php echo "$nama_folder";?>/assets/images/icon/resume1.png" class="width-10p">Kirim Lamaran</div>
                                        </div>
                                        
                                    </div>
                                </a>
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