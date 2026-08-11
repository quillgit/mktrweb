<?php
	include "configuration/path.php";

    $slug = antiinjection($_GET['slug']);
    $profile = mysql_query("SELECT title, sub_title, description, sub_title_english, description_english, gambar, banner, slug, banner_mobile FROM tabel_bisnis_inti WHERE slug_english = '$slug'");
    $list_profile = mysql_fetch_array($profile);
	?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder/bisnis/$list_profile[slug]";?>" class="language-btn text-12">INDONESIA</a>
							<div class="text-white set-line">|</div>
							<a href="<?php echo "$nama_folder/en/$slug";?>" class="language-btn text-12 active">ENGLISH</a>
						</div>
					</li>
				</ul>
				<div class="main-menu__top-right">
				    <a href="<?php echo "$nama_folder/en";?>/kontak_kami" class="text-white text-14">Contact Us</a>
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
                <h3><?php echo "$list_profile[sub_title_english]";?></h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder/en";?>">Home</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><?php echo "$list_profile[sub_title_english]";?></li>
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
                        <h3 class="service-details__services-title">Core Business</h3>
                        <ul class="service-details__services-list list-unstyled">
                            <?php
                            $menu_bisnis_int = mysql_query("SELECT id_bisnis_inti, sub_title_english, sub_title, slug, slug_english FROM tabel_bisnis_inti");
                            while ($list_menu_bisnis_int = mysql_fetch_array($menu_bisnis_int))
                            {
                                if($slug == $list_menu_bisnis_int['slug_english']){
                                    $aktif = "class='active'";
                                }else{
                                    $aktif = "";
                                }
                            ?>
                            <li <?php echo $aktif;?>><a href="<?php echo "$nama_website/bisnis/$list_menu_bisnis_int[slug_english]";?>"><?php echo "$list_menu_bisnis_int[sub_title_english]";?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <!--Start Shop Details Page1 Img-->
                <div class="col-xl-8">
                    <div class="shop-details-page1__img">
                        <div class="shop-details-page1__img-inner mb-5">
                            
                            <a data-fslightbox="gallery"
                                href="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>">
                                <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>"
                                    alt="" title="KLIK GAMBAR UNTUK LEBIH KELAS">
                            </a>
                            
                            <!--<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>" alt="image" id="item-main-image">-->
                        </div>
                        <div>
                            <div class="shop-details-page1__title">
                                <h2 id="item-title"><?php echo "$list_profile[sub_title_english]";?></h2>
                            </div>
                            <div class="shop-details-page1__text">
                                <?php echo "$list_profile[description_english]";?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>
    
    
