<?php
include "configuration/path.php";

// PROFIL KAMI 
$profile = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, banner FROM tabel_about_us WHERE id_about_us = '1'");
$list_profile = mysql_fetch_array($profile);

// LOGO KAMI
$logo_kami = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, banner FROM tabel_about_us WHERE id_about_us = '2'");
$list_logo_kami = mysql_fetch_array($logo_kami);

// VISI MISI
$visi_misi = mysql_query("SELECT sub_title, description, sub_title_english, description_english, gambar, banner FROM tabel_about_us WHERE id_about_us = '3'");
$list_visi_misi = mysql_fetch_array($visi_misi);


?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
                            <a href="<?php echo "$nama_folder/logo_kami#Logo_Kami";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/logo_kami";?>" class="language-btn text-12">ENGLISH</a>
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
            <img src="<?php echo "$nama_folder";?>/images/banner/<?php echo "$list_logo_kami[banner]";?>" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3><?php echo "$list_logo_kami[sub_title]";?></h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><?php echo "$list_logo_kami[sub_title]";?></li>
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
                            
                            <!--<li><a href="<?php echo "$nama_folder/profil_kami";?>">Profil Kami</a></li>-->
                            <!--<li  class="active"><a href="<?php echo "$nama_folder/logo_kami";?>">Logo Kami </a></li>-->
                            <!--<li><a href="<?php echo "$nama_folder/visi_misi";?>">Visi Misi & Nilai-nilai </a></li>-->
                            
                            <li>
                                <a href="<?php echo "$nama_folder/profil_kami#Profil_Kami";?>">Profil Kami</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo "$nama_folder/logo_kami#Logo_Kami";?>">Logo Kami</a>
                            </li>
                            <li>
                                <a href="<?php echo "$nama_folder/visi_misi#Visi_Misi";?>">Visi Misi & Nilai-nilai </a>
                            </li>
                            
                            <li><a href="<?php echo "$nama_folder/peristiwa_penting";?>">Peristiwa Penting </a></li>
                            <li><a href="<?php echo "$nama_folder/struktur_kepemilikan";?>">Struktur Kepemilikan </a></li>
                            <li><a href="<?php echo "$nama_folder/struktur_organisasi";?>">Struktur Organisasi </a></li>
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
    
                    <!-- IMAGE KOLASE -->
                    <div class="row mb-3">
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                            <div class="project-one__single">
                                <div class="project-one__img-box ">
                                    <a data-fslightbox="gallery" href="images/about/431_MKT7617-min.JPG">
                                        <div class="project-one__img height-45p">
                                            <img src="<?php echo "$nama_folder";?>/images/about/431_MKT7617-min.JPG"
                                                class="setting-img1" title="KLIK GAMBAR UNTUK LEBIH JELAS">
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="project-one__single">
                                <div class="project-one__img-box">
                                    <a data-fslightbox="gallery" href="images/about/8523119987826636slider-new2.jpg">
                                        <div class="project-one__img height-45p">
                                            <img src="<?php echo "$nama_folder";?>/images/about/8523119987826636slider-new2.jpg"
                                                class="setting-img1" title="KLIK GAMBAR UNTUK LEBIH JELAS">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                            <div class="project-one__single">
                                <div class="project-one__img-box">
                                    <a data-fslightbox="gallery" href="images/about/3483d-MKTR.png">
                                        <div class="project-one__img">
                                            <img src="<?php echo "$nama_folder";?>/images/about/3483d-MKTR.png"
                                                title="KLIK GAMBAR UNTUK LEBIH JELAS" class="setting-img2">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <hr class="mb-5">
                    </hr>
    
                    <div class="shop-details-page1__img">
    
                        <!-- SECTION PROFIL KAMI  -->
                        <section id="Profil_Kami" class="mb-5">
                            <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_profile[gambar]";?>"
                                class="img-fluid radius-20 mb-4" alt="" title="KLIK GAMBAR UNTUK LEBIH KELAS">
    
                            <div class="shop-details-page1__title">
                                <h2 id="item-title"><?php echo "$list_profile[sub_title]";?></h2>
                            </div>
                            <div class="shop-details-page1__text">
                                <?php echo "$list_profile[description]";?>
                            </div>
                        </section>
    
                        <hr class="mb-3">
                        </hr>
    
                        <!-- SECTION LOGO KAMI  -->
                        <section id="Logo_Kami" class="mb-5">
                            <div class="text-center">
                                <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_logo_kami[gambar]";?>"
                                    class="img-fluid w-75 radius-20 mb-4" alt="" title="KLIK GAMBAR UNTUK LEBIH KELAS">
                            </div>
                            <div class="shop-details-page1__title">
                                <h2 id="item-title"><?php echo "$list_logo_kami[sub_title]";?></h2>
                            </div>
                            <div class="shop-details-page1__text">
                                <?php echo "$list_logo_kami[description]";?>
                            </div>
                        </section>
    
                        <hr class="mb-5">
                        </hr>
    
                        <!-- SECTION VISI MISI  -->
                        <section id="Visi_Misi" class="mb-5">
    
                            <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_visi_misi[gambar]";?>"
                                class="img-fluid radius-20 mb-4" alt="" title="KLIK GAMBAR UNTUK LEBIH KELAS">
    
    
                            <div class="shop-details-page1__title">
                                <h2 id="item-title"><?php echo "$list_visi_misi[sub_title]";?></h2>
                            </div>
                            <div class="shop-details-page1__text">
                                <?php echo "$list_visi_misi[description]";?>
                            </div>
                        </section>
    
                    </div>
    
                </div>

            </div>

        </div>

    </section>

