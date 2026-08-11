<?php
	include "configuration/path.php";
	
    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, banner FROM tabel_about_us WHERE id_about_us = '2'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<!--<li>-->
					<!--	<div class="language-menu">-->
					<!--		<a href="<?php echo "$nama_folder/logo_kami";?>" class="language-btn">INA</a>-->
					<!--		<a href="<?php echo "$nama_folder/en/logo_kami";?>" class="language-btn active">ENG</a>-->
					<!--	</div>-->
					<!--</li>-->
					
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder/logo_kami";?>" class="language-btn text-12">INDONESIA</a>
							<div class="text-white set-line">|</div>
							<a href="<?php echo "$nama_folder/en/logo_kami";?>" class="language-btn text-12 active">ENGLISH</a>
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
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" alt="" style="width: 100%;">
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
                        <h3 class="service-details__services-title">About Us</h3>
                        <ul class="service-details__services-list list-unstyled">
                            <li><a href="<?php echo "$nama_website/profil_kami";?>">About Us</a></li>
                            <li class="active"><a href="<?php echo "$nama_website/logo_kami";?>">Our Logo</a></li>
                            <li><a href="<?php echo "$nama_website/visi_misi";?>">Vision, Mission and Values</a></li>
                            <li><a href="<?php echo "$nama_website/peristiwa_penting";?>">Milestones</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_kepemilikan";?>">Ownership Structure</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_organisasi";?>">Organization Structure</a></li>
                            <li><a href="<?php echo "$nama_website/dewan_komisaris";?>">Board of Commissioners</a></li>
                            <li><a href="<?php echo "$nama_website/direksi";?>">Board of Directors</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_group";?>">Group Structure</a></li>
                            <li><a href="<?php echo "$nama_website/anak_perusahaan_kami";?>">Our Subsidiaries</a></li>
                            <li><a href="<?php echo "$nama_website/penghargaan";?>">Awards & Recognition</a></li>
                            <li><a href="<?php echo "$nama_website/keanggotaan";?>">Membership</a></li>
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

