<?php
	include "configuration/path.php";
    ?>

    <header class="main-header">
		<div class="main-menu__top">
			<div class="main-menu__top-inner">
				<ul class="list-unstyled main-menu__contact-list set-m10">
					<li>
						<div class="language-menu">
							<a href="<?php echo "$nama_folder/anak_perusahaan_kami";?>" class="language-btn text-12">INDONESIA</a>
							<div class="text-white set-line">|</div>
							<a href="<?php echo "$nama_folder/en/anak_perusahaan_kami";?>" class="language-btn text-12 active">ENGLISH</a>
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
            <img src="<?php echo "$nama_folder";?>/assets/images/backgrounds/background-min.jpg" alt="" style="width: 100%;">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <h3>Our Subsidiaries</h3>
                <div class="thm-breadcrumb__inner">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="<?php echo "$nama_folder/en";?>">Home</a></li>
                        <li><span class="icon-angle-right"></span></li>
                        <li>Our Subsidiaries</li>
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
                            <li><a href="<?php echo "$nama_website/logo_kami";?>">Our Logo</a></li>
                            <li><a href="<?php echo "$nama_website/visi_misi";?>">Vision, Mission and Values</a></li>
                            <li><a href="<?php echo "$nama_website/peristiwa_penting";?>">Milestones</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_kepemilikan";?>">Ownership Structure</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_organisasi";?>">Organization Structure</a></li>
                            <li><a href="<?php echo "$nama_website/dewan_komisaris";?>">Board of Commissioners</a></li>
                            <li><a href="<?php echo "$nama_website/direksi";?>">Board of Directors</a></li>
                            <li><a href="<?php echo "$nama_website/struktur_group";?>">Group Structure</a></li>
                            <li class="active"><a href="<?php echo "$nama_website/anak_perusahaan_kami";?>">Our Subsidiaries</a></li>
                            <li><a href="<?php echo "$nama_website/penghargaan";?>">Awards & Recognition</a></li>
                            <li><a href="<?php echo "$nama_website/keanggotaan";?>">Membership</a></li>
                        </ul>
                    </div>
                </div>

                <!--Start Shop Details Page1 Img-->
                <div class="col-xl-8">
                    <section class="shop-details-page1 mb-5">
                        <div class="container">
                        <?php
                        $perusahaan = mysql_query("SELECT * FROM tabel_perusahaan");
                        while ($list_perusahaan = mysql_fetch_array($perusahaan))
                        {
                        ?>
                            <div class="shop-details-page1__img mb-5">
                                <div class="shop-details-page1__title">
                                    <h2 id="item-title"><?php echo "$list_perusahaan[title]";?></h2>
                                </div>
                                <div class="shop-details-page1__img-inner mb-3">
                                    
                                        <a data-fslightbox="gallery"
                                            href="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_perusahaan[gambar]";?>">
                                            <img src="<?php echo "$nama_folder";?>/images/about/<?php echo "$list_perusahaan[gambar]";?>"
                                                alt="" title="KLIK GAMBAR UNTUK LEBIH KELAS">
                                        </a>
                                    </div>
                                <div>
                                    <div class="shop-details-page1__text">
                                        <?php echo "$list_perusahaan[description_english]";?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </section>
                </div>

            </div>

        </div>

    </section>

