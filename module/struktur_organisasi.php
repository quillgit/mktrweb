<?php
	include "configuration/path.php";
	
    $profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, banner FROM tabel_about_us WHERE id_about_us = '6'");
    $list_profile = mysql_fetch_array($profile);
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/struktur_organisasi";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/struktur_organisasi";?>" class="language-btn text-12">ENGLISH</a>
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
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_profile[banner]";?>" alt="" style="width: 100%;">
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
                        <h3 class="service-details__services-title">Tentang Kami</h3>
                        <ul class="service-details__services-list list-unstyled">
                            <li><a href="<?php echo "$nama_folder/profil_kami";?>">Profil Kami</a></li>
                            <li><a href="<?php echo "$nama_folder/logo_kami";?>">Logo Kami </a></li>
                            <li><a href="<?php echo "$nama_folder/visi_misi";?>">Visi Misi & Nilai-nilai </a></li>
                            <li><a href="<?php echo "$nama_folder/peristiwa_penting";?>">Peristiwa Penting </a></li>
                            <li><a href="<?php echo "$nama_folder/struktur_kepemilikan";?>">Struktur Kepemilikan </a></li>
                            <li class="active"><a href="<?php echo "$nama_folder/struktur_organisasi";?>">Struktur Organisasi </a></li>
                            <li><a href="<?php echo "$nama_folder/dewan_komisaris";?>">Dewan Komisaris </a></li>
                            <li><a href="<?php echo "$nama_folder/direksi";?>">Direksi </a></li>
                            <li><a href="<?php echo "$nama_folder/struktur_group";?>">Struktur Group </a></li>
                            <li><a href="<?php echo "$nama_folder/anak_perusahaan_kami";?>">Anak Perusahaan Kami </a></li>
                            <li><a href="<?php echo "$nama_folder/penghargaan";?>">Penghargaan & Pengakuan</a></li>
                            <li><a href="<?php echo "$nama_folder/keanggotaan";?>">Keanggotaan</a></li>
                        </ul>
                    </div>
                </div>

                <!--Start Shop Details Page1 Img-->
                <div class="col-xl-8">
                    <div class="shop-details-page1__img">
                        <div class="shop-details-page1__img-inner mb-5">
                            
                            <div class="shop-details-page1__title">
                                <h2 id="item-title"><?php echo "$list_profile[sub_title]";?></h2>
                            </div>
                            
                            <a data-fslightbox="gallery"
                                href="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>">
                                <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>"
                                    alt="" title="KLIK GAMBAR UNTUK LEBIH KELAS">
                            </a>
                            
                            <!--<img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>" alt="image" id="item-main-image">-->
                        </div>

                        <div>
                            <!--<div class="shop-details-page1__title">-->
                            <!--    <h2 id="item-title"><?php echo "$list_profile[sub_title]";?></h2>-->
                            <!--</div>-->
                            <div class="shop-details-page1__text">
                                <?php echo "$list_profile[description]";?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

