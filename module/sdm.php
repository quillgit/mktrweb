<?php
	include "configuration/path.php";

    $slug = antiinjection($_GET['slug']);

    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, tipe, id_sumber_daya, banner, slug, slug_english, banner_mobile FROM tabel_sumber_daya WHERE slug = '$slug'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/sdm/$list_profile[slug]";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/sdm/$list_profile[slug_english]";?>" class="language-btn text-12">ENGLISH</a>
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

                                    <li><a href="<?php echo "$nama_folder/karir";?>" style="text-transform: none;"><?php echo "$list_menu_keberlanjutan[sub_title]";?></a></li>
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
                }
                ?>

            </div>

        </div>

    </section>