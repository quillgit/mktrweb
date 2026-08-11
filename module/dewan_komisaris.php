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
                            <a href="<?php echo "$nama_folder/dewan_komisaris";?>" class="language-btn active text-12">INDONESIA</a>
                            <div class="text-white set-line">|</div>
                            <a href="<?php echo "$nama_folder/en/dewan_komisaris";?>" class="language-btn text-12">ENGLISH</a>
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
            <!--<img src="assets/images/backgrounds/keterbukaan-info1.jpg" alt="" style="width: 100%;">-->
            <!--<img src="https://mktr-website.1kaki.tech/images/banner/59860keterbukaan-info1.jpg" alt="" style="width: 100%;">-->
            <img src="assets/images/backgrounds/bg1.jpg" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Dewan Komisaris</h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder";?>">Beranda</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li><a href="<?php echo "$nama_folder/struktur_organisasi";?>">Stuktur Organisasi</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li>Dewan Komisaris</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <section class="team-page">
        <div class="container-fluid">
            <div class="row flex-center">
                
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="bold black font-60">Manajemen Kami</h1>
                </div>
    
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="bold black">Dewan Komisaris</h1>
                </div>
                
                <?php
                $manajemen = mysql_query("SELECT * FROM tabel_struktur_organisasi WHERE kategori = 'dewan_komisaris' ORDER BY urutan ASC");
                while ($list_manajemen = mysql_fetch_array($manajemen))
                {
                ?>
                <div class="col-xl-2 col-lg-2 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="team-one__single">
                        <a href="<?php echo "$nama_folder/mktr_so/$list_manajemen[slug]";?>">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="<?php echo "$nama_folder";?>/images/manajemen/<?php echo "$list_manajemen[gambar]";?>" alt="">
                                </div>
                                <div class="team-one__content">
                                    <h3 class="team-one__title"><?php echo "$list_manajemen[title]";?></h3>
                                    <p class="team-one__sub-title"><?php echo "$list_manajemen[sub_title]";?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            
            <hr class="mb-5">
            </hr>
    
            <div class="col-lg-12 text-center mb-5">
                <h1 class="bold black">Dewan Direksi</h1>
            </div>
            
            <div class="row flex-center">

                <?php
                $direksi = mysql_query("SELECT * FROM tabel_struktur_organisasi WHERE kategori = 'dewan_direksi' ORDER BY urutan ASC");
                while ($list_direksi = mysql_fetch_array($direksi))
                {
                ?>
    
                <!-- DIREKSI -->
                <div class="col-xl-2 col-lg-2 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="team-one__single">
                        <a href="<?php echo "$nama_folder/mktr_so/$list_direksi[slug]";?>">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="<?php echo "$nama_folder";?>/images/manajemen/<?php echo "$list_direksi[gambar]";?>"
                                        alt="">
                                </div>
                                <div class="team-one__content">
                                    <h5 class="team-one__title"><?php echo "$list_direksi[title]";?></h5>
                                    <p class="team-one__sub-title"><?php echo "$list_direksi[sub_title]";?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
    
    
                <?php } ?>
            </div>
            
        </div>
    </section>

